<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman register.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi mahasiswa baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:100'],
            'nim'                   => ['required', 'string', 'max:20', 'unique:mahasiswa,nim'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'        => 'Nama lengkap wajib diisi.',
            'nim.required'         => 'NIM wajib diisi.',
            'nim.unique'           => 'NIM sudah terdaftar.',
            'password.required'    => 'Password wajib diisi.',
            'password.min'         => 'Password minimal 8 karakter.',
            'password.confirmed'   => 'Konfirmasi password tidak cocok.',
        ]);

        // Auto-generate username unik dari NIM
        $username = $validated['nim'];

        DB::transaction(function () use ($validated, $username) {
            // Buat akun user
            $user = User::create([
                'username'  => $username,
                'password'  => $validated['password'], // Di-hash otomatis oleh cast
                'role'      => 'Mahasiswa',
                'is_active' => true,
            ]);

            Mahasiswa::create([
                'user_id'     => $user->id,
                'nim'         => $validated['nim'],
                'nama'        => $validated['name'],
                'prodi'       => '-',
                'status_kipk' => false,
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }
}
