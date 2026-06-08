<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->session()->get(config('admin.session_key'))) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email admin wajib diisi.',
            'email.email' => 'Format email admin tidak valid.',
            'password.required' => 'Password admin wajib diisi.',
        ]);

        $rateLimitKey = $this->rateLimitKey($request);

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Terlalu banyak percobaan login. Coba lagi beberapa saat.',
            ]);
        }

        if (!$this->credentialsAreValid($credentials['email'], $credentials['password'])) {
            RateLimiter::hit($rateLimitKey, 60);

            throw ValidationException::withMessages([
                'email' => 'Email atau password admin tidak sesuai.',
            ]);
        }

        RateLimiter::clear($rateLimitKey);

        $request->session()->regenerate();
        $request->session()->put(config('admin.session_key'), true);
        $request->session()->put(config('admin.session_email_key'), config('admin.email'));

        return redirect()
            ->intended(route('admin.dashboard'))
            ->with('success', 'Berhasil masuk ke sistem admin.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget([
            config('admin.session_key'),
            config('admin.session_email_key'),
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Kamu sudah keluar dari sistem admin.');
    }

    private function credentialsAreValid(string $email, string $password): bool
    {
        $configuredEmail = (string) config('admin.email');
        $configuredHash = config('admin.password_hash');

        if (!is_string($configuredHash) || $configuredHash === '') {
            return false;
        }

        return hash_equals(Str::lower($configuredEmail), Str::lower($email))
            && Hash::check($password, $configuredHash);
    }

    private function rateLimitKey(Request $request): string
    {
        return 'admin-login:' . Str::lower((string) $request->input('email')) . '|' . $request->ip();
    }
}
