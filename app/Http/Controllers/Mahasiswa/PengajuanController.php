<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Hunian;
use App\Models\Pendaftaran;
use App\Models\DokumenPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index()
    {
        // Ambil hunian yang punya kamar tersedia (tanpa mengubah migrasi)
        $hunians = Hunian::with(['kamar' => function($q) {
            $q->where('status', 'Tersedia');
        }])->get();

        // Ambil riwayat pendaftaran mahasiswa yang sedang login
        $mahasiswaId = auth()->user()->mahasiswa->id_mahasiswa;
        
        $riwayat = Pendaftaran::where('mahasiswa_id', $mahasiswaId)
                    ->with('hunian')
                    ->latest('tgl_pengajuan')
                    ->get();

        return view('mahasiswa.pengajuan', compact('hunians', 'riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hunian_id' => 'required|exists:hunian,id_hunian',
            'file_upload.*' => 'required|file|mimes:pdf,png,jpg|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // 1. Simpan ke tabel pendaftaran
            $pendaftaran = Pendaftaran::create([
                'mahasiswa_id' => auth()->user()->mahasiswa->id_mahasiswa,
                'hunian_id' => $request->hunian_id,
                'tgl_pengajuan' => now(),
                'status_seleksi' => 'Pending',
            ]);

            // 2. Simpan dokumen (Multiple)
            if ($request->hasFile('file_upload')) {
                foreach ($request->file('file_upload') as $file) {
                    $path = $file->store('dokumen_pendaftaran', 'public');

                    DokumenPendaftaran::create([
                        'pendaftaran_id' => $pendaftaran->id_daftar,
                        'tipe_dokumen' => 'Lainnya',
                        'path_file' => $path,
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Pengajuan berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}