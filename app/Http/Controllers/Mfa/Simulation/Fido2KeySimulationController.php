<?php

namespace App\Http\Controllers\Mfa\Simulation;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Services\Simulation\CodeSamplesService;
use App\Services\UserProgressService;
use Illuminate\Http\Request;

class Fido2KeySimulationController extends Controller
{
    public function __construct(protected CodeSamplesService $codeSamplesService, protected UserProgressService $progressService
    ) {}

    public function attack(Module $module)
    {
        $this->progressService->completeSimulationSetupStep($module);

        return view('modules.simulation.fido2-key.attack', compact('module'));
    }

    public function setup(Module $module)
    {
        return view('modules.simulation.fido2-key.setup', compact('module'));
    }

    public function lessons(Module $module)
    {
        $this->progressService->completeSimulationAttackStep($module);

        return view('modules.simulation.fido2-key.lesson', [
            'module' => $module,
            'codeSamples' => $this->codeSamplesService->getFidoLessonCodeSamples(),
        ]);
    }

    public function complete(Request $request, Module $module)
    {
        return redirect()->route('module.quiz', ['module' => $module->slug]);
    }
}
