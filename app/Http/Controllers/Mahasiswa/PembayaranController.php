<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index()
    {
        $mahasiswaId = auth()->user()->mahasiswa->id_mahasiswa;

        // Ambil pendaftaran yang aktif (Disetujui)
        $pendaftaran = Pendaftaran::where('mahasiswa_id', $mahasiswaId)
            ->where('status_seleksi', 'Disetujui')
            ->first();

        // Ambil tagihan yang statusnya belum bayar atau menunggu verifikasi
        $tagihanAktif = Pembayaran::whereHas('pendaftaran', function($q) use ($mahasiswaId) {
                $q->where('mahasiswa_id', $mahasiswaId);
            })
            ->whereIn('status_verifikasi', ['Belum Bayar', 'Menunggu', 'Ditolak'])
            ->latest()
            ->first();

        // Ambil riwayat pembayaran yang sudah lunas/selesai
        $riwayat = Pembayaran::whereHas('pendaftaran', function($q) use ($mahasiswaId) {
                $q->where('mahasiswa_id', $mahasiswaId);
            })
            ->where('status_verifikasi', 'Sudah')
            ->orderBy('tgl_bayar', 'desc')
            ->get();

        return view('mahasiswa.pembayaran', compact('tagihanAktif', 'riwayat'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        if ($request->hasFile('bukti_transfer')) {
            // Hapus foto lama kalau ada
            if ($pembayaran->bukti_transfer) {
                Storage::disk('public')->delete($pembayaran->bukti_transfer);
            }

            $path = $request->file('bukti_transfer')->store('bukti-pembayaran', 'public');
            
            $pembayaran->update([
                'bukti_transfer' => $path,
                'tgl_bayar' => now(),
                'status_verifikasi' => 'Menunggu',
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Mohon tunggu verifikasi admin.');
    }
}