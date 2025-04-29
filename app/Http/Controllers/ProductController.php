<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Array to store product data (instead of database)
    private $products = [
        1 => [
            'id' => 1,
            'image' => 'images/p1.jpg',
            'title' => 'Pop Up Parade SP Figure Belle / Rin - Zenless Zone Zero (17,7cm)',
            'type' => '[Exclusive Sale]',
            'price' => '$89.99',
            'description' => 'This limited edition Pop Up Parade figure features Belle/Rin from Zenless Zone Zero. Standing at 17.7cm tall, this detailed figure captures all the character\'s unique design elements with high-quality craftsmanship.',
            'specifications' => [
                'Height' => '17.7cm',
                'Material' => 'PVC',
                'Manufacturer' => 'Good Smile Company',
                'Release Date' => 'January 2025',
                'Series' => 'Zenless Zone Zero'
            ]
        ],
        2 => [
            'id' => 2,
            'image' => 'images/p2.jpg',
            'title' => 'Pop Up Parade Gawr Gura - Hololive (17,7cm)',
            'type' => 'Limited Edition',
            'price' => '$89.99',
            'description' => 'This limited edition Pop Up Parade figure showcases the popular VTuber Gawr Gura from Hololive. Featuring her iconic shark design and trident, this 17.7cm figure is perfect for any Hololive fan collection.',
            'specifications' => [
                'Height' => '17.7cm',
                'Material' => 'PVC',
                'Manufacturer' => 'Good Smile Company',
                'Release Date' => 'December 2024',
                'Series' => 'Hololive'
            ]
        ],
        3 => [
            'id' => 3,
            'image' => 'images/p3.jpg',
            'title' => 'Pop Up Parade Frieren - Sousou no Frieren',
            'type' => '[Exclusive Sale]',
            'price' => '$89.99',
            'description' => 'This exclusive Pop Up Parade figure features Frieren from the popular anime "Sousou no Frieren". The figure beautifully captures her elegant elven design and magical essence.',
            'specifications' => [
                'Height' => '18cm',
                'Material' => 'PVC',
                'Manufacturer' => 'Good Smile Company',
                'Release Date' => 'February 2025',
                'Series' => 'Sousou no Frieren'
            ]
        ],
        4 => [
            'id' => 4,
            'image' => 'images/p4.jpg',
            'title' => 'Pop up Parade Red Eyes Black Dragon - Yu-Gi-Oh! (18cm)',
            'type' => '[Exclusive Sale]',
            'price' => '$89.99',
            'description' => 'This exclusive Red Eyes Black Dragon figure from Yu-Gi-Oh! stands 18cm tall and features incredible detail on its iconic black scales and fearsome pose.',
            'specifications' => [
                'Height' => '18cm',
                'Material' => 'PVC',
                'Manufacturer' => 'Good Smile Company',
                'Release Date' => 'March 2025',
                'Series' => 'Yu-Gi-Oh!'
            ]
        ],
        5 => [
            'id' => 5,
            'image' => 'images/p5.jpg',
            'title' => 'Pop Up Parade Blue Eyes White Dragon - Yu-Gi-Oh! (17,5cm)',
            'type' => '[Exclusive Sale]',
            'price' => '$89.99',
            'description' => 'This exclusive Blue Eyes White Dragon figure captures the legendary monster from Yu-Gi-Oh! in all its glory. Standing at 17.5cm, the figure features a dynamic pose with impressive detailing.',
            'specifications' => [
                'Height' => '17.5cm',
                'Material' => 'PVC',
                'Manufacturer' => 'Good Smile Company',
                'Release Date' => 'March 2025',
                'Series' => 'Yu-Gi-Oh!'
            ]
        ],
        6 => [
            'id' => 6,
            'image' => 'images/p6.jpg',
            'title' => 'Pop Up Parade Aventurine - Honkai Star Rail (16cm)',
            'type' => '[Exclusive Sale]',
            'price' => '$89.99',
            'description' => 'This exclusive Aventurine figure from Honkai Star Rail stands 16cm tall and showcases the character\'s unique design with impressive detail and dynamic posing.',
            'specifications' => [
                'Height' => '16cm',
                'Material' => 'PVC',
                'Manufacturer' => 'Good Smile Company',
                'Release Date' => 'April 2025',
                'Series' => 'Honkai Star Rail'
            ]
        ]
    ];

    // Display all products (your existing homepage)
    public function index()
    {
        return view('pages.dashboard');
    }

    // Show single product details
    public function show($id)
    {
        // Check if product exists in our array
        if (!isset($this->products[$id])) {
            abort(404);
        }

        $product = $this->products[$id];
        $relatedProducts = array_filter($this->products, function($item) use ($id) {
            return $item['id'] != $id;
        });
        
        // Get just 3 related products
        $relatedProducts = array_slice($relatedProducts, 0, 3);

        return view('pages.product-detail', compact('product', 'relatedProducts'));
    }
}