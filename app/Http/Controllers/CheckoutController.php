<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;
use App\Models\Buyer;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{

    public function showForm($product_id)
    {
        $product = produk::findOrFail($product_id);
        $buyer = Buyer::find(session('user_id'));

        return view('checkout', compact('product', 'buyer'));
    }

    public function processCheckout(Request $request)
    {
        // Validasi input
        $request->validate([
            'phone_number' => 'required|numeric|digits_between:8,20',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        // Cek apakah user sudah login
        //if (!Auth::check()) {
        //    return redirect()->route('login')->with('error', 'Kamu harus login dulu untuk checkout.');
        //}

        // Ambil user_id
        //$user_id = Auth::id();

        // Generate kode unik
        $orderId = '#' . str_pad(random_int(0, 9999999), 7, '0', STR_PAD_LEFT);
        $paymentCode = str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);

        // update data ke tabel buyers
        $buyer = Buyer::find(session('user_id'));

        if ($buyer) {
            $buyer->update([
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ]);
        }

        // Ambil data produk dari database (untuk keperluan payment)
        $product = produk::findOrFail($request->product_id);

        // Tentukan biaya bank berdasarkan metode pembayaran
        $bankCharge = match ($request->payment_method) {
            'BANK BCA' => 350000,
            'BANK MANDIRI' => 300000,
            'BANK BNI' => 260000,
            'BANK BRI' => 250000,
            default => 0,
        };

        // Hitung total harga
        $priceqty = $product->price * $request->quantity;
        $tax = 50000;
        $shipping = 100000;
        $price_total = $priceqty + $tax + $shipping + $bankCharge;

        // Simpan ke tabel payments
        $payment = Payment::create([
            'product_id' => $product->product_id,
            'buyer_id' => $buyer->buyer_id,
            'seller_id' => $product->seller_id,
            'name' => $request->name,
            'quantity' => $request->quantity,
            'payment_method' => $request->payment_method,
            'product_name' => $product->product_name,
            'type' => $product->type,
            'image' => $product->image,
            'price' => $priceqty,
            'price_total' => $price_total,
            'address' => $request->address,
            'order_id' => $orderId,
            'payment_code' => $paymentCode,
            'phone_number' => $request->phone_number,
            'expired_at' => now()->addMinutes(1),
        ]);

        // Redirect atau kirim notifikasi sukses
        return redirect()->route('payment.receipt', ['payment_id' => $payment->payment_id]);
    }
}
