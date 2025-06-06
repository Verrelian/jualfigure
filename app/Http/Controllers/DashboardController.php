<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // ambil data user yang sedang login
        return view('pages.general.dashboard', compact('user'));
    }
}
