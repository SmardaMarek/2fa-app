<?php

declare(strict_types=1);

namespace App\Managers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SmsMfaManager
{
    public function storeOtp(User $user, string $code, \Carbon\Carbon $expiresAt): void
    {
        DB::table('mfa_sessions')->updateOrInsert(
            ['user_id' => $user->id, 'type' => 'sms'],
            [
                'code' => Hash::make($code),
                'expires_at' => $expiresAt,
                'is_verified' => false,
                'updated_at' => now(),
            ]
        );
    }

    public function markAsVerified(User $user): void
    {
        DB::table('mfa_sessions')
            ->where('user_id', $user->id)
            ->where('type', 'sms')
            ->update(['is_verified' => true]);
    }

    public function getActiveSession(User $user): ?object
    {
        return DB::table('mfa_sessions')
            ->where('user_id', $user->id)
            ->where('type', 'sms')
            ->where('expires_at', '>', now())
            ->where('is_verified', false)
            ->first();
    }
}
