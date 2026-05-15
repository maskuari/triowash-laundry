<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(): View
    {
        return view('tracking.index', [
            'order' => null,
            'searched' => false,
            'trackingSteps' => $this->trackingSteps(),
        ]);
    }

    public function search(Request $request): View
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'min:10', 'max:20'],
        ], [
            'name.required' => 'Nama pelanggan wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.min' => 'Nomor telepon tidak valid, minimal 10 digit.',
        ]);

        $phone = $this->normalizePhone($validated['phone']);
        $name = trim($validated['name']);

        $customer = Customer::query()
            ->where('phone', $phone)
            ->whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->first();

        $order = null;

        if ($customer) {
            $order = Order::query()
                ->with([
                    'customer',
                    'orderItems.service',
                    'pickupOption',
                    'payment',
                    'statusLogs',
                ])
                ->where('customer_id', $customer->id)
                ->whereNotIn('status', [
                    Order::STATUS_SELESAI_DITERIMA,
                    Order::STATUS_DIBATALKAN,
                ])
                ->latest()
                ->first();
        }

        return view('tracking.index', [
            'order' => $order,
            'searched' => true,
            'trackingSteps' => $this->trackingSteps(),
        ]);
    }

    private function normalizePhone(string $phone): string
    {
        return preg_replace('/\D/', '', $phone);
    }

    private function trackingSteps(): array
    {
        return [
            [
                'status' => Order::STATUS_MENUNGGU_VERIFIKASI,
                'label' => 'Verifikasi',
                'description' => 'Pesanan masuk dan menunggu ACC admin.',
                'icon' => 'bi-check-lg',
            ],
            [
                'status' => Order::STATUS_DIJEMPUT,
                'label' => 'Dijemput',
                'description' => 'Kurir menjemput cucian pelanggan.',
                'icon' => 'bi-truck',
            ],
            [
                'status' => Order::STATUS_DIPROSES,
                'label' => 'Diproses',
                'description' => 'Pakaian sedang dicuci atau dikerjakan.',
                'icon' => 'bi-droplet-half',
            ],
            [
                'status' => Order::STATUS_MENUNGGU_PEMBAYARAN,
                'label' => 'Menunggu Pembayaran',
                'description' => 'Pesanan selesai dihitung dan menunggu pembayaran.',
                'icon' => 'bi-wallet2',
            ],
            [
                'status' => Order::STATUS_SELESAI,
                'label' => 'Selesai',
                'description' => 'Pengerjaan selesai dan menunggu diantar atau diambil.',
                'icon' => 'bi-box-seam',
            ],
            [
                'status' => Order::STATUS_DIANTAR,
                'label' => 'Diantar',
                'description' => 'Pesanan sedang dalam perjalanan pengantaran.',
                'icon' => 'bi-truck',
            ],
            [
                'status' => Order::STATUS_SELESAI_DITERIMA,
                'label' => 'Diterima',
                'description' => 'Pesanan sudah diterima pelanggan.',
                'icon' => 'bi-house-check',
            ],
        ];
    }
}