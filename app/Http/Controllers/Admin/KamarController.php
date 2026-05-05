<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kamar;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::with('hunian')->paginate(10);
        return view('admin.kamar.index', compact('kamars'));
    }
}

