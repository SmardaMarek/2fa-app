<?php

declare(strict_types=1);

namespace App\Services\Mfa;

use App\Enums\ModulSlug;
use App\Models\Module;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $userProgressRecords = DB::table('user_progress')
            ->where('user_id', $userId)
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

            $moduleSlug = $this->mapModuleIdToSlug($record->module_id);

            if ($moduleSlug) {
                $progress[$moduleSlug] = $completedSteps;
            }
        }

        return $progress;
    }

    private function mapModuleIdToSlug(int $moduleId): ?string
    {
        return match ($moduleId) {
            1 => ModulSlug::SMS->value,
            2 => ModulSlug::TOTP->value,
            3 => ModulSlug::FIDO2->value,
            4 => ModulSlug::BIOMETRY->value,
            default => null,
        };
    }
}
