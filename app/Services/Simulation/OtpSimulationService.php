<?php

declare(strict_types=1);

namespace App\Services\Simulation;

use App\Managers\SmsMfaManager;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OtpSimulationService
{
    public function __construct(
        private SmsMfaManager $manager
    ) {}

    public function generateAndDispatch(User $user): string
    {
        $code = (string) random_int(100000, 999999);
        $expiresAt = now()->addMinutes(3);

        $this->manager->storeOtp($user, $code, $expiresAt);

        return $code;
    }

    public function verify(User $user, string $inputCode): bool
    {
        $session = $this->manager->getActiveSession($user);

        if (! $session) {
            return false;
        }

        if (! Hash::check($inputCode, $session->code)) {
            return false;
        }

        $this->manager->markAsVerified($user);

        return true;
    }
}
