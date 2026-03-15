<?php

use App\Models\Module;
use App\Models\User;
use App\Models\MfaSimulation;
use Illuminate\Database\Eloquent\Model;
use PragmaRX\Google2FA\Google2FA;

beforeEach(function () {
    $this->user = User::factory()->create([
        'google2fa_secret' => 'ABCDEFGHIJKLMNOP',
        'google2fa_confirmed_at' => now(),
    ]);

    Model::unguard();
    $this->module = Module::firstOrCreate(
        ['slug' => 'totp-app'],
        [
            'title' => 'Ověřování pomocí TOTP',
            'description' => 'Test',
            'factor_type' => 'possession',
            'difficulty' => 'intermediate',
            'is_active' => true,
        ]
    );
    Model::reguard();
});

test('authenticated user can access totp setup', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get(route('module.totp.setup', ['module' => $this->module->slug]));

    $response->assertOk();
    $response->assertSee('Ověřování pomocí TOTP');
});

test('user can verify totp setup with correct generated code', function () {
    // Inicializujeme simulaci zavoláním setup endpointu
    $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get(route('module.totp.setup', ['module' => $this->module->slug]));

    $simulation = MfaSimulation::where('user_id', $this->user->id)->where('module_id', $this->module->id)->first();
    $secret = $simulation->state_data['secret'];

    $google2fa = new Google2FA();
    $validCode = $google2fa->getCurrentOtp($secret);

    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post(route('module.totp.verify_setup', ['module' => $this->module->slug]), [
            'code' => $validCode
        ]);

    $response->assertRedirect(route('module.totp.attack', ['module' => $this->module->slug]));
    $response->assertSessionHas('status');
});

test('totp setup verification fails with incorrect code', function () {
    // Inicializujeme simulaci
    $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get(route('module.totp.setup', ['module' => $this->module->slug]));

    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post(route('module.totp.verify_setup', ['module' => $this->module->slug]), [
            'code' => '999999'
        ]);

    $response->assertSessionHasErrors('code');
});

test('user can access totp attack page', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get(route('module.totp.attack', ['module' => $this->module->slug]));

    $response->assertOk();
});

test('user can verify totp attack with correct code', function () {
    $google2fa = new Google2FA();
    $secret = $google2fa->generateSecretKey();
    
    MfaSimulation::create([
        'user_id' => $this->user->id,
        'module_id' => $this->module->id,
        'status' => MfaSimulation::STATUS_SETUP_PENDING,
        'scenario_type' => MfaSimulation::SCENARIO_ATTACK,
        'state_data' => ['secret' => $secret]
    ]);

    $validCode = $google2fa->getCurrentOtp($secret);

    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post(route('module.totp.verify_attack', ['module' => $this->module->slug]), [
            'code' => $validCode
        ]);

    $response->assertRedirect(route('module.totp.lessons', ['module' => $this->module->slug]));
    $response->assertSessionHas('status');
});

test('totp attack fails with incorrect code (time drift simulation)', function () {
    $google2fa = new Google2FA();
    $secret = $google2fa->generateSecretKey();
    
    MfaSimulation::create([
        'user_id' => $this->user->id,
        'module_id' => $this->module->id,
        'status' => MfaSimulation::STATUS_SETUP_PENDING,
        'scenario_type' => MfaSimulation::SCENARIO_ATTACK,
        'state_data' => ['secret' => $secret]
    ]);

    // Kód bez časového posunu (mělo by selhat, protože po útočníkovi vyžadujeme 'budoucí' kód nebo jiný mechanismus dle zadání)
    // Tady simulujeme, že útočník zadá prostě špatný kód
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post(route('module.totp.verify_attack', ['module' => $this->module->slug]), [
            'code' => '111111'
        ]);

    $response->assertSessionHasErrors('code');
});
