<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Cache;

function verifyTotp($user, string $otpCode, $google2fa): bool
{
    // 1. Vytvoření unikátního klíče pro Cache (ID uživatele + konkrétní OTP kód)
    $cacheKey = 'totp_used_'.$user->id.'_'.$otpCode;

    // 2. OBRANA PROTI REPLAY ÚTOKU: Zjištění, zda kód už nebyl použit
    if (Cache::has($cacheKey)) {
        // Kód je sice matematicky správně, ale už ho někdo v tomto okně použil!
        return false;
    }

    // 3. Standardní ověření (matematický výpočet)
    $isValid = $google2fa->verifyKey($user->totp_secret, $otpCode);

    if ($isValid) {
        // 4. Přihlášení je úspěšné. OKAMŽITĚ kód zneplatníme pro další použití.
        // Uložíme ho do Cache na dobu jeho teoretické platnosti (např. 1 minutu).
        Cache::put($cacheKey, true, now()->addMinutes(1));

        return true;
    }

    return false;
}
