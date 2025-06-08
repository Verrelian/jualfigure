<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Buyer;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{

    public function showForm($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('checkout', compact('product'));
    }

    public function processCheckout(Request $request)
    {
        // Validasi input
        //$request->validate([
        //    'product_id' => 'required|exists:products,id',
        //    'phone_number' => 'required|string|max:20',
        //    'name' => 'required|string|max:255',
        //    'address' => 'required|string|max:255',
        //    'quantity' => 'required|integer|min:1',
        //    'payment_method' => 'required|string',
        //]);

        // Cek apakah user sudah login
        //if (!Auth::check()) {
        //    return redirect()->route('login')->with('error', 'Kamu harus login dulu untuk checkout.');
        //}

        // Ambil user_id
        //$user_id = Auth::id();

        // Generate kode unik
        $orderId = '#' . str_pad(random_int(0, 9999999), 7, '0', STR_PAD_LEFT);
        $paymentCode = str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);

        // Simpan data ke tabel buyers
        $buyer = Buyer::create([
            //'buyer_id' => $buyer_id,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'name' => $request->name,
        ]);

        // Ambil data produk dari database (untuk keperluan payment)
        $product = Product::findOrFail($request->product_id);

        // Hitung total harga
        $price_total = ($product->price * $request->quantity) + 50000 + 100000;

        // Simpan ke tabel payments
        $payment = Payment::create([
            'product_id' => $product->product_id,
            //    'buyer_id' => $buyer->buyer_id,
            'seller_id' => $product->seller_id,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'payment_method' => $request->payment_method,
            'product_name' => $product->product_name,
            'type' => $product->type,
            'image' => $product->image,
            'price' => $product->price,
            'price_total' => $price_total,
            'address' => $request->address,
            'order_id' => $orderId,
            'payment_code' => $paymentCode,
            'phone_number' => $request->phone_number,
        ]);

        // Redirect atau kirim notifikasi sukses
        return redirect()->route('payment.receipt', ['payment_id' => $payment->payment_id]);
    }
}
