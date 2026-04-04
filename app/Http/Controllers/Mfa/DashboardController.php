<?php

declare(strict_types=1);

namespace App\Http\Controllers\Mfa;

use App\Http\Controllers\Controller;
use App\Services\Mfa\DashboardService;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService) {}

    public function index()
    {
        $modules = $this->dashboardService->getActiveModulesForUser();
        $progress = $this->dashboardService->getProgressForUser();

        return view('dashboard', [
            'modules' => $modules,
            'progress' => $progress,
        ]);
    }
}
