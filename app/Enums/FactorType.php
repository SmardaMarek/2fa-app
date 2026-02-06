<?php

declare(strict_types=1);

namespace App\Enums;

enum FactorType: string
{
    case Knowledge = 'knowledge';   // Něco, co vím (Heslo, PIN)
    case Possession = 'possession'; // Něco, co mám (Mobil, YubiKey)
    case Inherence = 'inherence';   // Něco, co jsem (Otisk, Tvář)

    public function label(): string
    {
        return match ($this) {
            self::Knowledge => 'Znalost (Something you know)',
            self::Possession => 'Vlastnictví (Something you have)',
            self::Inherence => 'Inherence (Something you are)',
        };
    }
}
