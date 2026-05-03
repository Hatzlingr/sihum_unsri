<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Update last login
        $user = Auth::user();
        $user->update(['last_login_at' => now()]);

        // Log aktivitas login
        ActivityLog::log(
            aksi: 'Login',
            modul: 'Auth',
            targetId: $user->id,
            detail: [
                'username' => $user->username,
                'role' => $user->role,
                'login_time' => now()->toDateTimeString()
            ]
        );

        // Redirect berdasarkan role
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Redirect user based on their role
     */
    protected function redirectBasedOnRole($user): RedirectResponse
    {
        return match($user->role) {
            'Admin' => redirect()->intended(route('admin.dashboard')),
            'Mahasiswa' => redirect()->intended(route('mahasiswa.dashboard')),
            'Pengelola' => redirect()->intended(route('pengelola.dashboard')),
            default => redirect()->intended(route('home')),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log aktivitas logout sebelum logout
        if (Auth::check()) {
            ActivityLog::log(
                aksi: 'Logout',
                modul: 'Auth',
                targetId: Auth::id(),
                detail: [
                    'username' => Auth::user()->username,
                    'logout_time' => now()->toDateTimeString()
                ]
            );
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil logout.');
    }
}