<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Penempatan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $pengelola = auth()->user()->pengelola;
        
        if (!$pengelola || !$pengelola->hunian_id) {
            return redirect()->route('login')->with('error', 'Data pengelola tidak ditemukan.');
        }

        $hunianId = $pengelola->hunian_id;

        // Query dasar
        $query = Kamar::where('hunian_id', $hunianId)->with('hunian');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $statusMap = [
                'kosong' => 'Tersedia',
                'terisi' => 'Tersedia', // Akan difilter lagi di bawah
                'rusak' => 'Rusak',
            ];

            if (isset($statusMap[$request->status])) {
                if ($request->status === 'terisi') {
                    $query->where('status', 'Tersedia')
                          ->whereColumn('terisi', '>', DB::raw('0'));
                } else {
                    $query->where('status', $statusMap[$request->status]);
                    
                    if ($request->status === 'kosong') {
                        $query->where('terisi', 0);
                    }
                }
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_kamar', 'like', "%{$search}%")
                  ->orWhere('lantai', 'like', "%{$search}%");
            });
        }

        // Pagination
        $kamars = $query->orderBy('lantai')->orderBy('nomor_kamar')->paginate(15);

        // Selected kamar untuk detail panel
        $selectedKamar = $kamars->first();

        return view('pengelola.kamar.index', compact('kamars', 'selectedKamar'));
    }

    public function show($id)
    {
        $pengelola = auth()->user()->pengelola;
        
        if (!$pengelola || !$pengelola->hunian_id) {
            return redirect()->route('login')->with('error', 'Data pengelola tidak ditemukan.');
        }

        $kamar = Kamar::where('hunian_id', $pengelola->hunian_id)
            ->with(['hunian', 'penempatan' => function ($q) {
                $q->where('status', 'Aktif')->with('pendaftaran.mahasiswa');
            }])
            ->findOrFail($id);

        return view('pengelola.kamar.show', compact('kamar'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Tersedia,Penuh,Rusak',
        ]);

        $pengelola = auth()->user()->pengelola;
        
        if (!$pengelola || !$pengelola->hunian_id) {
            return back()->with('error', 'Data pengelola tidak ditemukan.');
        }

        $kamar = Kamar::where('hunian_id', $pengelola->hunian_id)->findOrFail($id);

        $kamar->update([
            'status' => $request->status,
        ]);

        // Log activity
        ActivityLog::log(
            'Update Status Kamar',
            'Kamar',
            $kamar->id_kamar,
            [
                'nomor_kamar' => $kamar->nomor_kamar,
                'status_baru' => $request->status,
            ]
        );

        return back()->with('success', 'Status kamar berhasil diperbarui.');
    }
}