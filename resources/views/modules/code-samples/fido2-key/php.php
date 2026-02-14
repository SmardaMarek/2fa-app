<?php
declare(strict_types=1);

namespace App\Services\Mfa;

use lbuchs\WebAuthn\WebAuthn;
use Exception;

class WebAuthnService
{
    private WebAuthn $webauthn;

    public function __construct()
    {
        // Konfigurace Relying Party (tvá aplikace)
        // ID musí odpovídat doméně, jinak zasáhne "Origin Binding" a autentizace selže.
        $this->webauthn = new WebAuthn('MFA-Vyuka', 'localhost');
    }

    /**
     * 1. KROK: Registrace (Uložení nového klíče)
     * Zpracuje data z klíče a vrátí veřejný klíč pro uložení do DB.
     */
    public function processRegistration(string $attestationObject, string $clientDataJSON, string $challenge): array
    {
        try {
            $data = $this->webauthn->processCreate(
                base64_decode($attestationObject),
                base64_decode($clientDataJSON),
                $challenge
            );

            return [
                'publicKey' => $data->credentialPublicKey,
                'credentialId' => $data->credentialId,
            ];
        } catch (Exception $e) {
            throw new Exception("Registrace klíče selhala: " . $e->getMessage());
        }
    }

    /**
     * 2. KROK: Autentizace (Ověření existujícího klíče)
     * Ověří, zda podpis odpovídá výzvě a uloženému veřejnému klíči.
     */
    public function validateAssertion(
        string $clientData,
        string $authenticatorData,
        string $signature,
        string $publicKey,
        string $challengeFromSession
    ): bool {
        try {
            return $this->webauthn->processGet(
                base64_decode($clientData),
                base64_decode($authenticatorData),
                base64_decode($signature),
                $publicKey,
                $challengeFromSession
            );
        } catch (Exception $e) {
            // V produkci logovat: $e->getMessage()
            return false;
        }
    }
}
