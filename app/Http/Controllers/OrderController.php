<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function history()
    {
        $buyer = AuthController::getAuthenticatedUser();
        if (!$buyer) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        if (session()->has('history_last_tab')) {
            return redirect()->route(session('history_last_tab'));
        }

        return redirect()->route('history.placed');
    }
}
