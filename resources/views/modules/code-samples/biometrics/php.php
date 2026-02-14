<?php
declare(strict_types=1);

namespace App\Services\Mfa;

use lbuchs\WebAuthn\WebAuthn;

class BiometricService
{
    /**
     * Hlavní metoda pro ověření biometrického přihlášení.
     */
    public function verifyBiometricAssertion($assertion, $storedPublicKey, $challenge): bool
    {
        // 1. Kontrola příznaku User Verified (biometrie proběhla na zařízení)
        // Biometrie funguje jako lokální "odemknutí" kryptografického klíče.
        $authenticatorData = $assertion->getAuthenticatorData();

        if (!$authenticatorData->isUserVerified()) {
            return false;
        }

        // 2. Volání interní metody pro ověření kryptografického podpisu
        return $this->validateSignature($assertion, $storedPublicKey, $challenge);
    }

    /**
     * Validace kryptografického podpisu (vlastní FIDO2 operace).
     */
    private function validateSignature($assertion, $publicKey, $challenge): bool
    {
        // Relying Party (doména aplikace) - kritické pro Origin Binding.
        $webauthn = new WebAuthn('MujWeb.cz', 'https://mujweb.cz');

        try {
            // Server ověří, zda podpis vytvořený biometrickým senzorem
            // souhlasí s uloženým veřejným klíčem a výzvou.
            return $webauthn->processGet(
                $assertion->getClientDataJSON(),
                $assertion->getAuthenticatorData(),
                $assertion->getSignature(),
                $publicKey,
                $challenge
            );
        } catch (\Exception $e) {
            // Logování chyby (např. neshoda domény nebo neplatný podpis)
            return false;
        }
    }
}
