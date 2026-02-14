<?php

declare(strict_types=1);

namespace App\Http\Controllers\Mfa;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\UserProgress;
use App\Services\Mfa\TheoryService;
use Illuminate\Support\Facades\Auth;

class TheoryController extends Controller
{
    public function __construct(protected TheoryService $theoryService) {}

    public function show(Module $module)
    {
        // Zde zaznamenáme, že uživatel začal modul (pokud ještě nezačal)
        UserProgress::firstOrCreate(
            ['user_id' => Auth::id(), 'module_id' => $module->id],
            ['theory_completed' => false]
        );

        // Dynamicky určíme, kterou šablonu obsahu načíst podle slugu
        // např. resources/views/modules/content/sms-otp.blade.php
        $contentView = "modules.content.{$module->slug}";

        return view('modules.theory', [
            'module' => $module,
            'contentView' => $contentView,
        ]);
    }

    // Metoda pro dokončení teorie a přechod na simulaci
    public function complete(Module $module)
    {
        // Označíme teorii jako hotovou
        UserProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'module_id' => $module->id],
            ['theory_completed' => true]
        );

        // Přesměrujeme na setup simulace (zatím jen placeholder, ten uděláme příště)
        return redirect()->route('module.implementation', $module);
    }

    public function implementation(Module $module)
    {
        $codeSamples = $this->theoryService->getCodeSamples($module);
        $contentView = "modules.code-samples.introduction.{$module->slug}";

        return view('modules.implementation', [
            'module' => $module,
            'codeSamples' => $codeSamples,
            'contentView' => $contentView,
        ]);
    }
}
