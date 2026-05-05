<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $totalPenghuni = \App\Models\Penempatan::where('status', 'Aktif')->count();
        $pendapatanBulanIni = \App\Models\Pembayaran::where('status_verifikasi', 'Sudah')
            ->whereMonth('tgl_bayar', now()->month)
            ->whereYear('tgl_bayar', now()->year)
            ->sum('jumlah_bayar');
        $pendaftaranDisetujui = \App\Models\Pendaftaran::where('status_seleksi', 'Disetujui')->count();
        $kamarTersedia = \App\Models\Kamar::whereColumn('terisi', '<', 'kapasitas')->count();

        // Laporan Hunian Stats
        $hunianStats = \App\Models\Hunian::withCount('kamar as total_kamar')
            ->withSum('kamar as kapasitas', 'kapasitas')
            ->withSum('kamar as terisi', 'terisi')
            ->get();

        // Laporan Pembayaran Stats
        $pembayaranStats = \App\Models\Pembayaran::selectRaw('status_verifikasi, count(*) as count, sum(jumlah_bayar) as total')
            ->groupBy('status_verifikasi')
            ->get();

        return view('admin.laporan.index', compact(
            'totalPenghuni',
            'pendapatanBulanIni',
            'pendaftaranDisetujui',
            'kamarTersedia',
            'hunianStats',
            'pembayaranStats'
        ));
    }
}

