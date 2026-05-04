<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Penempatan;
use App\Models\Pembayaran;
use App\Models\Mahasiswa;
use App\Models\Pendaftaran;
use Carbon\Carbon;

class HunianController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        // 1. Ambil Penempatan Aktif
        $penempatan = Penempatan::with(['kamar.hunian'])
            ->whereHas('pendaftaran', function ($q) use ($mahasiswa) {
                $q->where('mahasiswa_id', $mahasiswa->id_mahasiswa);
            })
            ->where('status', 'Aktif')
            ->first();

        // 2. Ambil Teman Sekamar (Mahasiswa lain di kamar yang sama)
        $temanSekamar = [];
        if ($penempatan) {
            $temanSekamar = Mahasiswa::whereHas('pendaftaran.penempatan', function ($q) use ($penempatan) {
                $q->where('kamar_id', $penempatan->kamar_id)
                    ->where('status', 'Aktif');
            })
                ->where('id_mahasiswa', '!=', $mahasiswa->id_mahasiswa) // Jangan masukkan diri sendiri
                ->get();
        }

        // 3. Ambil Pembayaran Terakhir
        $pembayaran = null;
        if ($penempatan) {
            $pembayaran = Pembayaran::where('pendaftaran_id', $penempatan->pendaftaran_id)
                ->latest()
                ->first();
        }

        // 4. Hitung Sisa Hari
        $sisaHari = 0;
        if ($penempatan && $penempatan->tgl_keluar) {
            $sisaHari = Carbon::now()->diffInDays(Carbon::parse($penempatan->tgl_keluar), false);
            $sisaHari = $sisaHari < 0 ? 0 : (int)$sisaHari;
        }
        return view('mahasiswa.hunian', compact('penempatan', 'temanSekamar', 'pembayaran', 'sisaHari'));
    }
}