<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Payment;
use Carbon\Carbon;

class ShippingProgressController extends Controller
{

    public function ToShipping($payment_id)
    {
        $payment = Payment::where('payment_id', $payment_id)->firstOrFail();

        if (
            $payment->transaction_status === 'PROCESSED' &&
            $payment->shipping_ready_at &&
            now()->greaterThanOrEqualTo($payment->shipping_ready_at)
        ) {
            // Update status jadi SHIPPING
            $payment->transaction_status = 'SHIPPING';
            $payment->save();

            // Masukkan ke tabel shipping
            \App\Models\Shipping::create([
                'payment_id' => $payment->payment_id,
                'status' => 'order_ship_out',
                'location' => 'At Warehouse',
                'description' => 'packages are being prepared for shipment',
                'stage_index' => 0,
                'last_updated_at' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Berhasil dipindah ke SHIPPING']);
        }

        return response()->json(['success' => false, 'message' => 'Belum waktunya atau status tidak cocok']);
    }

    public function autoToShipping()
    {
        $now = now();
        $payments = Payment::where('transaction_status', 'PROCESSED')
            ->where('shipping_ready_at', '<=', $now)
            ->get();

        $updated = 0;

        foreach ($payments as $payment) {
            // Cek apakah sudah ada shipping record untuk payment ini
            $existing = Shipping::where('payment_id', $payment->payment_id)->exists();
            if ($existing) continue;

            // Update status
            $payment->transaction_status = 'SHIPPING';
            $payment->save();

            Shipping::create([
                'payment_id' => $payment->payment_id,
                'status' => 'order_ship_out',
                'location' => 'At Warehouse',
                'description' => 'packages are being prepared for shipment',
                'stage_index' => 0,
                'last_updated_at' => $now,
            ]);

            $updated++;
        }

        return response()->json(['updated' => $updated]);
    }

    public function getProgress($payment_id)
    {
        $shipping = Shipping::where('payment_id', $payment_id)->orderByDesc('stage_index')->firstOrFail();

        return response()->json([
            'stage_index' => $shipping->stage_index,
            'last_updated_at' => (string) $shipping->last_updated_at,
            'time_now' => now()->toDateTimeString(),
            'diff' => Carbon::parse($shipping->last_updated_at)->floatDiffInSeconds(now()),
        ]);
    }

    public function nextStage($payment_id)
    {
        $shipping = Shipping::where('payment_id', $payment_id)->orderByDesc('stage_index')->firstOrFail();
        $last = Carbon::parse($shipping->last_updated_at);
        $diff = $last->floatDiffInSeconds(now());

        if ($shipping->stage_index < 4 && $diff >= 5) {
            $shipping->stage_index += 1;
            $shipping->last_updated_at = now();
            $shipping->save();
            $milestones = [
                'order_ship_out' => [
                    'label' => 'Order Ship Out',
                    'location' => 'At Warehouse',
                    'description' => 'packages are being prepared for shipment.'
                ],
                'order_display' => [
                    'label' => 'Order Display',
                    'location' => 'Arrived at Transit Hub',
                    'description' => 'Reached the transit hub.'
                ],
                'haven_staged' => [
                    'label' => 'Haven Staged',
                    'location' => 'At Destination Distribution Center',
                    'description' => 'At the local distro center.'
                ],
                'out_for_delivery' => [
                    'label' => 'Out for Delivery',
                    'location' => 'With Delivery Courier',
                    'description' => 'On the way to your location.'
                ],
                'mission_accomplished' => [
                    'label' => 'Mission Accomplished',
                    'location' => 'Delivered to Recipient',
                    'description' => 'Package delivered.'
                ],
            ];

            $status = array_keys($milestones)[$shipping->stage_index];
            $location = $milestones[$status]['location'];
            $description = $milestones[$status]['description'];

            Shipping::create([
                'payment_id' => $payment_id,
                'status' => $status,
                'location' => $location,
                'description' => $description,
                'stage_index' => $shipping->stage_index,
                'last_updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Stage updated',
                'stage_index' => $shipping->stage_index,
                'status' => $status,
                'diff' => $diff,
            ]);
        }

        if ($shipping->stage_index === 4 && $diff >= 5) {
            $payment = Payment::where('payment_id', $payment_id)->first();
            if ($payment) {
                $payment->transaction_status = 'DELIVERED';
                $payment->completed_at = now();
                $payment->save();
            }

            return response()->json([
                'message' => 'Final stage reached. Status updated to DELIVERED.',
                'delivered' => true,
            ]);
        }

        return response()->json([
            'message' => 'Already at final stage or too early to mark as delivered',
            'stage_index' => $shipping->stage_index,
            'diff' => $diff,
        ]);
    }

    public function getActiveShipping()
    {
        // Ambil semua order yang statusnya SHIPPING
        $activeOrders = Payment::where('transaction_status', 'SHIPPING')
            ->select('payment_id')
            ->get();

        return response()->json([
            'shipping_orders' => $activeOrders
        ]);
    }
}
