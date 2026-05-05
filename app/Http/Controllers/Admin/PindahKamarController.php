<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pindahkamar;

class PindahKamarController extends Controller
{
    public function index()
    {
        $pindahKamar = Pindahkamar::with(['mahasiswa', 'kamarAsal.hunian', 'kamarTujuan.hunian'])->paginate(10);
        return view('admin.pindah-kamar.index', compact('pindahKamar'));
    }
}

