<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('mahasiswa.pengaturan');
    }

    /**
     * Update Password User
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new_password.min' => 'Password baru minimal harus 8 karakter.'
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Kata sandi berhasil diubah.');
    }
}