<?php

declare(strict_types=1);

namespace App\Managers;

use App\Models\UserProgress;

class UserProgressManager
{
    public function createOrUpdate(int $moduleId, int $userId, string $stepName, bool $status): UserProgress
    {
        return UserProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'module_id' => $moduleId,
            ],
            [$stepName => $status]
        );
    }

    public function markAsCompleted(int $moduleId, int $userId): void
    {
        UserProgress::updateOrCreate(
            ['module_id' => $moduleId, 'user_id' => $userId],
            ['completed_at' => now()]
        );
    }
}
