<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Penempatan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index(Request $request)
    {
        $pengelola = auth()->user()->pengelola;
        
        if (!$pengelola || !$pengelola->hunian_id) {
            return redirect()->route('login')->with('error', 'Data pengelola tidak ditemukan.');
        }

        $hunianId = $pengelola->hunian_id;

        // Query penempatan aktif di hunian pengelola
        $query = Penempatan::whereHas('kamar', function ($q) use ($hunianId) {
            $q->where('hunian_id', $hunianId);
        })
            ->where('status', 'Aktif')
            ->with(['pendaftaran.mahasiswa', 'kamar']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pendaftaran.mahasiswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Pagination
        $penghunis = $query->orderBy('tgl_masuk', 'desc')->paginate(15);

        // Transform data untuk view
        $penghunis->getCollection()->transform(function ($penempatan) {
            $mahasiswa = $penempatan->pendaftaran->mahasiswa;
            return (object) [
                'id_penempatan' => $penempatan->id_penempatan,
                'nim' => $mahasiswa->nim,
                'nama' => $mahasiswa->nama,
                'prodi' => $mahasiswa->prodi,
                'kamar' => $penempatan->kamar->nomor_kamar,
                'status_hunian' => $penempatan->status,
                'status_kipk' => $mahasiswa->status_kipk ? 'KIPK' : 'Non KIPK',
                'tanggal_masuk' => $penempatan->tgl_masuk->format('d F Y'),
                'tgl_keluar' => $penempatan->tgl_keluar,
                'no_hp' => $mahasiswa->no_hp,
            ];
        });

        // Selected penghuni untuk detail panel
        $selectedPenghuni = $penghunis->first();

        return view('pengelola.penghuni.index', compact('penghunis', 'selectedPenghuni'));
    }

    public function show($id)
    {
        $pengelola = auth()->user()->pengelola;
        
        if (!$pengelola || !$pengelola->hunian_id) {
            return redirect()->route('login')->with('error', 'Data pengelola tidak ditemukan.');
        }

        $penempatan = Penempatan::whereHas('kamar', function ($q) use ($pengelola) {
            $q->where('hunian_id', $pengelola->hunian_id);
        })
            ->with(['pendaftaran.mahasiswa', 'kamar', 'perpanjangan'])
            ->findOrFail($id);

        $mahasiswa = $penempatan->pendaftaran->mahasiswa;

        return view('pengelola.penghuni.show', compact('penempatan', 'mahasiswa'));
    }
}