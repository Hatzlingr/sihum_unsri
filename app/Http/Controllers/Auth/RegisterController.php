<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama'     => ['required', 'string', 'max:100'],
            'nim'      => ['required', 'string', 'max:20', 'unique:users,username', 'unique:mahasiswa,nim'],
            'email'    => ['required', 'string', 'email', 'max:100', 'unique:mahasiswa,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            // Custom Message (Opsional)
            'nim.unique' => 'NIM ini sudah terdaftar di SIHUM.',
            'email.unique' => 'Email ini sudah digunakan.',
        ]);

        try {
            // 2. Proses Simpan dengan Transaksi
            DB::transaction(function () use ($request) {
                // Simpan ke tabel USERS (untuk login)
                $user = User::create([
                    'username' => $request->nim, // NIM dijadikan username
                    'password' => Hash::make($request->password),
                    'role'     => 'Mahasiswa',
                    'is_active' => true,
                ]);

                // Simpan ke tabel MAHASISWA (untuk profil)
                Mahasiswa::create([
                    'user_id'     => $user->id,
                    'nim'         => $request->nim,
                    'nama'        => $request->nama,
                    'email'       => $request->email,
                    'prodi'       => '-', // Biarkan mahasiswa melengkapi nanti di dashboard
                    'status_kipk' => false,
                ]);
            });

            return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login menggunakan NIM.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mendaftar. Silakan coba lagi nanti.'])->withInput();
        }
    }
}