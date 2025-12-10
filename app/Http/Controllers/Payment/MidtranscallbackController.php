<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MidtransCallbackController extends Controller
{
    // Callback dari Midtrans
    public function callback(Request $request)
    {
        $notification = json_decode($request->getContent());

        if (!$notification || !isset($notification->order_id)) {
            return response()->json(['message' => 'Invalid callback'], 400);
        }

        // Cari order
        $order = Order::where('invoice_number', $notification->order_id)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transaction = $notification->transaction_status;
        $payment     = $notification->payment_type ?? null;
        $fraud       = $notification->fraud_status ?? null;

        // Kalau pesanan sudah shipped atau delivered → Midtrans tidak boleh ubah
        if (in_array($order->status, ['processing', 'shipped', 'delivered'])) {
            return response()->json([
                'message' => 'Order already processed',
                'status'  => $order->status
            ], 200);
        }

        // MIDTRANS → STATUS PEMBAYARAN
        if ($transaction == 'capture') {

            if ($payment == 'credit_card' && $fraud == 'challenge') {
                $order->status = 'unpaid';
            } else {
                $order->status = 'paid';
            }

        } elseif ($transaction == 'settlement') {

            $order->status = 'paid';

        } elseif ($transaction == 'pending') {

            $order->status = 'pending';

        } elseif (in_array($transaction, ['deny', 'expire'])) {

            $order->status = 'unpaid';

        } elseif ($transaction == 'cancel') {

            $order->status = 'cancelled';
        }

        $order->save();

        return response()->json([
            'message' => 'Callback processed',
            'status'  => $order->status
        ], 200);
    }


    // Fungsi untuk panggil Midtrans dari tombol "Bayar Sekarang"
    public function confirm(Request $request)
    {
        $userId = Auth::id();
        $order = Order::where('id', $request->order_id)
                      ->where('user_id', $userId)
                      ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('user.orders')
                             ->with('error', 'Order sudah dibayar atau sedang diproses.');
        }

        // Update status sementara menjadi pending
        $order->status = 'pending';
        $order->save();

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id . '-' . time(),
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return view('user.checkout.payment', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            return redirect()->route('user.orders')
                             ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function pay(Request $request)
    {
        $userId = Auth::id();
        $order = Order::where('id', $request->order_id)
                    ->where('user_id', $userId)
                    ->firstOrFail();

        if ($order->status !== 'unpaid') {
            return redirect()->route('user.orders')
                            ->with('error', 'Order sudah dibayar atau sedang diproses.');
        }

        // Update status menjadi pending sebelum panggil Midtrans
        $order->status = 'pending';
        $order->save();

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id . '-' . time(),
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return view('user.checkout.payment', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            return redirect()->route('user.orders')
                            ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

}
