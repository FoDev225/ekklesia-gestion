<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginHistory;

class LoginHistoryController extends Controller
{
    public function index()
    {
        $logs = LoginHistory::with('user')->latest()->paginate(10);

        return view('admin.login_history.index', compact('logs'));
    }
}
