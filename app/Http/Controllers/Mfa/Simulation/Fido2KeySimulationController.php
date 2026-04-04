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

class Fido2KeySimulationController extends Controller
{
    public function __construct(protected CodeSamplesService $codeSamplesService, protected UserProgressService $progressService
    ) {}

    public function attack(Module $module): View
    {
        return view('modules.simulation.fido2-key.attack', compact('module'));
    }

    public function setup(Module $module): View
    {
        return view('modules.simulation.fido2-key.setup', compact('module'));
    }

    public function lessons(Module $module): View
    {
        return view('modules.simulation.fido2-key.lesson', [
            'module' => $module,
            'codeSamples' => $this->codeSamplesService->getFidoLessonCodeSamples(),
        ]);
    }

    public function complete(Request $request, Module $module): RedirectResponse
    {
        $this->progressService->completeSimulationSetupStep($module);
        $this->progressService->completeSimulationAttackStep($module);

        return redirect()->route('module.quiz', ['module' => $module->slug]);
    }
}
