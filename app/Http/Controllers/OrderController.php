<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // In a real app, you would fetch orders from database
        // Here we're using dummy data for demonstration
        $orders = [
            [
                'id' => '3321345',
                'status' => 'shipping',
                'date' => '15 Apr 2025',
                'product' => [
                    'name' => 'Pop Up Parade Hatsune Miku - Vocaloid',
                    'specs' => 'Scale: 1/7 | Size: 17cm',
                    'quantity' => 1,
                    'price' => 79.99,
                    'image' => '/images/figures/hatsune-miku.jpg'
                ],
                'total' => 87.99
            ],
            [
                'id' => '3321300',
                'status' => 'completed',
                'date' => '10 Apr 2025',
                'product' => [
                    'name' => 'Pop Up Parade Gawr Gura - Hololive',
                    'specs' => 'Scale: 1/7 | Size: 17.7cm',
                    'quantity' => 1,
                    'price' => 79.99,
                    'image' => '/images/figures/gawr-gura.jpg'
                ],
                'total' => 87.99
            ],
            [
                'id' => '3321245',
                'status' => 'completed',
                'date' => '5 Apr 2025',
                'product' => [
                    'name' => 'Pop Up Parade Frieren - Sousou no Frieren',
                    'specs' => 'Scale: 1/7 | Size: 18cm',
                    'quantity' => 1,
                    'price' => 79.99,
                    'image' => '/images/figures/frieren.jpg'
                ],
                'total' => 87.99
            ]
        ];

        return view('pages.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // In a real app, you would fetch the specific order from database
        // Here we're using dummy data for demonstration
        $order = [
            'id' => $id,
            'status' => 'shipping',
            'recipient' => 'Wahyudi (Verel)',
            'phone' => '62+ 82119223180',
            'address' => 'Nagoya, Blok Timur',
            'estimated' => '3-5 business days',
            'product' => [
                'name' => 'Pop Up Parade Hatsune Miku - Vocaloid',
                'specs' => 'Scale: 1/7 | Size: 17cm',
                'quantity' => 1,
                'price' => 79.99,
                'image' => '/images/figures/hatsune-miku.jpg',
                'manufacturer' => 'Good Smile Company',
                'scale' => '1/7',
                'size' => '17 cm',
                'material' => 'PVC & ABS',
                'release_date' => 'March 2025',
                'description' => 'A stunning figure of the virtual pop idol Hatsune Miku from Vocaloid. This high-quality PVC figure captures her iconic look with amazing detail.'
            ],
            'subtotal' => 79.99,
            'shipping' => 8.00,
            'total' => 87.99,
            'timeline' => [
                [
                    'status' => 'Order Ship Out',
                    'date' => '14 April 2025, 14:32',
                    'location' => 'Shinjutsu Myer Figure',
                    'completed' => true
                ],
                [
                    'status' => 'Order Display',
                    'date' => '14 April 2025, 18:32',
                    'location' => 'Ferry Port Station',
                    'completed' => true
                ],
                [
                    'status' => 'Haven Staged',
                    'date' => '14 April 2025, 19:32',
                    'location' => 'Nagoya Blok Timur',
                    'completed' => true
                ],
                [
                    'status' => 'Out for Delivery',
                    'date' => '15 April 2025, 07:32',
                    'location' => 'Nagoya Blok Barat Shipyard',
                    'completed' => true
                ],
                [
                    'status' => 'Mission Accomplished',
                    'date' => 'Pending delivery confirmation',
                    'location' => '',
                    'completed' => false
                ]
            ]
        ];

        return view('pages.orders.show', compact('order'));
    }
}