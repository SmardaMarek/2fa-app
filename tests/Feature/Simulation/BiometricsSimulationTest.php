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
        ['slug' => 'biometrics'],
        [
            'title' => 'Biometrie',
            'description' => 'Test',
            'factor_type' => 'inherence',
            'difficulty' => 'intermediate',
            'is_active' => true,
        ]
    );
    Model::reguard();
});

test('authenticated user can access biometrics setup', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get(route('module.biometrics.setup', ['module' => $this->module->slug]));

    $response->assertOk();
    $response->assertSee('Biometrie');
});

test('user can access biometrics attack page', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get(route('module.biometrics.attack', ['module' => $this->module->slug]));

    $response->assertOk();
});

test('user can complete biometrics module', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post(route('module.biometrics.complete', ['module' => $this->module->slug]));

    $response->assertRedirect(route('module.quiz', ['module' => $this->module->slug]));
});
