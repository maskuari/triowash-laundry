<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (!$request->session()->get(config('admin.session_key'))) {
            return redirect()->guest(route('admin.login'));
        }

        return $next($request);
    }
}
