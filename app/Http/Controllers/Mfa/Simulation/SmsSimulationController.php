<?php

declare(strict_types=1);

namespace App\Http\Controllers\Mfa\Simulation;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Services\Simulation\OtpSimulationService;
use App\Services\UserProgressService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmsSimulationController extends Controller
{
    public function __construct(
        private OtpSimulationService $smsService,
        private UserProgressService $progressService
    ) {}

    public function setup(Module $module)
    {
        return view('modules.simulation.otp.setup', compact('module'));
    }

    public function send(Module $module): JsonResponse
    {
        $code = $this->smsService->generateAndDispatch(Auth::user());

        $response = [
            'message' => 'SMS byla odeslána na vaše zařízení.',
        ];

        // V produkci kód NIKDY nevracíme, zde slouží pro UI simulátoru telefonu
        if (!app()->environment('production')) {
            $response['simulated_code'] = $code;
        }

        return response()->json($response);
    }

    public function verify(Request $request, Module $module)
    {
        $request->validate(['code' => 'required|digits:6']);

        $isValid = $this->smsService->verify(Auth::user(), $request->input('code'));

        if ($isValid) {
            $this->progressService->completeSimulationSetupStep($module);

            return redirect()->route('module.sms.attack', ['module' => $module->slug])
                ->with('status', 'Ověření proběhlo úspěšně! Nyní si ukážeme, jak lze SMS metodu zneužít.');
        }

        return back()->withErrors(['code' => 'Neplatný nebo expirovaný kód. Zkuste to znovu.']);
    }

    public function attack(Module $module)
    {
        return view('modules.simulation.otp.attack', compact('module'));
    }

    public function verifyAttack(Request $request, Module $module)
    {
        $request->validate(['code' => 'required|digits:6']);

        $isValid = $this->smsService->verify(Auth::user(), $request->input('code'));

        if ($isValid) {
            $this->progressService->completeSimulationAttackStep($module);

            return redirect()->route('module.sms.lessons', ['module' => $module->slug])
                ->with('status', 'Útok dokončen! Číslo bylo úspěšně zneužito k ovládnutí účtu.');
        }

        return back()->withErrors(['code' => 'Kód už vypršel. Útočník musí být rychlejší!']);
    }

    public function lessons(Module $module)
    {
        return view('modules.simulation.otp.lesson', compact('module'));
    }

    public function complete(Request $request, Module $module)
    {
        $this->progressService->completeSimulationAttackStep($module);

        return redirect()->route('module.quiz', ['module' => $module->slug])
            ->with('status', 'Skvělá práce! Nyní ověříme vaše znalosti v závěrečném testu.');
    }
}
