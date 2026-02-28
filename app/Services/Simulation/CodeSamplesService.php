<?php

declare(strict_types=1);

namespace App\Services\Simulation;

use Illuminate\Support\Facades\File;

class CodeSamplesService
{
    public function getBiometricsLessonCodeSamples(): array
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

    public function getFidoLessonCodeSamples(): array
    {
        $directoryPath = resource_path('views/modules/code-samples/fido2-key-lesson');
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
