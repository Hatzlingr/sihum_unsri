<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class BiodataController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();
        return view('mahasiswa.biodata', compact('mahasiswa'));
    }

    public function update(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'no_hp' => 'required|string|max:15|min:10',
        ], [
            'no_hp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_hp.min' => 'Nomor WhatsApp minimal 10 digit.',
        ]);

        $mahasiswa->no_hp = $request->no_hp;
        $mahasiswa->save();

        return back()->with('success', 'Nomor WhatsApp berhasil diperbarui!');
    }
}