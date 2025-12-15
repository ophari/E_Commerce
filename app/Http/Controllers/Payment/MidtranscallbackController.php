<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        $notif = json_decode($request->getContent());

        $order = Order::where('invoice_number', $notif->order_id)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 🔒 STOP kalau order sudah diproses
        if (in_array($order->status, ['paid', 'processing', 'shipped', 'delivered'])) {
            return response()->json([
                'message' => 'Order already processed',
                'status'  => $order->status
            ], 200);
        }

        // ✅ pembayaran sukses
        if (in_array($notif->transaction_status, ['capture', 'settlement'])) {
            $order->update(['status' => 'paid']);

            // kurangi stok
            foreach ($order->orderItems as $item) {
                Product::where('id', $item->product_id)
                    ->decrement('stock', $item->quantity);
            }

            // hapus cart user
            Cart::where('user_id', $order->user_id)->delete();
        }

        return response()->json(['message' => 'OK']);
    }

    public function pay(Request $request)
    {
        $userId = Auth::id();

        $order = Order::where('id', $request->order_id)
                    ->where('user_id', $userId)
                    ->firstOrFail();

        // Tambahkan duluan
        if ($order->status === 'paid') {
            return redirect()->route('user.orders')
                    ->with('success', 'Pembayaran berhasil! Pesanan kamu sudah dibayar.');
        }

        // Hanya unpaid atau pending boleh bayar
        if (!in_array($order->status, ['unpaid', 'pending'])) {
            return redirect()->route('user.orders')
                ->with('error', 'Order tidak bisa dibayar lagi karena status: ' . $order->status);
        }

        // Pastikan invoice_number ada
        if (!$order->invoice_number) {
            $order->invoice_number = 'INV-' . time() . '-' . $order->id;
            $order->save();
        }

        return $this->generateMidtransToken($order);
    }

    /**
     * Generate Snap Token Midtrans
     */
    private function generateMidtransToken($order)
    {
        // Config default Midtrans
        \Midtrans\Config::$serverKey    = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        // Hack: Cap amount for Sandbox testing to avoid QRIS limits
        $grossAmount = (int) $order->total_price;
        if (!config('services.midtrans.is_production') && $grossAmount > 1000000) {
            $grossAmount = 1000000;
        }

        $params = [
            'transaction_details' => [
                // Tambah timestamp agar selalu unik
                'order_id'     => $order->invoice_number,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name'   => Auth::user()->name,
                'email'        => Auth::user()->email,
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
