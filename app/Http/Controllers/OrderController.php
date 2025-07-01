<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Method untuk menampilkan detail atau daftar status pesanan
    public function status($id = 3321345)
    {
        $orders = [
            '3321345' => [
                'id' => '3321345',
                'title' => 'Pop Up Parade SP Figure Belle / Rin',
                'status' => 'Packing',
                'date' => '15 Apr 2025',
                'recipient' => 'Wahyudi (Verel)',
                'phone' => '62+ 82119223180',
                'address' => 'Nagoya, Blok Timur',
                'estimated' => '3-5 business days',
                'product' => [
                    'name' => 'Pop Up Parade SP Figure Belle / Rin - Zenless Zone Zero (17,7cm)',
                    'specs' => 'Scale: 1/7 | Size: 17cm',
                    'quantity' => 1,
                    'price' => '$79.99',
                    'image' => '/images/p1.jpg',
                ],
                'subtotal' => '$79.99',
                'shipping_fee' => '$8.00',
                'total' => '$87.99',
            ]
        ];

        // Jika ID disediakan dan valid, tampilkan detail status pesanan
        if ($id && isset($orders[$id])) {
            $order = $orders[$id];
            $order['status'] = 'done'; // Ubah status jadi done jika dibuka
            return view('pages.product.order-status', ['order' => $order]);
        }

        // Jika tidak ada ID, tampilkan daftar semua status pesanan
        return view('pages.product.order-status', ['orders' => $orders]);
    }

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
