<?php

declare(strict_types=1);

namespace App\Http\Controllers\Mfa\Simulation;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Services\Simulation\TotpSimulationService;
use App\Services\UserProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FAQRCode\Exceptions\MissingQrCodeServiceException;

class TotpSimulationController extends Controller
{
    public function __construct(
        private TotpSimulationService $simulationService,
        private UserProgressService $progressService
    ) {}

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws MissingQrCodeServiceException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     */
    public function setup(Module $module)
    {
        $processedData = $this->simulationService->setup($module);
        $qrCodeSvg = $processedData['qrCodeSvg'];
        $secret = $processedData['secret'];

        return view('modules.simulation.totp.setup', compact('module', 'qrCodeSvg', 'secret'));
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws SecretKeyTooShortException
     * @throws InvalidCharactersException
     */
    public function verifySetup(Request $request, Module $module)
    {

        $valid = $this->simulationService->verifySetup($request, $module);

        if ($valid) {
            $this->progressService->completeSimulationSetupStep($module);

            return redirect()->route('module.simulation.attack', $module)
                ->with('status', 'Nastavení úspěšné! Nyní se prosím znovu přihlaste pro potvrzení.');
        }

        return back()->withErrors(['code' => 'Kód nesouhlasí, zkuste to znovu.']);
    }

    public function attack(Module $module)
    {
        return view('modules.simulation.totp.attack', compact('module'));
    }

    public function verifyAttack(Request $request, Module $module)
    {
        $request->validate(['code' => 'required|digits:6']);

        $vulnerabilityConfirmed = $this->simulationService->verifyPhishingHypothesis(
            Auth::user(),
            $module,
            $request->input('code')
        );

        if ($vulnerabilityConfirmed) {
            return redirect()->route('dashboard') // Nebo na kvíz
                ->with('status', 'Výborně! Hypotéza potvrzena: Protokol TOTP neověřuje původ domény a kód byl přijat.');
        }

        return back()->withErrors(['code' => 'Kód není platný. Pro potvrzení zranitelnosti musíte zadat platný kód z vaší aplikace.']);

    }
}
