<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'nim'      => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'nim.required'      => 'NIM wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Cari mahasiswa berdasarkan NIM
        $mahasiswa = Mahasiswa::where('nim', $request->nim)->first();

        if (!$mahasiswa) {
            return back()
                ->withInput($request->only('nim'))
                ->withErrors(['nim' => 'NIM tidak ditemukan.']);
        }

        $user = $mahasiswa->user;

        // Cek apakah akun aktif
        if (!$user->is_active) {
            return back()
                ->withInput($request->only('nim'))
                ->withErrors(['nim' => 'Akun tidak aktif. Hubungi administrator.']);
        }

        // Verifikasi password
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('nim'))
                ->withErrors(['password' => 'Password salah.']);
        }

        // Login
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Catat waktu login
        $user->update(['last_login_at' => now()]);

        return $this->redirectByRole();
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }

    /**
     * Redirect berdasarkan role user.
     */
    private function redirectByRole()
    {
        return match (Auth::user()->role) {
            'Admin'     => redirect()->route('admin.dashboard'),
            'Pengelola' => redirect()->route('pengelola.dashboard'),
            'Mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            default     => redirect('/'),
        };
    }
}
