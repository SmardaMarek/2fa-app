<?php

declare(strict_types=1);

namespace App\Services\Mfa;

use App\Models\Module;
use App\Models\UserProgress;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getActiveModulesForUser(): Collection
    {
        return Module::query()
            ->where('is_active', true)
            ->with(['progress' => function ($query) {
                $query->where('user_id', Auth::id());
            }])
            ->get();
    }

    public function getProgressForUser(): array
    {
        $userId = Auth::id();

        $userProgressRecords = UserProgress::where('user_id', $userId)
            ->with('module:id,slug')
            ->get();

        $progress = [];

        foreach ($userProgressRecords as $record) {
            $completedSteps = 0;

            if ($record->theory_completed) {
                $completedSteps++;
            }
            if ($record->simulation_setup_completed) {
                $completedSteps++;
            }
            if ($record->simulation_attack_completed) {
                $completedSteps++;
            }
            if ($record->quiz_completed) {
                $completedSteps++;
            }

            if ($record->module) {
                $progress[$record->module->slug] = $completedSteps;
            }
        }

        return $progress;
    }
}
