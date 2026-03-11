<?php

use App\Models\User;
use PragmaRX\Google2FA\Google2FA;

test('mfa is required for dashboard if not verified', function () {
    $user = User::factory()->create([
        'google2fa_secret' => 'SECRETCODE',
        'google2fa_confirmed_at' => now(),
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect('/mfa/challenge');
});

test('mfa setup is required if not enabled', function () {
    $user = User::factory()->create([
        'google2fa_secret' => null,
        'google2fa_confirmed_at' => null,
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect('/mfa/setup');
});

test('user can access dashboard after mfa challenge', function () {
    $user = User::factory()->create([
        'google2fa_secret' => 'SECRETCODE',
        'google2fa_confirmed_at' => now(),
    ]);

    $response = $this->actingAs($user)
                     ->withSession(['mfa_verified' => true])
                     ->get('/dashboard');

    $response->assertOk();
});

test('user can verify mfa challenge', function () {
    $google2fa = new Google2FA();
    $secret = $google2fa->generateSecretKey();

    $user = User::factory()->create([
        'google2fa_secret' => $secret,
        'google2fa_confirmed_at' => now(),
    ]);

    $validCode = $google2fa->getCurrentOtp($secret);

    $response = $this->actingAs($user)->post('/mfa/challenge', [
        'code' => $validCode
    ]);

    $response->assertRedirect('/dashboard');
    $response->assertSessionHas('mfa_verified', true);
});

test('user can verify initial mfa setup', function () {
    $user = User::factory()->create([
        'google2fa_secret' => null,
        'google2fa_confirmed_at' => null,
    ]);

    $google2fa = new Google2FA();
    $secret = $google2fa->generateSecretKey();
    $validCode = $google2fa->getCurrentOtp($secret);

    $response = $this->actingAs($user)
                     ->withSession(['google2fa_secret' => $secret])
                     ->post('/mfa/setup', [
                         'code' => $validCode
                     ]);

    $response->assertRedirect('/dashboard');
    $response->assertSessionHas('mfa_verified', true);

    $user->refresh();
    expect($user->google2fa_secret)->toBe($secret);
    expect($user->google2fa_confirmed_at)->not->toBeNull();
});
