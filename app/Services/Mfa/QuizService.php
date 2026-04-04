<?php

declare(strict_types=1);

namespace App\Services\Mfa;

use App\Models\Module;

class QuizService
{
    /**
     * @return array{score: int, total: int, passed: bool, incorrectQuestions: array<int, string>}
     */
    public function evaluateQuiz(Module $module, array $answers): array
    {
        $questions = $module->questions;
        $total = $questions->count();

        if ($total === 0) {
            return ['score' => 0, 'total' => 0, 'passed' => false, 'incorrectQuestions' => []];
        }

        $score = 0;
        $incorrectQuestions = [];

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;

            if ($userAnswer === $question->correct_option) {
                $score++;
            } else {
                $incorrectQuestions[$question->id] = $question->correct_option;
            }
        }

        return [
            'score' => $score,
            'total' => $total,
            'passed' => ($score === $total),
            'incorrectQuestions' => $incorrectQuestions,
        ];
    }
}
