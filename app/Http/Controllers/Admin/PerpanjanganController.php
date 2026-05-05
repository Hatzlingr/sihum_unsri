<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perpanjangan;

class PerpanjanganController extends Controller
{
    public function index()
    {
        $perpanjangan = Perpanjangan::with(['penempatan.pendaftaran.mahasiswa', 'penempatan.kamar.hunian'])->paginate(10);
        return view('admin.perpanjangan.index', compact('perpanjangan'));
    }

    public function approve($id)
    {
        $perpanjangan = Perpanjangan::findOrFail($id);
        $perpanjangan->update(['status' => 'Disetujui']);

        if ($perpanjangan->penempatan) {
            $perpanjangan->penempatan->update([
                'tgl_keluar' => \Carbon\Carbon::parse($perpanjangan->tgl_keluar_baru)
            ]);
        }

        return redirect()->back()->with('success', 'Perpanjangan berhasil disetujui.');
    }

    public function reject($id)
    {
        $perpanjangan = Perpanjangan::findOrFail($id);
        $perpanjangan->update(['status' => 'Ditolak']);

        return redirect()->back()->with('success', 'Perpanjangan ditolak.');
    }
}

