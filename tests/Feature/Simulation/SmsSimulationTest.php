<?php

use App\Models\Module;
use App\Models\User;
use App\Services\Simulation\OtpSimulationService;
use Illuminate\Database\Eloquent\Model;

beforeEach(function () {
    $this->user = User::factory()->create([
        'google2fa_secret' => 'SECRETCODE',
        'google2fa_confirmed_at' => now(),
    ]);
    
    // Ujistíme se, že máme potřebný modul v db
    Model::unguard();
    $this->module = Module::firstOrCreate(
        ['slug' => 'sms-otp'],
        [
            'title' => 'Ověřování pomocí SMS',
            'description' => 'Test',
            'factor_type' => 'possession',
            'difficulty' => 'beginner',
            'is_active' => true,
        ]
    );
    Model::reguard();
});

test('authenticated user can access sms setup', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get(route('module.sms.setup', ['module' => $this->module->slug]));

    $response->assertOk();
    $response->assertSee('Ověřování pomocí SMS');
});

test('user can trigger sms send', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->postJson(route('module.sms.send', ['module' => $this->module->slug]));

    $response->assertOk();
    $response->assertJsonStructure(['message', 'simulated_code']);
});

test('user can verify sms with correct code', function () {
    $otpService = app(OtpSimulationService::class);
    $code = $otpService->generateAndDispatch($this->user);

    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post(route('module.sms.verify', ['module' => $this->module->slug]), [
            'code' => $code
        ]);

    $response->assertRedirect(route('module.sms.attack', ['module' => $this->module->slug]));
    $response->assertSessionHas('status');
});

test('sms verification fails with incorrect code', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post(route('module.sms.verify', ['module' => $this->module->slug]), [
            'code' => '999999' // Neexistující / špatný kód
        ]);

    $response->assertSessionHasErrors('code');
});

test('user can access sms attack page', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get(route('module.sms.attack', ['module' => $this->module->slug]));

    $response->assertOk();
});

test('user can verify sms attack with correct code', function () {
    $otpService = app(OtpSimulationService::class);
    $code = $otpService->generateAndDispatch($this->user);

    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post(route('module.sms.verify_attack', ['module' => $this->module->slug]), [
            'code' => $code
        ]);

    $response->assertRedirect(route('module.sms.lessons', ['module' => $this->module->slug]));
    $response->assertSessionHas('status');
});

test('sms attack fails with incorrect code', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post(route('module.sms.verify_attack', ['module' => $this->module->slug]), [
            'code' => '111111'
        ]);

    $response->assertSessionHasErrors('code');
});
