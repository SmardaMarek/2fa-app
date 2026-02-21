<?php

declare(strict_types=1);

namespace App\Services\Mfa;

use App\Models\Module;
use Illuminate\Support\Facades\File;

class TheoryService
{
    public function getCodeSamples(Module $module): array
    {
        $directoryPath = resource_path("views/modules/code-samples/{$module->slug}");
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
