<?php

declare(strict_types=1);

namespace App\Http\Controllers\Mfa;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Services\Mfa\QuizService;
use App\Services\UserProgressService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(
        protected QuizService $quizService,
        protected UserProgressService $progressService
    ) {}

    public function show(Module $module)
    {
        $questions = $module->questions;

        if ($questions->isEmpty()) {
            return back()->with('error', 'Tento modul zatím nemá přiřazené žádné otázky.');
        }

        return view('modules.quiz', compact('module', 'questions'));
    }

    public function submit(Request $request, Module $module)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string|max:1',
        ]);

        $result = $this->quizService->evaluateQuiz($module, $validated['answers']);

        if ($result['passed']) {
            $this->progressService->completeQuizStep($module);

            return redirect()->route('dashboard')
                ->with('status', "Gratulujeme! Získali jste plný počet bodů ({$result['score']}/{$result['total']}).");
        }

        return back()
            ->withInput()
            ->with('error', "Máte {$result['score']} z {$result['total']} správně. K dokončení modulu potřebujete 100 %. Nesprávné odpovědi jsou zvýrazněny níže.")
            ->with('incorrectQuestions', $result['incorrectQuestions'])
            ->with('submitted', true);
    }
}
