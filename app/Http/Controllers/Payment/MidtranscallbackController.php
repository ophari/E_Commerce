<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MidtransCallbackController extends Controller
{
    /**
     * Handle callback from Midtrans
     */
    public function callback(Request $request)
    {
        $notification = json_decode($request->getContent());

        if (!$notification || !isset($notification->order_id)) {
            return response()->json(['message' => 'Invalid callback'], 400);
        }

        $rawOrderId = explode('-', $notification->order_id);
        $invoiceNumber = implode('-', array_slice($rawOrderId, 0, -1));

        // Cari order berdasarkan invoice_number
        $order = Order::where('invoice_number', $invoiceNumber)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        /**
         * Jika order SUDAH masuk proses toko → Midtrans tidak boleh mengubah status.
         * Ini mencegah status paid/delivered berubah jadi pending ulang.
         */
        if (in_array($order->status, ['processing', 'shipped', 'delivered', 'paid'])) {
            return response()->json([
                'message' => 'Order already processed',
                'status'  => $order->status
            ], 200);
        }

        // Ambil status dari Midtrans
        $transaction = $notification->transaction_status;
        $payment     = $notification->payment_type ?? null;
        $fraud       = $notification->fraud_status ?? null;

        // Mapping status Midtrans → status order
        switch ($transaction) {

            case 'capture':
                // Credit card fraud detection
                $order->status = ($payment === 'credit_card' && $fraud === 'challenge')
                    ? 'unpaid'
                    : 'paid';
                break;

            case 'settlement':
                $order->status = 'paid';
                session()->flash('success', 'Pembayaran berhasil! Pesanan kamu telah dikonfirmasi oleh Midtrans.');
                break;

            case 'pending':
                $order->status = 'pending';
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $order->status = 'cancelled';
                break;

            default:
                $order->status = 'unpaid';
                break;
        }

        $order->save();

        return response()->json([
            'message' => 'Callback processed',
            'status'  => $order->status
        ], 200);
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
     * Confirm order dari halaman checkout
     */
    public function confirm(Request $request)
    {
        $userId = Auth::id();

        $order = Order::where('id', $request->order_id)
                      ->where('user_id', $userId)
                      ->firstOrFail();

        if ($order->status === 'paid') {
            return redirect()->route('user.orders')
                ->with('success', 'Order sudah dibayar.');
        }

        // Pastikan invoice number ada
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

        $params = [
            'transaction_details' => [
                // Tambah timestamp agar selalu unik
                'order_id'     => $order->invoice_number . '-' . time(),
                'gross_amount' => (int) $order->total_price,
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
