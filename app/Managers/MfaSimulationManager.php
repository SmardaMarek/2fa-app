<?php

declare(strict_types=1);

namespace App\Managers;

use App\Models\MfaSimulation;

class MfaSimulationManager
{
    public function createOrUpdate(int $userId, int $moduleId, string $status, string $scenarioType): MfaSimulation
    {
        return MfaSimulation::firstOrCreate(
            ['user_id' => $userId, 'module_id' => $moduleId],
            ['status' => $status, 'scenario_type' => $scenarioType]
        );
    }

    public function findByUserAndModule(int $userId, int $moduleId)
    {
        return MfaSimulation::where('user_id', $userId)
            ->where('module_id', $moduleId)
            ->first();
    }
}
