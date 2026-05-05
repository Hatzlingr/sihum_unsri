<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activitylog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = Activitylog::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.activity-log.index', compact('logs'));
    }
}

