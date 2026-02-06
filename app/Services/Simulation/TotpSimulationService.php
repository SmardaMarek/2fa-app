<?php

declare(strict_types=1);

namespace App\Services\Simulation;

use App\Managers\MfaSimulationManager;
use App\Managers\UserProgressManager;
use App\Models\MfaSimulation;
use App\Models\Module;
use App\Models\User;
use App\Services\UserProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FAQRCode\Exceptions\MissingQrCodeServiceException;
use PragmaRX\Google2FAQRCode\Google2FA;

class TotpSimulationService
{
    public function __construct(
        protected MfaSimulationManager $mfaSimulationManager,
        protected UserProgressManager $progressManger,
        protected Google2FA $google2fa,
        protected UserProgressService $userProgressService
    ) {}

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws MissingQrCodeServiceException
     * @throws InvalidCharactersException
     * @throws SecretKeyTooShortException
     */
    public function setup(Module $module): array
    {
        $user = Auth::user();
        $simulation = $this->mfaSimulationManager->createOrUpdate(
            $user->id,
            $module->id,
            MfaSimulation::STATUS_SETUP_PENDING,
            MfaSimulation::SCENARIO_TYPE_SETUP
        );

        $google2fa = new Google2FA;

        if (empty($simulation->state_data['secret'])) {
            $secret = $google2fa->generateSecretKey();
            $simulation->update(['state_data' => ['secret' => $secret]]);
        } else {
            $secret = $simulation->state_data['secret'];
        }

        $qrCodeSvg = $google2fa->getQRCodeInline(
            'MFA study application',
            $user->email,
            $secret
        );

        return [
            'qrCodeSvg' => $qrCodeSvg,
            'secret' => $secret,
        ];
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws SecretKeyTooShortException
     * @throws InvalidCharactersException
     */
    public function verifySetup(Request $request, Module $module): bool
    {
        $request->validate(['code' => 'required|digits:6']);

        $simulation = MfaSimulation::where('user_id', Auth::id())
            ->where('module_id', $module->id)
            ->firstOrFail();

        $google2fa = new Google2FA;

        return $google2fa->verifyKey($simulation->state_data['secret'], $request->code);
    }

    public function verifyPhishingHypothesis(User $user, Module $module, string $code): bool
    {
        $simulation = $this->mfaSimulationManager->findByUserAndModule($user->id, $module->id);

        if (! $simulation || empty($simulation->state_data['secret'])) {
            return false;
        }

        $isValid = $this->google2fa->verifyKey(
            $simulation->state_data['secret'],
            $code
        );

        if ($isValid) {
            $this->completeAttackPhase($user, $module);

            return true;
        }

        return false;
    }

    /**
     * Pomocná metoda pro zápis změn do DB
     */
    private function completeAttackPhase(User $user, Module $module): void
    {
        $this->userProgressService->completeSimulationAttackStep($module);

        $this->mfaSimulationManager->createOrUpdate(
            $user->id,
            $module->id,
            MfaSimulation::STATUS_COMPROMISED,
            MfaSimulation::SCENARIO_ATTACK
        );
    }
}
