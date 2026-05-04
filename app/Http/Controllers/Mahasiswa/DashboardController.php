<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Penempatan;
use App\Models\Pembayaran;
use App\Models\Mahasiswa;
use App\Models\Pendaftaran; // Pastikan import model Pendaftaran
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->route('login')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // 1. Ambil semua ID Pendaftaran milik mahasiswa ini
        // Karena penempatan dan pembayaran merujuk ke id_daftar, bukan ke id_mahasiswa langsung
        $pendaftaranIds = Pendaftaran::where('mahasiswa_id', $mahasiswa->id_mahasiswa)
            ->pluck('id_daftar');

        // 2. Ambil Penempatan Aktif berdasarkan pendaftaran_id
        $penempatan = Penempatan::with(['kamar.hunian'])
            ->whereIn('pendaftaran_id', $pendaftaranIds)
            ->where('status', 'Aktif')
            ->first();

        // 3. Hitung Sisa Hari (Gunakan tgl_keluar sesuai migration kamu)
        $sisaHari = 0;
        if ($penempatan && $penempatan->tgl_keluar) {
            $sisaHari = Carbon::now()->diffInDays(Carbon::parse($penempatan->tgl_keluar), false);
            $sisaHari = $sisaHari < 0 ? 0 : (int)$sisaHari;
        }

        // 4. Status Pembayaran Terakhir berdasarkan pendaftaran_id
        $pembayaranTerakhir = Pembayaran::whereIn('pendaftaran_id', $pendaftaranIds)
            ->latest() // Sama dengan orderBy('created_at', 'desc')
            ->first();

        return view('mahasiswa.dashboard', compact(
            'mahasiswa', 
            'penempatan', 
            'sisaHari', 
            'pembayaranTerakhir'
        ));
    }
}