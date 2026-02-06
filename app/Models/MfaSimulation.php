<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MfaSimulation extends Model
{
    public const STATUS_SETUP_PENDING = 'setup_pending';

    public const STATUS_COMPROMISED = 'compromised';

    public const SCENARIO_TYPE_SETUP = 'setup';

    public const SCENARIO_ATTACK = 'attack';

    protected $guarded = [];

    protected $casts = [
        'state_data' => 'array',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
