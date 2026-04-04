<?php

declare(strict_types=1);

namespace App\Services\Simulation;

use Illuminate\Support\Facades\File;

class CodeSamplesService
{
    /**
     * Generická metoda pro načtení code samples z daného adresáře.
     */
    public function getCodeSamples(string $directory): array
    {
        $directoryPath = resource_path("views/modules/code-samples/{$directory}");
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

    public function getBiometricsLessonCodeSamples(): array
    {
        return $this->getCodeSamples('biometrics-lesson');
    }

    public function getFidoLessonCodeSamples(): array
    {
        return $this->getCodeSamples('fido2-key-lesson');
    }

    public function getTotpLessonCodeSamples(): array
    {
        return $this->getCodeSamples('totp-app-lesson');
    }
}
