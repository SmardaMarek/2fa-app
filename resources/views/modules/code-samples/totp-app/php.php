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
     * Ověří, zda zadaný OTP kód odpovídá tajnému klíči uživatele.
     */
    public function verify(string $userSecret, string $otpCode): bool
    {
        // Window 1 znamená toleranci +/- 30s pro případ mírné desynchronizace času
        return $this->google2fa->verifyKey($userSecret, $otpCode, 1);
    }
}
