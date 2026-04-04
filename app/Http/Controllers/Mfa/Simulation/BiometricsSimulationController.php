<?php

declare(strict_types=1);

namespace App\Http\Controllers\Mfa\Simulation;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Services\Simulation\CodeSamplesService;
use App\Services\UserProgressService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BiometricsSimulationController extends Controller
{
    public function __construct(protected CodeSamplesService $codeSamplesService, protected UserProgressService $progressService
    ) {}

    public function attack(Module $module): View
    {
        return view('modules.simulation.biometrics.attack', compact('module'));
    }

    public function attack2(Module $module): View
    {
        return view('modules.simulation.biometrics.attack2', compact('module'));
    }

    public function setup(Module $module): View
    {
        return view('modules.simulation.biometrics.setup', compact('module'));
    }

    public function lessons(Module $module): View
    {
        return view('modules.simulation.biometrics.lesson', [
            'module' => $module,
            'codeSamples' => $this->codeSamplesService->getBiometricsLessonCodeSamples(),
        ]);
    }

    public function complete(Request $request, Module $module): RedirectResponse
    {
        $this->progressService->completeSimulationSetupStep($module);
        $this->progressService->completeSimulationAttackStep($module);

        return redirect()->route('module.quiz', ['module' => $module->slug]);
    }
}
