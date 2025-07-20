<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Buyer;
use App\Models\Payment;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{

    public function showForm($product_id)
    {
        $product = Produk::findOrFail($product_id);
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

        $userId = session('user_id');
        $buyer = Buyer::find($userId);

        if (!$buyer) {
            return redirect()->back()->with('error', 'Pembeli tidak ditemukan.');
        }

        // Update info pembeli
        $buyer->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        // Kode shared untuk semua payment
        $orderId = '#' . str_pad(random_int(0, 9999999), 7, '0', STR_PAD_LEFT);
        $paymentCode = str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        $expiredAt = now()->addSeconds(30);

        // Tentukan biaya bank
        $bankCharge = match ($request->payment_method) {
            'BANK BCA' => 350000,
            'BANK MANDIRI' => 300000,
            'BANK BNI' => 260000,
            'BANK BRI' => 250000,
            default => 0,
        };

        $tax = 50000;
        $shipping = 100000;

        // Memeriksa checkout versi cart atau bukan
        $isCartCheckout = $request->has('is_cart_checkout') && $request->is_cart_checkout == '1';

        if ($isCartCheckout) {
            // CART CHECKOUT
            $cartItems = Cart::where('buyer_id', $userId)->with('product')->get();
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
            }

            $firstPaymentId = null;

            foreach ($cartItems as $item) {
                $product = $item->product;
                if (!$product) continue;

                $priceQty = $product->price * $item->quantity;
                $total = $priceQty + $tax + $shipping + $bankCharge;

                $payment = Payment::create([
                    'product_id' => $product->product_id,
                    'buyer_id' => $buyer->buyer_id,
                    'seller_id' => $product->seller_id,
                    'name' => $request->name,
                    'quantity' => $item->quantity,
                    'payment_method' => $request->payment_method,
                    'product_name' => $product->product_name,
                    'type' => $product->type,
                    'image' => $product->image,
                    'price' => $priceQty,
                    'price_total' => $total,
                    'address' => $request->address,
                    'order_id' => $orderId,
                    'payment_code' => $paymentCode,
                    'phone_number' => $request->phone_number,
                    'expired_at' => $expiredAt,
                ]);

                // Simpan ID untuk redirect
                if (!$firstPaymentId) {
                    $firstPaymentId = $payment->payment_id;
                }
            }

            // Bersihkan cart
            Cart::where('buyer_id', $userId)->delete();

            return redirect()->route('payment.receipt', ['payment_id' => $firstPaymentId, 'isCart' => false]);
        } else {
            // NORMAL CHECKOUT
            $product = Produk::findOrFail($request->product_id);
            $quantity = $request->quantity ?? 1;

            $priceQty = $product->price * $quantity;
            $total = $priceQty + $tax + $shipping + $bankCharge;

            $payment = Payment::create([
                'product_id' => $product->product_id,
                'buyer_id' => $buyer->buyer_id,
                'seller_id' => $product->seller_id,
                'name' => $request->name,
                'quantity' => $quantity,
                'payment_method' => $request->payment_method,
                'product_name' => $product->product_name,
                'type' => $product->type,
                'image' => $product->image,
                'price' => $priceQty,
                'price_total' => $total,
                'address' => $request->address,
                'order_id' => $orderId,
                'payment_code' => $paymentCode,
                'phone_number' => $request->phone_number,
                'expired_at' => $expiredAt,
            ]);

            return redirect()->route('payment.receipt', ['payment_id' => $payment->payment_id, 'isCart' => false]);
        }
    }

    public function checkoutCart()
    {
        // Ambil user_id dari session manual
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data pembeli berdasarkan session user_id
        $buyer = Buyer::find($userId);

        if (!$buyer) {
            return redirect()->back()->with('error', 'Data pembeli tidak ditemukan.');
        }

        // Ambil semua cart item milik user
        $cartItems = Cart::where('buyer_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Keranjang kamu masih kosong.');
        }

        // Ambil semua product_id dari cart
        $productIds = $cartItems->pluck('product_id');

        // Ambil detail Produk dari tabel Produk
        $product = Produk::whereIn('product_id', $productIds)->get()->keyBy('product_id');

        // Gabungkan data cart + Produk
        $cartWithDetails = $cartItems->map(function ($item) use ($product) {
            $product = $product[$item->product_id] ?? null;

            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'name' => $product?->product_name,
                'image' => $product?->image,
                'price' => $product?->price,
                'total_price' => $product ? $product->price * $item->quantity : 0,
                'type' => $product?->type
            ];
        });

        // Hitung subtotal
        $subtotal = $cartWithDetails->sum('total_price');

        // Kirim ke view checkout
        return view('checkout', [
            'buyer' => $buyer,
            'cartItems' => $cartWithDetails,
            'checkoutFromCart' => true,
            'subtotal' => $subtotal,
            'product' => null,
        ]);
    }
}
