<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $buyerId = $this->getBuyerID();
        if (!$buyerId) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
                'data' => []
            ], 401);
        }

        $cartItems = Cart::with('product')->forBuyer($buyerId)->get();
        $formattedCart = $this->formatCartResponse($cartItems);

        return response()->json([
            'success' => true,
            'data' => $formattedCart,
            'message' => 'Cart loaded successfully'
        ]);
    }

    public function showCartPage()
    {
        return view('pages.product.cart');
    }

    public function add(Request $request)
    {
        $buyerId = $this->getBuyerID();
        if (!$buyerId) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add items to cart'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|integer|exists:products,product_id',
            'quantity' => 'integer|min:1|max:99'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $existingCartItem = Cart::where('buyer_id', $buyerId)
            ->where('product_id', $productId)
            ->first();

        if ($existingCartItem) {
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
            $cartItem = $existingCartItem;
            $message = 'Product quantity updated in cart';
        } else {
            $cartItem = Cart::create([
                'buyer_id' => $buyerId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
            $message = 'Product added to cart successfully';
        }

        $cartItem->load('product');
        return response()->json([
            'success' => true,
            'data' => $cartItem,
            'message' => $message
        ]);
    }

    public function update(Request $request, $id)
    {
        $buyerId = $this->getBuyerID();
        if (!$buyerId) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        $cartItem = Cart::where('cart_id', $id)
            ->where('buyer_id', $buyerId)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        $cartItem->load('product');

        return response()->json([
            'success' => true,
            'data' => $cartItem,
            'message' => 'Cart item updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $buyerId = $this->getBuyerID();
        if (!$buyerId) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $cartItem = Cart::where('cart_id', $id)
            ->where('buyer_id', $buyerId)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->delete();
        return response()->json([
            'success' => true,
            'message' => 'Cart item removed successfully'
        ]);
    }

    /**
     * Get cart count for specific buyer
     */
    public function getCount()
    {
        $buyerId = $this->getBuyerID();
        if (!$buyerId) {
            return response()->json(['success' => false, 'count' => 0], 401);
        }

        $count = Cart::getTotalItemsForBuyer($buyerId);
        return response()->json(['success' => true, 'count' => $count]);
    }

    /**
     * Get cart total for specific buyer
     */
    public function getTotal()
    {
        $buyerId = $this->getBuyerID();
        if (!$buyerId) {
            return response()->json(['success' => false, 'total' => 0], 401);
        }

        $total = Cart::getSubtotalForBuyer($buyerId);
        return response()->json(['success' => true, 'total' => $total]);
    }

    /**
     * Clear entire cart for buyer
     */
    public function clear()
    {
        $buyerId = $this->getBuyerID();
        if (!$buyerId) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        Cart::clearCartForBuyer($buyerId);
        return response()->json(['success' => true, 'message' => 'Cart cleared successfully']);
    }

    private function getBuyerID()
    {
        return (session('role') === 'buyer') ? session('user_id') : null;
    }

    private function formatCartResponse($cartItems)
    {
        return $cartItems->map(function ($item) {
            return [
                'id' => $item->cart_id,
                'product_id' => $item->product_id,
                'name' => $item->product->product_name ?? 'Unknown',
                'price' => (int) $item->product->price ?? 0,
                'image' => $item->product->image ?? '',
                'quantity' => $item->quantity,
                'total_price' => $item->total_price,
                'type' => $item->product->type
            ];
        });
    }
}
