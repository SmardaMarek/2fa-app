<?php

declare(strict_types=1);

namespace App\Services\Mfa;

use App\Models\Module;

class QuizService
{
    public function evaluateQuiz(Module $module, array $answers): array
    {
        $questions = $module->questions;
        $total = $questions->count();

        if ($total === 0) {
            return ['score' => 0, 'total' => 0, 'passed' => false];
        }

        $score = 0;

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;

            if ($userAnswer === $question->correct_option) {
                $score++;
            }
        }

        return [
            'score' => $score,
            'total' => $total,
            'passed' => ($score === $total),
        ];
    }
}
