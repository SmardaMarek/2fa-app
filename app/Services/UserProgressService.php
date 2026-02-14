<?php

declare(strict_types=1);

namespace App\Services;

use App\Managers\UserProgressManager;
use App\Models\Module;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Auth;

class UserProgressService
{
    public function __construct(private UserProgressManager $progressManager) {}

    public function completeSimulationSetupStep(Module $module): void
    {

        $this->progressManager->createOrUpdate(
            $module->id,
            Auth::id(),
            UserProgress::SIMULATION_SETUP_STEP,
            true
        );
    }

    public function completeSimulationAttackStep(Module $module): void
    {
        $this->progressManager->createOrUpdate(
            $module->id,
            Auth::id(),
            UserProgress::SIMULATION_ATTACK_STEP,
            true
        );
    }

    public function completeQuizStep(Module $module): void
    {
        $this->progressManager->createOrUpdate(
            $module->id,
            Auth::id(),
            UserProgress::QUIZ_STEP,
            true
        );

        $this->progressManager->markAsCompleted(
            $module->id,
            Auth::id()
        );
    }
}
