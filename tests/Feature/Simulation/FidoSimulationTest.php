<?php

use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

beforeEach(function () {
    $this->user = User::factory()->create([
        'google2fa_secret' => 'SECRETCODE',
        'google2fa_confirmed_at' => now(),
    ]);

    Model::unguard();
    $this->module = Module::firstOrCreate(
        ['slug' => 'fido2-key'],
        [
            'title' => 'Fyzický klíč FIDO2',
            'description' => 'Test',
            'factor_type' => 'possession',
            'difficulty' => 'advanced',
            'is_active' => true,
        ]
    );
    Model::reguard();
});

test('authenticated user can access fido2 setup', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get(route('module.fido2.setup', ['module' => $this->module->slug]));

    $response->assertOk();
    $response->assertSee('Fyzický klíč FIDO2');
});

test('user can access fido2 attack page', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get(route('module.fido2.attack', ['module' => $this->module->slug]));

    $response->assertOk();
});

test('user can complete fido2 module', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post(route('module.fido2.complete', ['module' => $this->module->slug]));

    $response->assertRedirect(route('module.quiz', ['module' => $this->module->slug]));
});
