<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Method yang sudah ada
    public function show($id)
    {
        // Kode show() yang sudah ada...
    }

    // Method baru untuk halaman status pesanan
    public function status($id = null)
    {
        // Contoh data pesanan dummy (gunakan data yang sama dengan method show)
        $orders = [
            '3321345' => [
                'id' => '3321345',
                'title' => 'Pop Up Parade SP Figure Belle / Rin',
                'status' => 'Packing', // opsi: processing, shipping, delivered, done
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
            ],
            '3321346' => [
                'id' => '3321346',
                'title' => 'Pop Up Parade Gawr Gura - Hololive (17,7cm)',
                'status' => 'Packing',
                'date' => '20 Apr 2025',
                'recipient' => 'Ariq Fadillah',
                'phone' => '62+ 81234567890',
                'address' => 'Sunter, Jakarta Utara',
                'estimated' => '2-3 business days',
                'product' => [
                    'name' => 'Pop Up Parade Gawr Gura - Hololive (17,7cm)',
                    'specs' => 'Height: 10cm | Accessories: 2 heads',
                    'quantity' => 2,
                    'price' => '$45.00',
                    'image' => 'images/p2.jpg',
                ],
                'subtotal' => '$90.00',
                'shipping_fee' => '$7.00',
                'total' => '$97.00',
            ],
            '3321347' => [
                'id' => '3321347',
                'title' => 'Pop Up Parade Frieren - Sousou no Frieren',
                'status' => 'Packing',
                'date' => '20 Apr 2025',
                'recipient' => 'Aiq Fadillah',
                'phone' => '62+ 81234562890',
                'address' => 'Sunggal, Sumatera Utara',
                'estimated' => '2-3 business days',
                'product' => [
                    'name' => 'Pop Up Parade Frieren - Sousou no Frieren',
                    'specs' => 'Height: 16cm | Accessories: 2 heads',
                    'quantity' => 2,
                    'price' => '$90.00',
                    'image' => 'images/p3.png',
                ],
                'subtotal' => '$90.00',
                'shipping_fee' => '$7.00',
                'total' => '$97.00',
            ], 
        ];

        

        // Jika ID disediakan, tampilkan detail pesanan tersebut
        if ($id && isset($orders[$id])) {
            $order = $orders[$id];
            
            // Jika halaman ini diakses dari tombol Done, update status menjadi 'done'
            $order['status'] = 'done';
            
            return view('pages.order-status', ['order' => $order]);
        }
        
        // Jika tidak ada ID atau ID tidak valid, tampilkan semua pesanan
        return view('pages.order-status', ['orders' => $orders]);
    }
}
