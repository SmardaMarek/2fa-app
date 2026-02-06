<?php

declare(strict_types=1);

namespace App\Enums;

enum ModuleDifficulty: string
{
    case Beginner = 'beginner';
    case Intermediate = 'intermediate';
    case Advanced = 'advanced';

    public function color(): string
    {
        return match ($this) {
            self::Beginner => 'green',
            self::Intermediate => 'yellow',
            self::Advanced => 'red',
        };
    }
}
