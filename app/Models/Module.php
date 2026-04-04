<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\FactorType;
use App\Enums\ModuleDifficulty;
use App\Enums\ModuleSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'description',
        'factor_type',
        'difficulty',
        'is_active',
    ];

    protected $casts = [
        'factor_type' => FactorType::class,
        'difficulty' => ModuleDifficulty::class,
        'is_active' => 'boolean',
    ];

    public function progress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Vrátí Enum instanci pro tento modul na základě slugu v databázi.
     */
    public function getSlugEnum(): ?ModuleSlug
    {
        return ModuleSlug::tryFrom($this->slug);
    }

    /**
     * Vrátí název routy pro Setup fázi simulace (Krok 1).
     */
    public function getSimulationSetupRoute(): string
    {
        $enum = $this->getSlugEnum();

        return $enum ? $enum->getSimulationSetupRoute() : 'dashboard';
    }

    /**
     * Vrátí název routy pro Attack fázi simulace (Krok 2).
     */
    public function getSimulationAttackRoute(): string
    {
        $enum = $this->getSlugEnum();

        return $enum ? $enum->getSimulationAttackRoute() : 'dashboard';
    }

    /**
     * Vrátí název routy pro Lessons fázi (Krok 3 - ponaučení).
     */
    public function getSimulationLessonsRoute(): string
    {
        $enum = $this->getSlugEnum();

        return $enum ? $enum->getSimulationLessonsRoute() : 'dashboard';
    }

    public function getSimulationVerifySetupRoute(): string
    {
        $enum = $this->getSlugEnum();

        if ($enum) {
            return match ($enum) {
                ModuleSlug::TOTP => 'module.totp.verify_setup',
                ModuleSlug::SMS => 'module.sms.verify',
                default => 'dashboard',
            };
        }

        return 'dashboard';
    }
}
