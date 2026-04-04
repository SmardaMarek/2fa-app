<?php

declare(strict_types=1);

namespace App\Managers;

use App\Models\MfaSimulation;
use Illuminate\Support\Facades\Auth;

class MfaSimulationManager
{
    public function createOrUpdate(int $userId, int $moduleId, string $status, string $scenarioType): MfaSimulation
    {
        abort_if($userId !== Auth::id(), 403);

        return MfaSimulation::updateOrCreate(
            ['user_id' => $userId, 'module_id' => $moduleId],
            ['status' => $status, 'scenario_type' => $scenarioType]
        );
    }

    public function findByUserAndModule(int $userId, int $moduleId): ?MfaSimulation
    {
        abort_if($userId !== Auth::id(), 403);

        return MfaSimulation::where('user_id', $userId)
            ->where('module_id', $moduleId)
            ->first();
    }
}
