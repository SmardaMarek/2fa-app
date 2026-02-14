<?php

declare(strict_types=1);

namespace App\Services\Mfa;

use PragmaRX\Google2FA\Google2FA;

class TotpAuthenticator
{
    protected $google2fa;

    public function __construct(Google2FA $google2fa)
    {
        $this->google2fa = $google2fa;
    }

    /**
     * 1. KROK: Registrace - vygenerování tajného klíče (seedu)
     */
    public function generateSecretKey(): string
    {
        // Vygeneruje bezpečný náhodný klíč v Base32 (např. K6UVX7XJ7X...)
        return $this->google2fa->generateSecretKey();
    }

    /**
     * 2. KROK: Příprava pro klienta - URL pro QR kód
     */
    public function getQrCodeUrl(string $userEmail, string $secret): string
    {
        // Vytvoří standardizované otpauth:// URL, které aplikace (Google Authenticator)
        // zpracuje a začne podle něj generovat kódy.
        return $this->google2fa->getQRCodeUrl(
            'MFA-Vyuka',
            $userEmail,
            $secret
        );
    }

    /**
     * 3. KROK: Autentizace - ověření kódu
     */
    public function verify(string $userSecret, string $otpCode): bool
    {
        // Window 1 znamená toleranci +/- 30s pro případ mírné desynchronizace času.
        // Algoritmus vypočítá kód pro aktuální čas a porovná jej se vstupem uživatele.
        return $this->google2fa->verifyKey($userSecret, $otpCode, 1);
    }
}
