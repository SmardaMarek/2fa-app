<?php

use App\Http\Controllers\Mfa\DashboardController;
use App\Http\Controllers\Mfa\QuizController;
use App\Http\Controllers\Mfa\Simulation\BiometricsSimulationController;
use App\Http\Controllers\Mfa\Simulation\Fido2KeySimulationController;
use App\Http\Controllers\Mfa\Simulation\SmsSimulationController;
use App\Http\Controllers\Mfa\Simulation\TotpSimulationController;
use App\Http\Controllers\Mfa\TheoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'mfa'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('module/{module:slug}')->name('module.')->group(function () {
        // --- 1. OBECNÉ ROUTY (Sdílené) ---
        Route::get('/theory', [TheoryController::class, 'show'])->name('theory');
        Route::post('/theory/complete', [TheoryController::class, 'complete'])->name('theory.complete');
        Route::get('/implementation', [TheoryController::class, 'implementation'])->name('implementation');

        Route::get('/quiz', [QuizController::class, 'show'])->name('quiz');
        Route::post('/quiz', [QuizController::class, 'submit'])->name('quiz.submit');

        Route::get('/guide', [TheoryController::class, 'guide'])->name('guide');

        // --- 2. SPECIFICKÉ ROUTY SIMULACÍ ---

        // A) TOTP Simulace
        Route::prefix('totp')->name('totp.')->group(function () {
            Route::get('/setup', [TotpSimulationController::class, 'setup'])->name('setup');
            Route::post('/setup', [TotpSimulationController::class, 'verifySetup'])->name('verify_setup');

            Route::get('/attack', [TotpSimulationController::class, 'attack'])->name('attack');
            Route::post('/attack', [TotpSimulationController::class, 'verifyAttack'])->name('verify_attack');

            Route::get('/lessons', [TotpSimulationController::class, 'lessons'])->name('lessons');
            Route::post('/complete', [TotpSimulationController::class, 'complete'])->name('complete');
        });

        // B) SMS OTP Simulace
        Route::prefix('sms')->name('sms.')->group(function () {
            Route::get('/setup', [SmsSimulationController::class, 'setup'])->name('setup');
            Route::post('/send', [SmsSimulationController::class, 'send'])->middleware('throttle:5,1')->name('send');
            Route::post('/verify', [SmsSimulationController::class, 'verify'])->middleware('throttle:5,1')->name('verify');

            Route::get('/attack', [SmsSimulationController::class, 'attack'])->name('attack');
            Route::post('/attack', [SmsSimulationController::class, 'verifyAttack'])->middleware('throttle:5,1')->name('verify_attack');

            Route::get('/lessons', [SmsSimulationController::class, 'lessons'])->name('lessons');
            Route::post('/complete', [SmsSimulationController::class, 'complete'])->name('complete');
        });

        // C) Biometrie Simulace
        Route::prefix('biometrics')->name('biometrics.')->group(function () {
            Route::get('/setup', [BiometricsSimulationController::class, 'setup'])->name('setup');
            Route::get('/attack', [BiometricsSimulationController::class, 'attack'])->name('attack');
            Route::get('/attack-2', [BiometricsSimulationController::class, 'attack2'])->name('attack2');
            Route::get('/lessons', [BiometricsSimulationController::class, 'lessons'])->name('lessons');
            Route::post('/complete', [BiometricsSimulationController::class, 'complete'])->name('complete');
        });

        // D) Fyzický Klíč Simulace
        Route::prefix('fido2')->name('fido2.')->group(function () {
            Route::get('/setup', [Fido2KeySimulationController::class, 'setup'])->name('setup');
            Route::get('/attack', [Fido2KeySimulationController::class, 'attack'])->name('attack');
            Route::get('/lessons', [Fido2KeySimulationController::class, 'lessons'])->name('lessons');
            Route::post('/complete', [Fido2KeySimulationController::class, 'complete'])->name('complete');
        });

    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/mfa/setup', [\App\Http\Controllers\Auth\MfaController::class, 'setup'])->name('mfa.setup');
    Route::post('/mfa/setup', [\App\Http\Controllers\Auth\MfaController::class, 'verifySetup'])->middleware('throttle:5,1')->name('mfa.verify_setup');
    Route::get('/mfa/challenge', [\App\Http\Controllers\Auth\MfaController::class, 'challenge'])->name('mfa.challenge');
    Route::post('/mfa/challenge', [\App\Http\Controllers\Auth\MfaController::class, 'verify'])->middleware('throttle:5,1')->name('mfa.verify');
});

require __DIR__.'/auth.php';
