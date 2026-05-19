<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransController extends Controller
{
    private function setupMidtrans(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized');
        Config::$is3ds = (bool) config('services.midtrans.is_3ds');
    }

    public function pay(Order $order)
    {
        $order->load([
            'customer',
            'payment',
            'orderItems.service',
        ]);

        if ($order->total_price <= 0) {
            return back()->with('error', 'Total harga belum dihitung. Silakan tunggu admin input berat cucian.');
        }

        if ($order->payment_status === Order::PAYMENT_PAID) {
            return redirect()->route('payment.success', $order->order_code);
        }

        $this->setupMidtrans();

        $midtransOrderId = $order->order_code . '-' . uniqid();

        $params = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->customer->name,
                'phone' => $order->customer->phone,
            ],
            'callbacks' => [
                'finish' => route('payment.success', $order->order_code),
                'error' => route('payment.failed', $order->order_code),
                'pending' => route('tracking.index'),
            ],
            'expiry' => [
                'start_time' => date('Y-m-d H:i:s O'),
                'unit' => 'minutes',
                'duration' => 60,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_code' => $order->payment?->payment_code ?? Payment::generatePaymentCode(),
                'snap_token' => $snapToken,
                'midtrans_order_id' => $midtransOrderId,
                'transaction_id' => null,
                'payment_type' => null,
                'fraud_status' => null,
                'method' => Payment::METHOD_MIDTRANS,
                'status' => Payment::STATUS_UNPAID,
                'amount' => $order->total_price,
                'cash_received' => null,
                'change_amount' => null,
                'paid_at' => null,
                'notes' => 'Pembayaran online melalui Midtrans.',
            ]
        );

        return view('payment.index', [
            'order' => $order,
            'snapToken' => $snapToken,
            'clientKey' => config('services.midtrans.client_key'),
            'isProduction' => (bool) config('services.midtrans.is_production'),
        ]);
    }

    public function notification(Request $request)
    {
        $this->setupMidtrans();

        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status ?? null;
        $midtransOrderId = $notification->order_id;
        $transactionId = $notification->transaction_id ?? null;
        $paymentType = $notification->payment_type ?? null;

        $payment = Payment::where('midtrans_order_id', $midtransOrderId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        DB::transaction(function () use (
            $payment,
            $transactionStatus,
            $fraudStatus,
            $transactionId,
            $paymentType
        ) {
            $order = $payment->order;

            $isPaid = in_array($transactionStatus, ['capture', 'settlement'], true);

            if ($transactionStatus === 'capture' && $fraudStatus === 'challenge') {
                $isPaid = false;
            }

            if ($isPaid) {
                $payment->update([
                    'status' => Payment::STATUS_PAID,
                    'transaction_id' => $transactionId,
                    'payment_type' => $paymentType,
                    'fraud_status' => $fraudStatus,
                    'paid_at' => now(),
                    'notes' => 'Pembayaran Midtrans berhasil.',
                ]);

                $order->update([
                    'payment_status' => Order::PAYMENT_PAID,
                ]);
            }

            if (in_array($transactionStatus, ['deny', 'expire', 'cancel'], true)) {
                $payment->update([
                    'status' => Payment::STATUS_FAILED,
                    'transaction_id' => $transactionId,
                    'payment_type' => $paymentType,
                    'fraud_status' => $fraudStatus,
                    'notes' => 'Pembayaran Midtrans gagal / expired / dibatalkan.',
                ]);
            }
        });

        return response()->json(['message' => 'OK']);
    }

    public function simulateSuccess(Order $order)
    {
        if ((bool) config('services.midtrans.is_production')) {
            abort(403, 'Simulasi pembayaran hanya boleh digunakan di mode sandbox/demo.');
        }

        if ($order->total_price <= 0) {
            return back()->with('error', 'Total harga belum dihitung. Silakan tunggu admin input berat cucian.');
        }

        if ($order->payment_status === Order::PAYMENT_PAID) {
            return redirect()
                ->route('payment.success', $order->order_code)
                ->with('success', 'Pembayaran pesanan ini sudah berhasil.');
        }

        DB::transaction(function () use ($order) {
            $order->load('payment');

            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_code' => $order->payment?->payment_code ?? Payment::generatePaymentCode(),
                    'snap_token' => $order->payment?->snap_token,
                    'midtrans_order_id' => $order->payment?->midtrans_order_id ?? $order->order_code . '-SIM-' . now()->format('YmdHis'),
                    'transaction_id' => 'SIM-' . now()->timestamp,
                    'payment_type' => 'qris',
                    'fraud_status' => 'accept',
                    'method' => Payment::METHOD_MIDTRANS,
                    'status' => Payment::STATUS_PAID,
                    'amount' => $order->total_price,
                    'cash_received' => null,
                    'change_amount' => null,
                    'paid_at' => now(),
                    'notes' => 'Pembayaran disimulasikan berhasil untuk demo/sandbox.',
                ]
            );

            $order->update([
                'payment_status' => Order::PAYMENT_PAID,
            ]);
        });

        return redirect()
            ->route('payment.success', $order->order_code)
            ->with('success', 'Pembayaran berhasil disimulasikan.');
    }

    public function success(Order $order)
    {
        $order->load(['customer', 'payment']);

        return view('payment.success', [
            'order' => $order,
        ]);
    }

    public function failed(Order $order)
    {
        $order->load(['customer', 'payment']);

        return view('payment.failed', [
            'order' => $order,
        ]);
    }
}