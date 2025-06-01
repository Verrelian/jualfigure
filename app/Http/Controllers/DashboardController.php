<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
<<<<<<< HEAD
    public function show()
{
    $user = Auth::user(); // 
    return view('pages.user.profile', compact('user'));
}
=======
    public function index()
    {
        $user = Auth::user(); // ambil data user yang sedang login
        return view('pages.general.dashboard', compact('user'));
    }
>>>>>>> 367026e3847fcc234c0c0b933a6c2df238659d7a
}
