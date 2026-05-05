<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::with(['pendaftaran.mahasiswa', 'perpanjangan.penempatan.pendaftaran.mahasiswa'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pembayaran.index', compact('pembayaran'));
    }

    public function approve($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update([
            'status_verifikasi' => 'Sudah',
            'catatan_admin' => 'Pembayaran telah diverifikasi.'
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil disetujui.');
    }

    public function reject($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update([
            'status_verifikasi' => 'Ditolak',
            'catatan_admin' => request('catatan_admin', 'Bukti pembayaran tidak valid.')
        ]);

        return redirect()->back()->with('success', 'Pembayaran ditolak.');
    }
}

