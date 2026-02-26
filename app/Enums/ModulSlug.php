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

    /**
     * Vrátí název routy pro Setup fázi simulace.
     */
    public function getSimulationSetupRoute(): string
    {
        return match ($this) {
            self::TOTP => 'module.totp.setup',
            self::SMS => 'module.sms.setup',
            self::BIOMETRY => 'module.biometrics.setup',
            // self::FIDO2 => 'module.fido2.setup',
            default => 'dashboard',
        };
    }

    /**
     * Vrátí název routy pro Attack fázi simulace.
     */
    public function getSimulationAttackRoute(): string
    {
        return match ($this) {
            self::TOTP => 'module.totp.attack',
            self::SMS => 'module.sms.attack',
            self::BIOMETRY => 'module.biometrics.attack',
            // self::FIDO2 => 'module.fido2.attack',
            default => 'dashboard',
        };
    }

    /**
     * Vrátí název routy pro Lessons fázi simulace.
     */
    public function getSimulationLessonsRoute(): string
    {
        return match ($this) {
            self::TOTP => 'module.totp.lessons',
            self::SMS => 'module.sms.lessons',
            self::BIOMETRY => 'module.biometrics.lessons',
            // self::FIDO2 => 'module.fido2.lessons',
            default => 'dashboard',
        };
    }
}
