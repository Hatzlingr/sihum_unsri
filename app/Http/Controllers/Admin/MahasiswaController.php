<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Penempatan;
use App\Models\Pembayaran;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with(['user', 'penempatan.kamar.hunian'])->paginate(10);
        
        $totalTerdaftar = Mahasiswa::count();
        $aktifHunian = Penempatan::where('status', 'Aktif')->count();
        $belumBayar = Pembayaran::where('status_verifikasi', 'Belum Bayar')->count();
        $totalKipk = Mahasiswa::where('status_kipk', true)->count();
        $totalNonKipk = Mahasiswa::where('status_kipk', false)->count();

        return view('admin.mahasiswa.index', compact(
            'mahasiswa', 'totalTerdaftar', 'aktifHunian', 'belumBayar', 'totalKipk', 'totalNonKipk'
        ));
    }
}

