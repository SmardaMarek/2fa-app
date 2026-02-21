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

    /**
     * KROK 1: Zobrazení formuláře pro prvotní nastavení/vyzkoušení
     */
    public function setup(Module $module)
    {
        return view('modules.simulation.otp.setup', compact('module'));
    }

    /**
     * KROK 1.1: Asynchronní vygenerování a odeslání SMS kódu
     */
    public function send(Module $module): JsonResponse
    {
        // Generujeme a ukládáme hash kódu přes naši dříve vytvořenou servisu
        $code = $this->smsService->generateAndDispatch(Auth::user());

        return response()->json([
            'message' => 'SMS byla odeslána na vaše zařízení.',
            'simulated_code' => $code, // V produkci kód NIKDY nevracíme, zde slouží pro UI simulátoru telefonu
        ]);
    }

    /**
     * KROK 1.2: Ověření zadaného kódu pro úspěšný scénář
     */
    public function verify(Request $request, Module $module)
    {
        $request->validate(['code' => 'required|digits:6']);

        $isValid = $this->smsService->verify(Auth::user(), $request->input('code'));

        if ($isValid) {
            // Zápis postupu studenta
            $this->progressService->completeSimulationSetupStep($module);

            // Přesun na Scénář B (Útok)
            return redirect()->route('module.sms.attack', ['module' => $module->slug])
                ->with('status', 'Ověření proběhlo úspěšně! Nyní si ukážeme, jak lze SMS metodu zneužít.');
        }

        return back()->withErrors(['code' => 'Neplatný nebo expirovaný kód. Zkuste to znovu.']);
    }

    /**
     * KROK 2: Zobrazení simulace útoku (Phishing / AitM)
     */
    public function attack(Module $module)
    {
        return view('modules.simulation.otp.attack', compact('module'));
    }

    /**
     * KROK 2.1: Ověření útoku (Student odesílá kód na "falešný" server)
     */
    public function verifyAttack(Request $request, Module $module)
    {
        $request->validate(['code' => 'required|digits:6']);

        // DIDAKTIKA: Útočník (tato metoda) přijal kód z podvodného formuláře
        // a okamžitě ho zkouší ověřit proti legitimní službě.
        $vulnerabilityConfirmed = $this->smsService->verify(Auth::user(), $request->input('code'));

        if ($vulnerabilityConfirmed) {
            // Útok byl úspěšný! SMS OTP neposkytuje ochranu proti phishingu (origin binding).
            return redirect()->route('module.sms.lessons', ['module' => $module->slug])
                ->with('status', 'Útok byl úspěšný. Útočník zachytil váš kód a získal přístup k účtu.');
        }

        return back()->withErrors(['code' => 'Kód není platný. Pro potvrzení zranitelnosti zadejte platný kód, který vám přišel v SMS.']);
    }

    /**
     * KROK 3: Ponaučení a vysvětlení hrozeb (Lessons learned)
     */
    public function lessons(Module $module)
    {
        return view('modules.simulation.otp.lesson', compact('module'));
    }

    /**
     * KROK 4: Dokončení simulace a přechod na kvíz
     */
    public function complete(Request $request, Module $module)
    {
        // Uzavření praktické části modulu
        $this->progressService->completeSimulationAttackStep($module);

        return redirect()->route('module.quiz', ['module' => $module->slug])
            ->with('status', 'Skvělá práce! Nyní ověříme vaše znalosti v závěrečném testu.');
    }
}
