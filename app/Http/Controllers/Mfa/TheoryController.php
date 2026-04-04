<?php

declare(strict_types=1);

namespace App\Http\Controllers\Mfa;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Services\Mfa\TheoryService;
use App\Services\UserProgressService;

class TheoryController extends Controller
{
    public function __construct(protected TheoryService $theoryService, protected UserProgressService $progressService) {}

    public function show(Module $module)
    {
        $contentView = "modules.content.{$module->slug}";
        abort_unless(view()->exists($contentView), 404);

        return view('modules.theory', [
            'module' => $module,
            'contentView' => $contentView,
        ]);
    }

    public function complete(Module $module)
    {
        $this->progressService->completeTheory($module);

        return redirect()->route('module.implementation', $module);
    }

    public function guide(Module $module)
    {
        $contentView = "modules.guides.{$module->slug}";
        abort_unless(view()->exists($contentView), 404);

        return view('modules.guide', [
            'module' => $module,
            'contentView' => $contentView,
        ]);
    }

    public function implementation(Module $module)
    {
        $codeSamples = $this->theoryService->getCodeSamples($module);
        $contentView = "modules.code-samples.introduction.{$module->slug}";
        abort_unless(view()->exists($contentView), 404);

        return view('modules.implementation', [
            'module' => $module,
            'codeSamples' => $codeSamples,
            'contentView' => $contentView,
        ]);
    }
}
