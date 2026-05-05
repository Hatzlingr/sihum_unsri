<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Penempatan;
use App\Models\PindahKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $pengelola = auth()->user()->pengelola;
        
        if (!$pengelola || !$pengelola->hunian_id) {
            return redirect()->route('login')->with('error', 'Data pengelola tidak ditemukan.');
        }

        $hunianId = $pengelola->hunian_id;

        // Tanggal filter (default bulan ini)
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        // 1. Occupancy Reports
        $kapasitasTotal = Kamar::where('hunian_id', $hunianId)->sum('kapasitas');
        $terisiTotal = Kamar::where('hunian_id', $hunianId)->sum('terisi');
        $occupancyRate = $kapasitasTotal > 0 ? round(($terisiTotal / $kapasitasTotal) * 100) . '%' : '0%';

        $occupancyReports = collect([
            ['label' => 'Kapasitas Hunian', 'value' => $kapasitasTotal],
            ['label' => 'Penghuni Aktif', 'value' => $terisiTotal],
            ['label' => 'Occupancy Rate', 'value' => $occupancyRate],
        ]);

        // 2. Room Status Reports
        $roomReports = Kamar::where('hunian_id', $hunianId)
            ->select('status', DB::raw('count(*) as value'))
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->status === 'Tersedia' ? 'Kamar Tersedia' : ($item->status === 'Penuh' ? 'Kamar Penuh' : 'Kamar Rusak'),
                    'value' => $item->value,
                    'status' => $item->status,
                ];
            });

        // Tambahkan kamar kosong
        $kamarKosong = Kamar::where('hunian_id', $hunianId)
            ->where('status', 'Tersedia')
            ->where('terisi', 0)
            ->count();

        $kamarTerisi = Kamar::where('hunian_id', $hunianId)
            ->where('status', 'Tersedia')
            ->where('terisi', '>', 0)
            ->count();

        $roomReports = collect([
            ['label' => 'Kamar Kosong', 'value' => $kamarKosong, 'status' => 'Kosong'],
            ['label' => 'Kamar Terisi', 'value' => $kamarTerisi, 'status' => 'Terisi'],
            ['label' => 'Kamar Rusak', 'value' => Kamar::where('hunian_id', $hunianId)->where('status', 'Rusak')->count(), 'status' => 'Rusak'],
        ]);

        // 3. Penghuni Reports
        $penghuniBaruBulanIni = Penempatan::whereHas('kamar', function ($q) use ($hunianId) {
            $q->where('hunian_id', $hunianId);
        })
            ->where('status', 'Aktif')
            ->whereBetween('tgl_masuk', [$startDate, $endDate])
            ->count();

        $penghuniKeluar = Penempatan::whereHas('kamar', function ($q) use ($hunianId) {
            $q->where('hunian_id', $hunianId);
        })
            ->where('status', 'Keluar')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->count();

        $pindahKamar = PindahKamar::whereHas('kamarAsal', function ($q) use ($hunianId) {
            $q->where('hunian_id', $hunianId);
        })
            ->where('status_approval', 'Disetujui')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->count();

        $penghuniReports = collect([
            ['label' => 'Penghuni Baru', 'value' => $penghuniBaruBulanIni],
            ['label' => 'Penghuni Keluar', 'value' => $penghuniKeluar],
            ['label' => 'Pindah Kamar', 'value' => $pindahKamar],
        ]);

        // 4. Monthly Summaries
        $totalAktivitas = $penghuniBaruBulanIni + $penghuniKeluar + $pindahKamar;
        
        $kamarPerluTindakLanjut = Kamar::where('hunian_id', $hunianId)
            ->where('status', 'Rusak')
            ->count();

        $pengajuanMenunggu = PindahKamar::whereHas('kamarAsal', function ($q) use ($hunianId) {
            $q->where('hunian_id', $hunianId);
        })
            ->where('status_approval', 'Pending')
            ->count();

        $monthlySummaries = collect([
            ['label' => 'Total aktivitas operasional bulan ini', 'value' => $totalAktivitas],
            ['label' => 'Kamar perlu tindak lanjut', 'value' => $kamarPerluTindakLanjut],
            ['label' => 'Pengajuan menunggu keputusan', 'value' => $pengajuanMenunggu],
        ]);

        return view('pengelola.laporan.index', compact(
            'occupancyReports',
            'roomReports',
            'penghuniReports',
            'monthlySummaries'
        ));
    }

    public function exportPdf(Request $request)
    {
        // TODO: Implement PDF export
        return back()->with('info', 'Fitur export PDF akan segera tersedia.');
    }

    public function exportCsv(Request $request)
    {
        // TODO: Implement CSV export
        return back()->with('info', 'Fitur export CSV akan segera tersedia.');
    }
}