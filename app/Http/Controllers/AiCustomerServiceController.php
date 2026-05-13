<?php

namespace App\Http\Controllers;

use App\Models\AiChatLog;
use App\Services\Ai\TriowashAiManager;
use App\Services\Ai\TriowashKnowledge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AiCustomerServiceController extends Controller
{
    public function chat(Request $request, TriowashAiManager $aiManager): JsonResponse
    {
        $limiterKey = 'csai:' . $request->ip();

        if (RateLimiter::tooManyAttempts($limiterKey, 25)) {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak pesan. Coba lagi beberapa saat.',
            ], 429);
        }

        RateLimiter::hit($limiterKey, 60);

        $validator = Validator::make($request->all(), [
            'message' => ['required', 'string', 'min:2', 'max:1000'],
            'history' => ['nullable', 'array', 'max:10'],
            'history.*.role' => ['required_with:history', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:1000'],
        ], [
            'message.required' => 'Pesan tidak boleh kosong.',
            'message.min' => 'Pesan terlalu pendek.',
            'message.max' => 'Pesan terlalu panjang.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $message = trim($request->input('message'));
        $history = $request->input('history', []);

        $result = $aiManager->reply($message, $history);

        $this->storeLogSafely($request, $message, $result);

        return response()->json([
            'success' => (bool) ($result['success'] ?? false),
            'reply' => $result['reply'] ?? 'Maaf, saya belum bisa menjawab pertanyaan itu.',
            'provider' => $result['provider'] ?? 'unknown',
            'intent' => $result['intent'] ?? null,
            'confidence' => $result['confidence'] ?? 0,
            'cta' => $result['cta'] ?? null,
            'quick_replies' => $result['quick_replies'] ?? TriowashKnowledge::quickReplies(),
        ]);
    }

    private function storeLogSafely(Request $request, string $message, array $result): void
    {
        try {
            AiChatLog::create([
                'session_id' => $request->session()->getId(),
                'ip_address' => $request->ip(),
                'provider' => $result['provider'] ?? 'unknown',
                'intent' => $result['intent'] ?? null,
                'confidence' => $result['confidence'] ?? 0,
                'user_message' => $message,
                'ai_reply' => $result['reply'] ?? null,
                'is_success' => (bool) ($result['success'] ?? false),
                'error_message' => $result['error'] ?? null,
            ]);
        } catch (Throwable) {
            // Log bersifat opsional.
            // Kalau database belum siap, fitur chat tetap berjalan.
        }
    }
}