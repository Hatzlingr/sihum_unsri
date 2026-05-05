<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hunian;

class HunianController extends Controller
{
    public function index()
    {
        $hunians = Hunian::with('kamar')->paginate(10);
        return view('admin.hunian.index', compact('hunians'));
    }
}

