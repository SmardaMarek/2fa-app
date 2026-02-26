<?php

declare(strict_types=1);

namespace App\Services\Simulation;

use App\Managers\MfaSimulationManager;
use App\Managers\UserProgressManager;
use App\Models\MfaSimulation;
use App\Models\Module;
use App\Models\User;
use App\Services\UserProgressService;
use Illuminate\Support\Facades\File;
use PragmaRX\Google2FAQRCode\Google2FA;

class BiometricsSimulationService
{
    public function __construct(
        protected MfaSimulationManager $mfaSimulationManager,
        protected UserProgressManager $progressManger,
        protected Google2FA $google2fa,
        protected UserProgressService $userProgressService
    ) {}

    public function completeAttackPhase(User $user, Module $module): void
    {
        $this->userProgressService->completeSimulationAttackStep($module);

        $this->mfaSimulationManager->createOrUpdate(
            $user->id,
            $module->id,
            MfaSimulation::STATUS_COMPROMISED,
            MfaSimulation::SCENARIO_ATTACK
        );
    }

    public function getLessonCodeSamples(): array
    {
        $directoryPath = resource_path('views/modules/code-samples/biometrics-lesson');
        $samples = [];

        if (File::isDirectory($directoryPath)) {
            $files = File::files($directoryPath);
            foreach ($files as $file) {
                $language = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                $samples[$language] = file_get_contents($file->getRealPath());
            }
        }

        return $samples;
    }
}
