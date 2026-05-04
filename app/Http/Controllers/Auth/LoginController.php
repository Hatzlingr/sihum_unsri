<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan path view sesuai
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        // 2. Coba Login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'username' => 'Akun Anda belum aktif.',
                ]);
            }

            $user->update(['last_login_at' => now()]);
            return $this->redirectBasedOnRole($user);
        }

        // Jika gagal
        throw ValidationException::withMessages([
            'username' => 'Username atau password salah.',
        ]);
    }

    protected function redirectBasedOnRole($user)
    {
        // Cek role dengan helper yang sudah kamu buat di model User
        if ($user->isAdmin()) {
            return redirect('/admin/dashboard');
        }

        if ($user->isPengelola()) {
            return redirect('/pengelola/dashboard');
        }

        if ($user->isMahasiswa()) {
            return redirect('/mahasiswa/dashboard');
        }

        // Jika tidak ada role yang cocok, lempar ke beranda
        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}