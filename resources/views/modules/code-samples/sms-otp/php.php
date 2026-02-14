<?php
declare(strict_types=1);

namespace App\Services\Mfa;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
class SmsOtpService
{
    /**
     * Generuje 6místný kód a simuluje odeslání přes SMS bránu.
     */
    public function sendOtp(string $phoneNumber): void
    {
        // Generování náhodného číselného kódu
        $otpCode = (string) random_int(100000, 999999);

        // Uložení do cache na 5 minut (časově omezená platnost)
        Cache::put("sms_otp_{$phoneNumber}", $otpCode, now()->addMinutes(5));

        // Zde by následovalo volání API poskytovatele (např. Twilio)
        Log::info("SMS OTP pro {$phoneNumber}: {$otpCode}");
    }

    /**
     * Ověření zadaného kódu proti uložené hodnotě.
     */
    public function verify(string $phoneNumber, string $enteredCode): bool
    {
        $storedCode = Cache::get("sms_otp_{$phoneNumber}");

        // Porovnání kódů a zajištění jednorázovosti
        if ($storedCode && hash_equals($storedCode, $enteredCode)) {
            Cache::forget("sms_otp_{$phoneNumber}");
            return true;
        }

        return false;
    }
}
