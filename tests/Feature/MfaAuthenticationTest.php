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

test('user cannot verify mfa challenge with invalid code', function () {
    $google2fa = new Google2FA();
    $secret = $google2fa->generateSecretKey();

    $user = User::factory()->create([
        'google2fa_secret' => $secret,
        'google2fa_confirmed_at' => now(),
    ]);

    $response = $this->actingAs($user)->post('/mfa/challenge', [
        'code' => '999999' // Neplatný kód
    ]);

    $response->assertSessionHasErrors('code');
    $response->assertSessionMissing('mfa_verified');
});

test('user cannot verify initial mfa setup with invalid code', function () {
    $user = User::factory()->create([
        'google2fa_secret' => null,
        'google2fa_confirmed_at' => null,
    ]);

    $google2fa = new Google2FA();
    $secret = $google2fa->generateSecretKey();

    $response = $this->actingAs($user)
                     ->withSession(['google2fa_secret' => $secret])
                     ->post('/mfa/setup', [
                         'code' => '999999' // Neplatný kód
                     ]);

    $response->assertSessionHasErrors('code');
    $response->assertSessionMissing('mfa_verified');

    $user->refresh();
    expect($user->google2fa_confirmed_at)->toBeNull();
});

test('mfa challenge is rate limited after 5 failed attempts', function () {
    $google2fa = new Google2FA();
    $secret = $google2fa->generateSecretKey();

    $user = User::factory()->create([
        'google2fa_secret' => $secret,
        'google2fa_confirmed_at' => now(),
    ]);

    // 5 neúspěšných pokusů
    for ($i = 0; $i < 5; $i++) {
        $this->actingAs($user)->post('/mfa/challenge', [
            'code' => '000000',
        ]);
    }

    // 6. pokus musí vrátit 429 (Too Many Requests)
    $response = $this->actingAs($user)->post('/mfa/challenge', [
        'code' => '000000',
    ]);

    $response->assertStatus(429);
});

test('same totp code cannot be used twice (replay attack)', function () {
    $google2fa = new Google2FA();
    $secret = $google2fa->generateSecretKey();

    $user = User::factory()->create([
        'google2fa_secret' => $secret,
        'google2fa_confirmed_at' => now(),
    ]);

    $validCode = $google2fa->getCurrentOtp($secret);

    // První použití – úspěch
    $response = $this->actingAs($user)->post('/mfa/challenge', [
        'code' => $validCode,
    ]);
    $response->assertRedirect('/dashboard');
    $response->assertSessionHas('mfa_verified', true);

    $lastTimestamp = session('mfa_last_timestamp');
    expect($lastTimestamp)->not->toBeNull();

    // Druhé použití stejného kódu – musí selhat
    $response2 = $this->actingAs($user)
        ->withSession([
            'mfa_verified' => false,
            'mfa_last_timestamp' => $lastTimestamp,
        ])
        ->post('/mfa/challenge', [
            'code' => $validCode,
        ]);

    $response2->assertSessionHasErrors('code');
});
