<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    public const SIMULATION_ATTACK_STEP = 'simulation_attack_completed';

    public const SIMULATION_SETUP_STEP = 'simulation_setup_completed';

    protected $table = 'user_progress';

    protected $guarded = [];

    protected $casts = [
        'theory_completed' => 'boolean',
        'simulation_setup_completed' => 'boolean',
        'simulation_attack_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
