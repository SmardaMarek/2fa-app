<?php

declare(strict_types=1);

namespace App\Enums;

enum ModulSlug: string
{
    case TOTP = 'totp-app';
    case SMS = 'sms-otp';
    case BIOMETRY = 'biometrics';
    case FIDO2 = 'fido2-key';

    /**
     * Vrátí lidsky čitelný název pro UI.
     */
    public function label(): string
    {
        return match ($this) {
            self::TOTP => 'TOTP',
            self::SMS => 'SMS OTP',
            self::BIOMETRY => 'Biometrie',
            self::FIDO2 => 'Fyzický klíč',
        };
    }
}
