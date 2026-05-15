<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PickupOption;
use App\Models\Service;
use App\Models\StatusLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $ordersQuery = Order::query()
            ->with(['customer', 'orderItems.service', 'pickupOption', 'payment'])
            ->latest();

        if ($search !== '') {
            $ordersQuery->where(function ($query) use ($search) {
                $query->where('order_code', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $ordersQuery->get();

        $incomingOrders = $orders->where('status', Order::STATUS_MENUNGGU_VERIFIKASI);

        $approvedOrders = $orders->where('status', Order::STATUS_DIJEMPUT);

        $activeOrders = $orders->whereIn('status', [
            Order::STATUS_DIPROSES,
            Order::STATUS_MENUNGGU_PEMBAYARAN,
            Order::STATUS_DIANTAR,
        ]);

        $finishedOrders = $orders->whereIn('status', [
            Order::STATUS_SELESAI,
            Order::STATUS_SELESAI_DITERIMA,
        ]);

        $cancelledOrders = $orders->where('status', Order::STATUS_DIBATALKAN);

        $todayRevenue = Payment::query()
            ->where('status', Payment::STATUS_PAID)
            ->whereDate('paid_at', now()->toDateString())
            ->sum('amount');

        $services = Service::query()
            ->orderBy('category')
            ->orderBy('price_per_kg')
            ->get();

        $pickupOptions = PickupOption::query()
            ->orderByDesc('is_active')
            ->orderBy('id')
            ->get();

        $paymentOrders = $orders
            ->where('total_price', '>', 0)
            ->where('payment_status', Order::PAYMENT_UNPAID);

        $stats = [
            'incoming_orders' => $incomingOrders->count(),
            'approved_orders' => $approvedOrders->count(),
            'pickup_orders' => $approvedOrders->count(),
            'processing_orders' => $activeOrders->count(),
            'finished_orders' => $finishedOrders->count(),
            'cancelled_orders' => $cancelledOrders->count(),
            'today_revenue' => $todayRevenue,
            'paid_orders' => $orders->where('payment_status', Order::PAYMENT_PAID)->count(),
            'unpaid_orders' => $orders->where('payment_status', Order::PAYMENT_UNPAID)->count(),
        ];

        return view('admin.dashboard', [
            'orders' => $orders,
            'incomingOrders' => $incomingOrders,
            'approvedOrders' => $approvedOrders,
            'activeOrders' => $activeOrders,
            'finishedOrders' => $finishedOrders,
            'cancelledOrders' => $cancelledOrders,
            'paymentOrders' => $paymentOrders,
            'services' => $services,
            'pickupOptions' => $pickupOptions,
            'stats' => $stats,
            'search' => $search,
        ]);
    }

    public function showOrder(Order $order): View
    {
        $order->load([
            'customer',
            'orderItems.service',
            'pickupOption',
            'payment',
            'statusLogs',
        ]);

        return view('admin.order-detail', [
            'order' => $order,
        ]);
    }

    public function approveOrder(Order $order): RedirectResponse
    {
        $this->changeStatus(
            order: $order,
            newStatus: Order::STATUS_DIJEMPUT,
            description: 'Pesanan disetujui admin. Kurir akan menjemput pakaian.'
        );

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Pesanan berhasil di-ACC dan pindah ke bagian ACC/Dijemput.');
    }

    public function rejectOrder(Order $order): RedirectResponse
    {
        $orderCode = $order->order_code;

        $order->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', "Pesanan {$orderCode} ditolak dan otomatis dihapus.");
    }

    public function deleteOrder(Order $order): RedirectResponse
    {
        $orderCode = $order->order_code;

        $order->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', "Pesanan {$orderCode} berhasil dihapus.");
    }

    public function updateWeight(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'weight' => ['required', 'numeric', 'min:0.1', 'max:999'],
        ], [
            'weight.required' => 'Berat cucian wajib diisi.',
            'weight.numeric' => 'Berat cucian harus berupa angka.',
            'weight.min' => 'Berat cucian minimal 0.1 kg.',
        ]);

        $weight = (float) $validated['weight'];

        DB::transaction(function () use ($order, $weight) {
            $order->load('orderItems.service');

            $totalPrice = 0;

            foreach ($order->orderItems as $item) {
                $service = $item->service;

                if (!$service) {
                    continue;
                }

                $subtotal = (int) round($service->price_per_kg * $weight);

                $item->update([
                    'qty' => $weight,
                    'subtotal' => $subtotal,
                ]);

                $totalPrice += $subtotal;
            }

            $oldStatus = $order->status;

            $order->update([
                'weight' => $weight,
                'total_price' => $totalPrice,
                'status' => Order::STATUS_MENUNGGU_PEMBAYARAN,
                'payment_status' => Order::PAYMENT_UNPAID,
            ]);

            $this->createStatusLog(
                order: $order,
                oldStatus: $oldStatus,
                newStatus: Order::STATUS_MENUNGGU_PEMBAYARAN,
                description: 'Admin memasukkan berat cucian dan sistem menghitung total harga.'
            );

            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_code' => $order->payment?->payment_code ?? Payment::generatePaymentCode(),
                    'method' => Payment::METHOD_QRIS,
                    'status' => Payment::STATUS_UNPAID,
                    'amount' => $totalPrice,
                    'cash_received' => null,
                    'change_amount' => null,
                    'paid_at' => null,
                    'notes' => 'Tagihan dibuat setelah penimbangan aktual.',
                ]
            );
        });

        return back()->with('success', 'Berat cucian berhasil disimpan dan total harga berhasil dihitung.');
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    Order::STATUS_MENUNGGU_VERIFIKASI,
                    Order::STATUS_DIJEMPUT,
                    Order::STATUS_DIPROSES,
                    Order::STATUS_MENUNGGU_PEMBAYARAN,
                    Order::STATUS_SELESAI,
                    Order::STATUS_DIANTAR,
                    Order::STATUS_SELESAI_DITERIMA,
                    Order::STATUS_DIBATALKAN,
                ]),
            ],
        ], [
            'status.required' => 'Status pesanan wajib dipilih.',
        ]);

        $this->changeStatus(
            order: $order,
            newStatus: $validated['status'],
            description: 'Admin memperbarui status pesanan.'
        );

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function confirmCashPayment(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'cash_received' => ['required', 'integer', 'min:' . max((int) $order->total_price, 1)],
        ], [
            'cash_received.required' => 'Nominal uang diterima wajib diisi.',
            'cash_received.min' => 'Nominal uang diterima tidak boleh kurang dari total harga.',
        ]);

        if ($order->total_price <= 0) {
            return back()->with('error', 'Total harga belum dihitung. Silakan input berat cucian terlebih dahulu.');
        }

        $cashReceived = (int) $validated['cash_received'];
        $changeAmount = max($cashReceived - (int) $order->total_price, 0);

        DB::transaction(function () use ($order, $cashReceived, $changeAmount) {
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_code' => $order->payment?->payment_code ?? Payment::generatePaymentCode(),
                    'method' => Payment::METHOD_CASH,
                    'status' => Payment::STATUS_PAID,
                    'amount' => $order->total_price,
                    'cash_received' => $cashReceived,
                    'change_amount' => $changeAmount,
                    'paid_at' => now(),
                    'notes' => 'Pembayaran tunai dikonfirmasi oleh admin.',
                ]
            );

            $order->update([
                'payment_status' => Order::PAYMENT_PAID,
            ]);
        });

        return back()->with('success', 'Pembayaran tunai berhasil dikonfirmasi.');
    }

    public function storeService(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_name' => ['required', 'string', 'max:100'],
            'category' => ['required', Rule::in(['paket', 'wangi'])],
            'price_per_kg' => ['required', 'integer', 'min:0'],
        ]);

        Service::create($validated);

        return back()->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function updateService(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'service_name' => ['required', 'string', 'max:100'],
            'category' => ['required', Rule::in(['paket', 'wangi'])],
            'price_per_kg' => ['required', 'integer', 'min:0'],
        ]);

        $service->update($validated);

        return back()->with('success', 'Layanan berhasil diperbarui.');
    }

    public function deleteService(Service $service): RedirectResponse
    {
        if ($service->orderItems()->exists()) {
            return back()->with('error', 'Layanan tidak bisa dihapus karena sudah dipakai pada pesanan.');
        }

        $service->delete();

        return back()->with('success', 'Layanan berhasil dihapus.');
    }

    public function storePickupOption(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:100', 'unique:pickup_options,code'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        PickupOption::create([
            'name' => $validated['name'],
            'code' => str($validated['code'])->slug('_'),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Opsi antar jemput berhasil ditambahkan.');
    }

    public function updatePickupOption(Request $request, PickupOption $pickupOption): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('pickup_options', 'code')->ignore($pickupOption->id),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $pickupOption->update([
            'name' => $validated['name'],
            'code' => str($validated['code'])->slug('_'),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Opsi antar jemput berhasil diperbarui.');
    }

    public function deletePickupOption(PickupOption $pickupOption): RedirectResponse
    {
        if ($pickupOption->orders()->exists()) {
            return back()->with('error', 'Opsi tidak bisa dihapus karena sudah dipakai pada pesanan.');
        }

        $pickupOption->delete();

        return back()->with('success', 'Opsi antar jemput berhasil dihapus.');
    }

    private function changeStatus(Order $order, string $newStatus, string $description): void
    {
        DB::transaction(function () use ($order, $newStatus, $description) {
            $oldStatus = $order->status;

            $order->update([
                'status' => $newStatus,
            ]);

            $this->createStatusLog(
                order: $order,
                oldStatus: $oldStatus,
                newStatus: $newStatus,
                description: $description
            );
        });
    }

    private function createStatusLog(Order $order, ?string $oldStatus, string $newStatus, string $description): void
    {
        $payload = [
            'order_id' => $order->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'updated_by' => 'admin',
        ];

        if (Schema::hasColumn('status_logs', 'description')) {
            $payload['description'] = $description;
        }

        StatusLog::create($payload);
    }
}