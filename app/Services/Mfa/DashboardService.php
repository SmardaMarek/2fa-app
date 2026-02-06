<?php

declare(strict_types=1);

namespace App\Services\Mfa;

use App\Models\Module;
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
}
