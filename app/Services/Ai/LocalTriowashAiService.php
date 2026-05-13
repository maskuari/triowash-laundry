<?php

namespace App\Services\Ai;

class LocalTriowashAiService
{
    public function reply(string $message): array
    {
        $normalizedMessage = $this->normalize($message);
        $dataset = TriowashKnowledge::localDataset();

        $bestIntent = 'unknown';
        $bestScore = 0;

        foreach ($dataset as $intent => $item) {
            $score = $this->scoreIntent($normalizedMessage, $item['keywords']);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestIntent = $intent;
            }
        }

        $confidence = $this->calculateConfidence($bestScore);

        if ($confidence < 0.18) {
            $bestIntent = 'unknown';
        }

        $selected = $dataset[$bestIntent] ?? $dataset['unknown'];

        return [
            'success' => true,
            'provider' => 'local',
            'intent' => $bestIntent,
            'confidence' => $confidence,
            'reply' => $this->polishAnswer($selected['answer'], $bestIntent),
            'cta' => $selected['cta'] ?? null,
            'quick_replies' => TriowashKnowledge::quickReplies(),
        ];
    }

    private function normalize(string $text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/u', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }

    private function scoreIntent(string $message, array $keywords): int
    {
        $score = 0;

        foreach ($keywords as $keyword) {
            $keyword = $this->normalize($keyword);

            if ($keyword === '') {
                continue;
            }

            if (str_contains($message, $keyword)) {
                $score += str_contains($keyword, ' ') ? 4 : 2;
            }

            foreach (explode(' ', $keyword) as $word) {
                if ($word !== '' && str_contains($message, $word)) {
                    $score += 1;
                }
            }
        }

        return $score;
    }

    private function calculateConfidence(int $score): float
    {
        if ($score <= 0) {
            return 0;
        }

        return min(round($score / 12, 2), 1);
    }

    private function polishAnswer(string $answer, string $intent): string
    {
        if ($intent === 'unknown') {
            return $answer;
        }

        return $answer . "\n\nAda lagi yang ingin kamu tanyakan tentang Triowash?";
    }
}