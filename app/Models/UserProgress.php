<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    public const SIMULATION_ATTACK_STEP = 'simulation_attack_completed';

    public const SIMULATION_SETUP_STEP = 'simulation_setup_completed';

    public const THEORY_STEP = 'theory_completed';

    public const QUIZ_STEP = 'quiz_completed';

    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'module_id',
        'theory_completed',
        'simulation_setup_completed',
        'simulation_attack_completed',
        'quiz_completed',
        'completed_at',
    ];

    protected $casts = [
        'theory_completed' => 'boolean',
        'simulation_setup_completed' => 'boolean',
        'simulation_attack_completed' => 'boolean',
        'quiz_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
