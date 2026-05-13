<?php

namespace App\Services\Ai;

class TriowashAiManager
{
    public function __construct(
        private readonly GeminiTriowashAiService $geminiService,
        private readonly LocalTriowashAiService $localService,
    ) {
    }

    public function reply(string $message, array $history = []): array
    {
        $provider = config('services.ai.provider', 'local');

        if ($provider === 'gemini') {
            $geminiResult = $this->geminiService->reply($message, $history);

            if ($geminiResult['success'] ?? false) {
                return $geminiResult;
            }

            $localResult = $this->localService->reply($message);
            $localResult['provider'] = 'local_fallback';
            $localResult['error'] = $geminiResult['error'] ?? null;

            return $localResult;
        }

        return $this->localService->reply($message);
    }
}