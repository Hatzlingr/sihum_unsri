<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'Pending');
        
        $pendingCount = Pendaftaran::where('status_seleksi', 'Pending')->count();
        $approvedCount = Pendaftaran::where('status_seleksi', 'Disetujui')->count();
        $rejectedCount = Pendaftaran::where('status_seleksi', 'Ditolak')->count();

        $query = Pendaftaran::with(['mahasiswa', 'hunian'])
                            ->where('status_seleksi', $status)
                            ->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->whereHas('mahasiswa', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $pendaftaran = $query->paginate(10)->withQueryString();

        return view('admin.pendaftaran.index', compact('pendaftaran', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }
}

