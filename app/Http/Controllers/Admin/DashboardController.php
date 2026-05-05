<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\Penempatan;
use App\Models\Hunian;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Stats Utama
        $totalPenghuni = Penempatan::where('status', 'Aktif')->count();
        
        $kapasitasTotal = Kamar::sum('kapasitas');
        $terisiTotal = Kamar::sum('terisi');
        $occupancyRate = $kapasitasTotal > 0 ? round(($terisiTotal / $kapasitasTotal) * 100) : 0;
        
        $kamarKosong = Kamar::where('status', 'Tersedia')->count();
        
        // Gabungan Verifikasi (Pendaftaran + Pembayaran)
        $menungguVerifikasi = Pendaftaran::where('status_seleksi', 'Pending')->count() + 
                              Pembayaran::where('status_verifikasi', 'Menunggu')->count();

        // 2. Occupancy per Hunian (Progress Bar)
        $occupancyByHunian = Hunian::withSum('kamar as terisi', 'terisi')
            ->withSum('kamar as kapasitas', 'kapasitas')
            ->get();

        // 3. Status Pembayaran (Panel)
        $paymentStatus = Pembayaran::select('status_verifikasi as status', DB::raw('count(*) as count'))
            ->groupBy('status_verifikasi')
            ->get();

        // 4. Status Kamar (Panel)
        $roomStatus = Kamar::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // 5. Pengajuan Terbaru (Tabel Bawah)
        $latestPendaftaran = Pendaftaran::with(['mahasiswa', 'hunian'])
            ->orderBy('tgl_pengajuan', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPenghuni', 
            'occupancyRate', 
            'kamarKosong', 
            'menungguVerifikasi',
            'occupancyByHunian',
            'paymentStatus',
            'roomStatus',
            'latestPendaftaran'
        ));
    }
}