<?php

namespace App\Services\Ai;

use GuzzleHttp\Client;
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
        ]);
    }

    public function reply(string $message, array $history = []): array
    {
        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model', 'gemini-2.0-flash');

        if (!$apiKey) {
            return [
                'success' => false,
                'provider' => 'gemini',
                'reply' => null,
                'error' => 'GEMINI_API_KEY belum diatur.',
            ];
        }

        try {
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

            return [
                'success' => true,
                'provider' => 'gemini',
                'intent' => 'gemini_generated',
                'confidence' => 1,
                'reply' => trim($reply),
                'quick_replies' => TriowashKnowledge::quickReplies(),
            ];
        } catch (Throwable $error) {
            Log::error('Gemini AI error', [
                'model' => $model,
                'message' => $error->getMessage(),
            ]);

            return [
                'success' => false,
                'provider' => 'gemini',
                'reply' => null,
                'error' => $error->getMessage(),
            ];
        }
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