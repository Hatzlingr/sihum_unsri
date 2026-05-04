<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Penempatan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // 1. Ambil data mahasiswa melalui relasi user
        $mahasiswa = $user->mahasiswa; 

        // Proteksi jika data mahasiswa tidak ditemukan di database
        if (!$mahasiswa) {
            return view('mahasiswa.dashboard', [
                'penempatan' => null,
                'sisaHari' => 0,
                'pembayaranTerakhir' => null
            ])->with('error', 'Data profil mahasiswa belum ditemukan.');
        }

        // 2. Ambil Penempatan Aktif
        $penempatan = Penempatan::with(['kamar.hunian'])
            ->where('mahasiswa_id', $mahasiswa->id_mahasiswa)
            ->where('status', 'Aktif')
            ->first();

        // 3. Hitung Sisa Hari (Inisialisasi dulu biar gak undefined)
        $sisaHari = 0;
        if ($penempatan && $penempatan->tanggal_berakhir) {
            $sisaHari = Carbon::now()->diffInDays(Carbon::parse($penempatan->tanggal_berakhir), false);
            $sisaHari = $sisaHari < 0 ? 0 : (int)$sisaHari;
        }

        // 4. Status Pembayaran Terakhir
        $pembayaranTerakhir = Pembayaran::where('mahasiswa_id', $mahasiswa->id_mahasiswa)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('mahasiswa.dashboard', compact('penempatan', 'sisaHari', 'pembayaranTerakhir'));
    }
}