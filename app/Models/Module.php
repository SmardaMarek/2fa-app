<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\FactorType;
use App\Enums\ModuleDifficulty;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $guarded = [];

    protected $casts = [
        'factor_type' => FactorType::class,
        'difficulty' => ModuleDifficulty::class,
        'is_active' => 'boolean',
    ];

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
