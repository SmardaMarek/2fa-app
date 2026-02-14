<?php

use App\Http\Controllers\Mfa\DashboardController;
use App\Http\Controllers\Mfa\QuizController;
use App\Http\Controllers\Mfa\Simulation\TotpSimulationController;
use App\Http\Controllers\Mfa\TheoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('module/{module:slug}')->name('module.')->group(function () {
        Route::get('/theory', [TheoryController::class, 'show'])
            ->name('theory');

        Route::post('/theory/complete', [TheoryController::class, 'complete'])
            ->name('theory.complete');

        // Scénář A: Setup
        Route::get('/simulation/setup', [TotpSimulationController::class, 'setup'])->name('simulation.setup');
        Route::post('/simulation/setup', [TotpSimulationController::class, 'verifySetup'])->name('simulation.verify_setup');

        // Scénář B: Attack
        Route::get('/simulation/attack', [TotpSimulationController::class, 'attack'])->name('simulation.attack');
        Route::post('/simulation/attack', [TotpSimulationController::class, 'verifyAttack'])->name('simulation.verify_attack');

        Route::get('/implementation', [TheoryController::class, 'implementation'])
            ->name('implementation');

        // Quiz
        Route::get('/quiz', [QuizController::class, 'show'])->name('quiz');
        Route::post('/quiz', [QuizController::class, 'submit'])->name('quiz.submit');

    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
