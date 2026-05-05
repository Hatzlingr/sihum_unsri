<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Hunian;
use App\Models\Kamar;
use App\Models\Penempatan;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pengelola = auth()->user()->pengelola;
        
        if (!$pengelola || !$pengelola->hunian_id) {
            return redirect()->route('login')->with('error', 'Data pengelola tidak ditemukan.');
        }

        $hunianId = $pengelola->hunian_id;

        // 1. Statistik Utama
        $totalPenghuni = Penempatan::whereHas('kamar', function ($q) use ($hunianId) {
            $q->where('hunian_id', $hunianId);
        })->where('status', 'Aktif')->count();

        $kapasitasTotal = Kamar::where('hunian_id', $hunianId)->sum('kapasitas');
        $terisiTotal = Kamar::where('hunian_id', $hunianId)->sum('terisi');
        $occupancyRate = $kapasitasTotal > 0 ? round(($terisiTotal / $kapasitasTotal) * 100) . '%' : '0%';

        $kamarKosong = Kamar::where('hunian_id', $hunianId)
            ->where('status', 'Tersedia')
            ->count();

        $kamarRusak = Kamar::where('hunian_id', $hunianId)
            ->where('status', 'Rusak')
            ->count();

        $summary = [
            'total_penghuni' => $totalPenghuni,
            'occupancy_rate' => $occupancyRate,
            'kamar_kosong' => $kamarKosong,
            'kamar_rusak' => $kamarRusak,
        ];

        // 2. Occupancy per Lantai
        $occupancyHunian = Kamar::where('hunian_id', $hunianId)
            ->select('lantai', DB::raw('SUM(terisi) as terisi'), DB::raw('SUM(kapasitas) as kapasitas'))
            ->groupBy('lantai')
            ->orderBy('lantai')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => 'Lantai ' . $item->lantai,
                    'terisi' => $item->terisi,
                    'kapasitas' => $item->kapasitas,
                ];
            });

        // 3. Status Kamar
        $statusKamar = Kamar::where('hunian_id', $hunianId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // 4. Statistik Penghuni
        $penghuniBaruBulanIni = Penempatan::whereHas('kamar', function ($q) use ($hunianId) {
            $q->where('hunian_id', $hunianId);
        })
            ->where('status', 'Aktif')
            ->whereYear('tgl_masuk', now()->year)
            ->whereMonth('tgl_masuk', now()->month)
            ->count();

        $masaTinggalBerakhir = Penempatan::whereHas('kamar', function ($q) use ($hunianId) {
            $q->where('hunian_id', $hunianId);
        })
            ->where('status', 'Aktif')
            ->whereBetween('tgl_keluar', [now(), now()->addDays(30)])
            ->count();

        $pengajuanPindah = DB::table('pindah_kamar')
            ->join('kamar as k_asal', 'pindah_kamar.kamar_asal_id', '=', 'k_asal.id_kamar')
            ->where('k_asal.hunian_id', $hunianId)
            ->where('pindah_kamar.status_approval', 'Pending')
            ->count();

        $statistikPenghuni = collect([
            ['label' => 'Penghuni Baru Bulan Ini', 'value' => $penghuniBaruBulanIni],
            ['label' => 'Masa Tinggal Berakhir (30 hari)', 'value' => $masaTinggalBerakhir],
            ['label' => 'Pengajuan Pindah Kamar', 'value' => $pengajuanPindah],
        ]);

        // 5. Aktivitas Terbaru
        $activities = ActivityLog::where('modul', 'Kamar')
            ->orWhere('modul', 'Penempatan')
            ->orWhere('modul', 'PindahKamar')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($log) {
                return [
                    'title' => $log->aksi . ' pada ' . $log->modul,
                    'time' => $log->created_at->diffForHumans(),
                ];
            });

        return view('pengelola.dashboard', compact(
            'summary',
            'occupancyHunian',
            'statusKamar',
            'statistikPenghuni',
            'activities'
        ));
    }
}