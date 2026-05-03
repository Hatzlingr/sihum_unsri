<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ActivityLog;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'nim' => ['required', 'string', 'max:20', 'unique:mahasiswa,nim'],
            'prodi' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp' => ['nullable', 'string', 'max:15'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'prodi.required' => 'Program studi wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        DB::beginTransaction();

        try {
            // Buat user
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'Mahasiswa',
                'is_active' => true,
            ]);

            // Buat data mahasiswa
            $mahasiswa = Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'nama' => $request->nama,
                'prodi' => $request->prodi,
                'status_kipk' => false, // Default bukan penerima KIP-K
                'no_hp' => $request->no_hp,
            ]);

            // Log aktivitas registrasi
            ActivityLog::create([
                'user_id' => $user->id,
                'aksi' => 'Register',
                'modul' => 'Auth',
                'target_id' => $mahasiswa->id_mahasiswa,
                'detail' => [
                    'username' => $user->username,
                    'nim' => $mahasiswa->nim,
                    'nama' => $mahasiswa->nama,
                    'prodi' => $mahasiswa->prodi,
                ],
                'ip_address' => $request->ip(),
                'created_at' => now(),
            ]);

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('mahasiswa.dashboard')
                ->with('success', 'Registrasi berhasil! Selamat datang di SIHUM UNSRI.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
        }
    }
}