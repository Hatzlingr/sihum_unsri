<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penempatan;

class PenempatanController extends Controller
{
    public function index()
    {
        // View expects calonPenempatan (Pendaftaran disetujui tapi belum ada penempatan)
        $calonPenempatan = \App\Models\Pendaftaran::with(['mahasiswa', 'hunian.kamar'])
            ->where('status_seleksi', 'Disetujui')
            ->whereDoesntHave('penempatan')
            ->paginate(10);
            
        return view('admin.penempatan.index', compact('calonPenempatan'));
    }

    public function store(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'kamar_id' => 'required|exists:kamar,id_kamar',
        ]);

        $pendaftaran = \App\Models\Pendaftaran::findOrFail($id);
        $kamar = \App\Models\Kamar::findOrFail($request->kamar_id);

        if ($kamar->terisi >= $kamar->kapasitas) {
            return redirect()->back()->with('error', 'Kamar sudah penuh.');
        }

        // Tentukan durasi: Awal biasanya 6 bulan, tapi bisa dinamis. Di sini pakai 6 bulan sbg default.
        $tglMasuk = now();
        $tglKeluar = now()->addMonths(6);

        Penempatan::create([
            'pendaftaran_id' => $pendaftaran->id_daftar,
            'kamar_id' => $kamar->id_kamar,
            'tgl_masuk' => $tglMasuk,
            'tgl_keluar' => $tglKeluar,
            'status' => 'Aktif',
        ]);

        // Update jumlah terisi di kamar
        $kamar->increment('terisi');

        return redirect()->back()->with('success', 'Mahasiswa berhasil ditempatkan di kamar ' . $kamar->nomor_kamar);
    }
}

