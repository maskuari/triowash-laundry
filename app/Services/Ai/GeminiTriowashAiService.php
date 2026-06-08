<?php

namespace App\Services\Ai;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Throwable;

class GeminiTriowashAiService
{
    private Client $client;

    public function __construct()
    {
        $baseUrl = rtrim(config('services.gemini.base_url'), '/');
        $timeout = (int) config('services.gemini.timeout', 30);

        $this->client = new Client([
            'base_uri' => $baseUrl . '/',
            'timeout' => $timeout,
            'verify' => $this->verifyOption(),
        ]);
    }

    public function reply(string $message, array $history = []): array
    {
        $apiKey = config('services.gemini.api_key');

        if (!$apiKey) {
            return [
                'success' => false,
                'provider' => 'gemini',
                'reply' => null,
                'error' => 'GEMINI_API_KEY belum diatur.',
            ];
        }

        $lastError = null;

        foreach ($this->models() as $model) {
            try {
                $reply = $this->generateReply($model, $apiKey, $message, $history);

                return [
                    'success' => true,
                    'provider' => 'gemini',
                    'model' => $model,
                    'intent' => 'gemini_generated',
                    'confidence' => 1,
                    'reply' => trim($reply),
                    'quick_replies' => TriowashKnowledge::quickReplies(),
                ];
            } catch (Throwable $error) {
                $lastError = $this->formatError($error, $apiKey);

                Log::warning('Gemini AI error', [
                    'model' => $model,
                    'status' => $this->statusCode($error),
                    'message' => $lastError,
                ]);
            }
        }

        return [
            'success' => false,
            'provider' => 'gemini',
            'reply' => null,
            'error' => $lastError ?: 'Gemini belum bisa dihubungi.',
        ];
    }

    private function generateReply(string $model, string $apiKey, string $message, array $history): string
    {
        $endpoint = 'models/' . $model . ':generateContent';

        $response = $this->client->post($endpoint, [
            'query' => [
                'key' => $apiKey,
            ],
            'json' => [
                'systemInstruction' => [
                    'parts' => [
                        [
                            'text' => TriowashKnowledge::businessProfile(),
                        ],
                    ],
                ],
                'contents' => $this->buildContents($message, $history),
                'generationConfig' => [
                    'temperature' => 0.35,
                    'topP' => 0.9,
                    'maxOutputTokens' => 600,
                ],
            ],
        ]);

        $body = json_decode((string) $response->getBody(), true);
        $reply = $this->extractText($body);

        if (!$reply) {
            throw new \RuntimeException('Gemini tidak mengembalikan jawaban teks.');
        }

        return $reply;
    }

    private function models(): array
    {
        $models = array_merge(
            [config('services.gemini.model', 'gemini-2.0-flash')],
            (array) config('services.gemini.fallback_models', [])
        );

        return array_values(array_unique(array_filter(array_map('trim', $models))));
    }

    private function verifyOption(): bool|string
    {
        $verifySsl = filter_var(
            config('services.gemini.verify_ssl', true),
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );

        if ($verifySsl === false) {
            return false;
        }

        $caFile = config('services.gemini.ca_file');

        if (is_string($caFile) && $caFile !== '' && is_file($caFile)) {
            return $caFile;
        }

        return true;
    }

    private function statusCode(Throwable $error): ?int
    {
        if ($error instanceof RequestException && $error->hasResponse()) {
            return $error->getResponse()->getStatusCode();
        }

        return null;
    }

    private function formatError(Throwable $error, string $apiKey): string
    {
        $statusCode = $this->statusCode($error);
        $message = $error->getMessage();

        if ($error instanceof RequestException && $error->hasResponse()) {
            $body = json_decode((string) $error->getResponse()->getBody(), true);
            $message = $body['error']['message'] ?? $message;
        }

        $message = str_replace($apiKey, '<redacted>', $message);
        $message = preg_replace('/([?&]key=)[^&\s]+/i', '$1<redacted>', $message);

        return trim(($statusCode ? 'HTTP ' . $statusCode . ': ' : '') . $message);
    }

    private function buildContents(string $message, array $history): array
    {
        $contents = [];

        foreach ($history as $item) {
            if (!isset($item['role'], $item['content'])) {
                continue;
            }

            $role = $item['role'] === 'assistant' ? 'model' : 'user';

            $contents[] = [
                'role' => $role,
                'parts' => [
                    [
                        'text' => (string) $item['content'],
                    ],
                ],
            ];
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [
                [
                    'text' => $message,
                ],
            ],
        ];

        return $contents;
    }

    private function extractText(?array $body): ?string
    {
        if (!$body || empty($body['candidates'][0]['content']['parts'])) {
            return null;
        }

        $texts = [];

        foreach ($body['candidates'][0]['content']['parts'] as $part) {
            if (!empty($part['text'])) {
                $texts[] = $part['text'];
            }
        }

        $joined = trim(implode("\n", $texts));

        return $joined !== '' ? $joined : null;
    }
}
