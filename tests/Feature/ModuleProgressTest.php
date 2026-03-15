<?php

use App\Models\Module;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

beforeEach(function () {
    $this->user = User::factory()->create([
        'google2fa_secret' => 'SECRETCODE',
        'google2fa_confirmed_at' => now(),
    ]);

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

    $this->question = Question::create([
        'module_id' => $this->module->id,
        'text' => 'Je SMS bezpečná?',
        'options' => ['a' => 'Ano', 'b' => 'Ne'],
        'correct_option' => 'b'
    ]);
    Model::reguard();
});

test('user can access theory page', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get('/module/sms-otp/theory');

    $response->assertOk();
});

test('user can complete theory and unlock simulation', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post('/module/sms-otp/theory/complete');

    $response->assertRedirect(route('module.implementation', $this->module));

    $progress = $this->user->progress()->where('module_id', $this->module->id)->first();
    expect($progress)->not->toBeNull();
    expect($progress->theory_completed)->toBeTrue();
});

test('user can access quiz page', function () {
    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->get('/module/sms-otp/quiz');

    $response->assertOk();
});

test('user can submit quiz and complete module', function () {
    $answers = [
        $this->question->id => 'b' // Správná odpověď
    ];

    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post('/module/sms-otp/quiz', [
            'answers' => $answers
        ]);

    $response->assertRedirect('/dashboard');
    $response->assertSessionHas('status');

    $progress = $this->user->progress()->where('module_id', $this->module->id)->first();
    expect($progress)->not->toBeNull();
    expect($progress->quiz_completed)->toBeTrue();
    expect($progress->completed_at)->not->toBeNull();
});

test('quiz submission fails with incorrect answers', function () {
    $answers = [
        $this->question->id => 'a' // Špatná odpověď
    ];

    $response = $this->actingAs($this->user)
        ->withSession(['mfa_verified' => true])
        ->post('/module/sms-otp/quiz', [
            'answers' => $answers
        ]);

    $response->assertSessionHas('error');
});
