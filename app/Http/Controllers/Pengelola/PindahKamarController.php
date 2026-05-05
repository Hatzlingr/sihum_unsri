<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\PindahKamar;
use App\Models\Kamar;
use App\Models\Penempatan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PindahKamarController extends Controller
{
    public function index(Request $request)
    {
        $pengelola = auth()->user()->pengelola;
        
        if (!$pengelola || !$pengelola->hunian_id) {
            return redirect()->route('login')->with('error', 'Data pengelola tidak ditemukan.');
        }

        $hunianId = $pengelola->hunian_id;

        // Query pindah kamar yang kamar asalnya di hunian pengelola
        $query = PindahKamar::whereHas('kamarAsal', function ($q) use ($hunianId) {
            $q->where('hunian_id', $hunianId);
        })->with(['mahasiswa', 'kamarAsal', 'kamarTujuan', 'partnerTukar']);

        // Filter berdasarkan status
        $status = $request->get('status', 'menunggu');
        $statusMap = [
            'menunggu' => 'Pending',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ];

        if (isset($statusMap[$status])) {
            $query->where('status_approval', $statusMap[$status]);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('mahasiswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Pagination
        $pindahKamars = $query->orderBy('created_at', 'desc')->paginate(15);

        // Transform data untuk view
        $pindahKamars->getCollection()->transform(function ($pindah) {
            return (object) [
                'id_pindah' => $pindah->id_pindah,
                'nama' => $pindah->mahasiswa->nama,
                'nim' => $pindah->mahasiswa->nim,
                'prodi' => $pindah->mahasiswa->prodi,
                'tanggal_pengajuan' => $pindah->created_at->format('d F Y'),
                'status' => $pindah->status_approval,
                'jenis_pindah' => $pindah->jenis_pindah,
                'kamar_awal' => $pindah->kamarAsal->nomor_kamar,
                'kamar_tujuan' => $pindah->kamarTujuan->nomor_kamar,
                'no_telepon' => $pindah->mahasiswa->no_hp,
                'status_kipk' => $pindah->mahasiswa->status_kipk ? 'Terverifikasi KIPK' : 'Tidak Terverifikasi',
                'alasan' => $pindah->alasan,
                'partner_nama' => $pindah->partnerTukar?->nama,
                'status_partner' => $pindah->status_partner,
            ];
        });

        // Selected untuk detail panel
        $selectedPindah = $pindahKamars->first();

        return view('pengelola.pindah-kamar.index', compact('pindahKamars', 'selectedPindah', 'status'));
    }

    public function approve($id)
    {
        $pengelola = auth()->user()->pengelola;
        
        if (!$pengelola || !$pengelola->hunian_id) {
            return back()->with('error', 'Data pengelola tidak ditemukan.');
        }

        $pindahKamar = PindahKamar::whereHas('kamarAsal', function ($q) use ($pengelola) {
            $q->where('hunian_id', $pengelola->hunian_id);
        })->findOrFail($id);

        if ($pindahKamar->status_approval !== 'Pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        // Cek apakah kamar tujuan masih tersedia
        $kamarTujuan = Kamar::find($pindahKamar->kamar_tujuan_id);
        if (!$kamarTujuan->isAvailable()) {
            return back()->with('error', 'Kamar tujuan sudah penuh atau tidak tersedia.');
        }

        try {
            DB::beginTransaction();

            // Update status approval
            $pindahKamar->update([
                'status_approval' => 'Disetujui',
            ]);

            // Update penempatan mahasiswa
            $penempatan = Penempatan::whereHas('pendaftaran', function ($q) use ($pindahKamar) {
                $q->where('mahasiswa_id', $pindahKamar->mahasiswa_id);
            })
                ->where('status', 'Aktif')
                ->first();

            if ($penempatan) {
                // Update status penempatan lama
                $penempatan->update([
                    'status' => 'Pindah',
                ]);

                // Buat penempatan baru
                Penempatan::create([
                    'pendaftaran_id' => $penempatan->pendaftaran_id,
                    'kamar_id' => $pindahKamar->kamar_tujuan_id,
                    'tgl_masuk' => now(),
                    'tgl_keluar' => $penempatan->tgl_keluar,
                    'status' => 'Aktif',
                ]);

                // Update terisi kamar
                $kamarAsal = Kamar::find($pindahKamar->kamar_asal_id);
                $kamarAsal->decrement('terisi');
                $kamarAsal->update(['status' => $kamarAsal->isFull() ? 'Penuh' : 'Tersedia']);

                $kamarTujuan->increment('terisi');
                $kamarTujuan->update(['status' => $kamarTujuan->isFull() ? 'Penuh' : 'Tersedia']);
            }

            // Log activity
            ActivityLog::log(
                'Menyetujui Pindah Kamar',
                'PindahKamar',
                $pindahKamar->id_pindah,
                [
                    'mahasiswa' => $pindahKamar->mahasiswa->nama,
                    'dari' => $pindahKamar->kamarAsal->nomor_kamar,
                    'ke' => $pindahKamar->kamarTujuan->nomor_kamar,
                ]
            );

            DB::commit();

            return back()->with('success', 'Pengajuan pindah kamar berhasil disetujui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pengajuan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable|string|max:500',
        ]);

        $pengelola = auth()->user()->pengelola;
        
        if (!$pengelola || !$pengelola->hunian_id) {
            return back()->with('error', 'Data pengelola tidak ditemukan.');
        }

        $pindahKamar = PindahKamar::whereHas('kamarAsal', function ($q) use ($pengelola) {
            $q->where('hunian_id', $pengelola->hunian_id);
        })->findOrFail($id);

        if ($pindahKamar->status_approval !== 'Pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $pindahKamar->update([
            'status_approval' => 'Ditolak',
        ]);

        // Log activity
        ActivityLog::log(
            'Menolak Pindah Kamar',
            'PindahKamar',
            $pindahKamar->id_pindah,
            [
                'mahasiswa' => $pindahKamar->mahasiswa->nama,
                'alasan' => $request->catatan,
            ]
        );

        return back()->with('success', 'Pengajuan pindah kamar berhasil ditolak.');
    }
}