<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Redirect user yang sudah login ke dashboard sesuai role-nya.
     * Dipakai oleh middleware 'guest' pada route /login dan /register.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                return match ($user->role) {
                    'Admin'     => redirect()->route('admin.dashboard'),
                    'Pengelola' => redirect()->route('pengelola.dashboard'),
                    'Mahasiswa' => redirect()->route('mahasiswa.dashboard'),
                    default     => redirect('/'),
                };
            }
        }

        return $next($request);
    }
}
