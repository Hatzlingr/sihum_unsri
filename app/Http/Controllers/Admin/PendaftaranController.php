<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran;

class PendaftaranController extends Controller
{
    public function index()
    {
        $pendaftaran = Pendaftaran::with(['mahasiswa', 'hunian'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }
}

