<?php

namespace App\Http\Controllers\Mfa\Simulation;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Services\Simulation\BiometricsSimulationService;
use App\Services\UserProgressService;
use Illuminate\Http\Request;

class BiometricsSimulationController extends Controller
{
    public function __construct(protected BiometricsSimulationService $simulationService, protected UserProgressService $progressService
    ) {}

    public function attack(Module $module)
    {
        $this->progressService->completeSimulationSetupStep($module);

        return view('modules.simulation.biometrics.attack', compact('module'));
    }

    public function setup(Module $module)
    {
        return view('modules.simulation.biometrics.setup', compact('module'));
    }

    public function lessons(Module $module)
    {
        $this->progressService->completeSimulationAttackStep($module);

        return view('modules.simulation.biometrics.lesson', [
            'module' => $module,
            'codeSamples' => $this->simulationService->getLessonCodeSamples(),
        ]);
    }

    public function complete(Request $request, Module $module)
    {
        return redirect()->route('module.quiz', ['module' => $module->slug]);
    }
}
