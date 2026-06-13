<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\PickupOption;
use App\Models\Service;
use App\Models\StatusLog;
use App\Models\StoreStatus;
use App\Models\Customer;
use App\Models\OrderItem;
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
        $searchMasuk = trim((string) $request->query('search_masuk'));
        $searchDiproses = trim((string) $request->query('search_diproses'));
        $searchSelesai = trim((string) $request->query('search_selesai'));

        $allOrders = Order::query()
            ->with(['customer', 'orderItems.service', 'pickupOption', 'payment'])
            ->latest()
            ->get();

        $incomingOrders = $this->orderSectionQuery(
            statuses: [Order::STATUS_MENUNGGU_VERIFIKASI],
            search: $searchMasuk
        )->get();

        $processedOrders = $this->orderSectionQuery(
            statuses: [
                Order::STATUS_DIJEMPUT,
                Order::STATUS_DIPROSES,
                Order::STATUS_MENUNGGU_PEMBAYARAN,
                Order::STATUS_DIANTAR,
            ],
            search: $searchDiproses
        )->get();

        $finishedOrders = $this->orderSectionQuery(
            statuses: [
                Order::STATUS_SELESAI,
                Order::STATUS_SELESAI_DITERIMA,
            ],
            search: $searchSelesai
        )->get();

        $approvedOrders = $processedOrders->where('status', Order::STATUS_DIJEMPUT);

        $activeOrders = $processedOrders->whereIn('status', [
            Order::STATUS_DIPROSES,
            Order::STATUS_MENUNGGU_PEMBAYARAN,
            Order::STATUS_DIANTAR,
        ]);

        $cancelledOrders = $allOrders->where('status', Order::STATUS_DIBATALKAN);

        $todayRevenue = Payment::query()
            ->where('status', Payment::STATUS_PAID)
            ->whereDate('paid_at', now()->toDateString())
            ->sum('amount');

        $services = Service::query()
            ->orderByRaw("FIELD(category, 'paket', 'layanan', 'wangi')")
            ->orderBy('price_per_kg')
            ->get();

        $packages = $services->where('category', Service::CATEGORY_PAKET);
        $serviceTypes = $services->where('category', Service::CATEGORY_LAYANAN);
        $fragrances = $services->where('category', Service::CATEGORY_WANGI);

        $pickupOptions = PickupOption::query()
            ->orderByDesc('is_active')
            ->orderBy('id')
            ->get();

        $paymentOrders = $allOrders
            ->where('total_price', '>', 0)
            ->where('payment_status', Order::PAYMENT_UNPAID);

        $storeStatus = StoreStatus::query()->firstOrCreate(
            ['id' => 1],
            [
                'is_open' => true,
                'status_note' => 'Laundry buka normal.',
            ]
        );

        $stats = [
            'incoming_orders' => $allOrders->where('status', Order::STATUS_MENUNGGU_VERIFIKASI)->count(),
            'approved_orders' => $allOrders->where('status', Order::STATUS_DIJEMPUT)->count(),
            'pickup_orders' => $allOrders->where('status', Order::STATUS_DIJEMPUT)->count(),
            'processing_orders' => $allOrders->whereIn('status', [
                Order::STATUS_DIPROSES,
                Order::STATUS_MENUNGGU_PEMBAYARAN,
                Order::STATUS_DIANTAR,
            ])->count(),
            'finished_orders' => $allOrders->whereIn('status', [
                Order::STATUS_SELESAI,
                Order::STATUS_SELESAI_DITERIMA,
            ])->count(),
            'cancelled_orders' => $cancelledOrders->count(),
            'today_revenue' => $todayRevenue,
            'paid_orders' => $allOrders->where('payment_status', Order::PAYMENT_PAID)->count(),
            'unpaid_orders' => $allOrders->where('payment_status', Order::PAYMENT_UNPAID)->count(),
        ];

        return view('admin.dashboard', [
            'orders' => $allOrders,
            'incomingOrders' => $incomingOrders,
            'processedOrders' => $processedOrders,
            'approvedOrders' => $approvedOrders,
            'activeOrders' => $activeOrders,
            'finishedOrders' => $finishedOrders,
            'cancelledOrders' => $cancelledOrders,
            'paymentOrders' => $paymentOrders,
            'services' => $services,
            'packages' => $packages,
            'serviceTypes' => $serviceTypes,
            'fragrances' => $fragrances,
            'pickupOptions' => $pickupOptions,
            'storeStatus' => $storeStatus,
            'stats' => $stats,
            'searchMasuk' => $searchMasuk,
            'searchDiproses' => $searchDiproses,
            'searchSelesai' => $searchSelesai,
        ]);
    }

    private function orderSectionQuery(array $statuses, string $search)
    {
        $query = Order::query()
            ->with(['customer', 'orderItems.service', 'pickupOption', 'payment'])
            ->whereIn('status', $statuses)
            ->latest();

        if ($search !== '') {
            $query->where(function ($orderQuery) use ($search) {
                $orderQuery
                    ->where('order_code', 'like', "%{$search}%")
                    ->orWhere('pickup_option_name', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('address', 'like', "%{$search}%")
                            ->orWhere('city', 'like', "%{$search}%")
                            ->orWhere('district', 'like', "%{$search}%")
                            ->orWhere('village', 'like', "%{$search}%");
                    })
                    ->orWhereHas('orderItems.service', function ($serviceQuery) use ($search) {
                        $serviceQuery
                            ->where('service_name', 'like', "%{$search}%")
                            ->orWhere('category', 'like', "%{$search}%");
                    })
                    ->orWhereHas('pickupOption', function ($pickupQuery) use ($search) {
                        $pickupQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
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
        if ($this->isLockedOrder($order)) {
            return back()->with('error', 'Pesanan sudah selesai diterima dan tidak bisa diubah lagi.');
        }

        $this->changeStatus(
            order: $order,
            newStatus: Order::STATUS_DIJEMPUT,
            description: 'Pesanan disetujui admin. Kurir akan menjemput pakaian.'
        );

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Pesanan berhasil di-ACC dan pindah ke bagian ACC/Dijemput.');
    }
    public function storeManualOrder(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:100'],
        'phone' => ['required', 'string', 'min:10', 'max:20'],
        'address' => ['required', 'string', 'max:1000'],

        'service_id' => [
            'required',
            Rule::exists('services', 'id')->where('category', Service::CATEGORY_PAKET),
        ],
        'service_type_id' => [
            'required',
            Rule::exists('services', 'id')->where('category', Service::CATEGORY_LAYANAN),
        ],
        'fragrance_id' => [
            'nullable',
            Rule::exists('services', 'id')->where('category', Service::CATEGORY_WANGI),
        ],
        'pickup_option_id' => [
            'required',
            Rule::exists('pickup_options', 'id')->where(function ($query) {
                $query
                    ->where('is_active', true)
                    ->where('code', '!=', 'antar_ambil_sendiri')
                    ->where('name', 'not like', '%Ambil Sendiri%');
            }),
        ],
        'notes' => ['nullable', 'string', 'max:1000'],
    ], [
        'name.required' => 'Nama pelanggan wajib diisi.',
        'phone.required' => 'Nomor HP pelanggan wajib diisi.',
        'phone.min' => 'Nomor HP minimal 10 digit.',
        'address.required' => 'Alamat pelanggan wajib diisi.',
        'service_id.required' => 'Paket wajib dipilih.',
        'service_type_id.required' => 'Layanan wajib dipilih.',
        'pickup_option_id.required' => 'Opsi antar jemput wajib dipilih.',
    ]);

    $package = Service::query()
        ->where('id', $validated['service_id'])
        ->where('category', Service::CATEGORY_PAKET)
        ->firstOrFail();

    $serviceType = Service::query()
        ->where('id', $validated['service_type_id'])
        ->where('category', Service::CATEGORY_LAYANAN)
        ->firstOrFail();

    $fragrance = null;

    if (!empty($validated['fragrance_id'])) {
        $fragrance = Service::query()
            ->where('id', $validated['fragrance_id'])
            ->where('category', Service::CATEGORY_WANGI)
            ->firstOrFail();
    }

    $pickupOption = PickupOption::query()
        ->where('id', $validated['pickup_option_id'])
        ->where('is_active', true)
        ->firstOrFail();

    $order = DB::transaction(function () use ($validated, $package, $serviceType, $fragrance, $pickupOption) {
        $customer = Customer::updateOrCreate(
            ['phone' => $validated['phone']],
            [
                'name' => $validated['name'],
                'address' => $validated['address'],
            ]
        );

        $legacyPickupType = in_array($pickupOption->code, Order::legacyPickupTypes(), true)
            ? $pickupOption->code
            : 'dijemput_antar';

        $order = Order::create([
            'customer_id' => $customer->id,
            'order_code' => Order::generateOrderCode(),
            'pickup_type' => $legacyPickupType,
            'pickup_option_id' => $pickupOption->id,
            'pickup_option_name' => $pickupOption->name,
            'status' => Order::STATUS_MENUNGGU_VERIFIKASI,
            'payment_status' => Order::PAYMENT_UNPAID,
            'weight' => null,
            'total_price' => 0,
            'notes' => $validated['notes'] ?? 'Pesanan dibuat manual oleh admin.',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'service_id' => $package->id,
            'qty' => 1,
            'subtotal' => 0,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'service_id' => $serviceType->id,
            'qty' => 1,
            'subtotal' => 0,
        ]);

        if ($fragrance) {
            OrderItem::create([
                'order_id' => $order->id,
                'service_id' => $fragrance->id,
                'qty' => 1,
                'subtotal' => 0,
            ]);
        }

        $statusLog = [
            'order_id' => $order->id,
            'old_status' => null,
            'new_status' => Order::STATUS_MENUNGGU_VERIFIKASI,
            'updated_by' => 'admin',
        ];

        if (Schema::hasColumn('status_logs', 'description')) {
            $statusLog['description'] = 'Pesanan dibuat manual oleh admin dan menunggu verifikasi.';
        }

        StatusLog::create($statusLog);

        return $order;
    });

    return redirect()
        ->route('admin.dashboard')
        ->with('success', "Pesanan manual {$order->order_code} berhasil dibuat.");
}

    public function rejectOrder(Order $order): RedirectResponse
    {
        if ($this->isLockedOrder($order)) {
            return back()->with('error', 'Pesanan sudah selesai diterima dan tidak bisa ditolak/dihapus dari proses.');
        }

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

    public function approveAllIncomingOrders(): RedirectResponse
    {
        $orders = Order::query()
            ->where('status', Order::STATUS_MENUNGGU_VERIFIKASI)
            ->get();

        foreach ($orders as $order) {
            $this->changeStatus(
                order: $order,
                newStatus: Order::STATUS_DIJEMPUT,
                description: 'Pesanan disetujui admin melalui tombol Terima Semua.'
            );
        }

        return back()->with('success', $orders->count() . ' pesanan berhasil diterima.');
    }

    public function rejectAllIncomingOrders(): RedirectResponse
    {
        $count = Order::query()
            ->where('status', Order::STATUS_MENUNGGU_VERIFIKASI)
            ->delete();

        return back()->with('success', $count . ' pesanan masuk berhasil ditolak dan dihapus.');
    }

    public function updateWeight(Request $request, Order $order): RedirectResponse
    {
        if ($this->isLockedOrder($order)) {
            return back()->with('error', 'Pesanan sudah selesai diterima. Berat cucian tidak bisa diubah lagi.');
        }

        $validated = $request->validate([
            'weight' => ['required', 'numeric', 'min:0.1', 'max:999'],
        ], [
            'weight.required' => 'Berat cucian wajib diisi.',
            'weight.numeric' => 'Berat cucian harus berupa angka.',
            'weight.min' => 'Berat cucian minimal 0.1 kg.',
        ]);

        $weight = (float) $validated['weight'];

        DB::transaction(function () use ($order, $weight) {
            $order->load(['orderItems.service', 'pickupOption']);

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

            if ($order->pickupOption && Schema::hasColumn('pickup_options', 'price')) {
                $totalPrice += (int) $order->pickupOption->price;
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
        if ($this->isLockedOrder($order)) {
            return back()->with('error', 'Pesanan sudah selesai diterima. Status tidak bisa diubah lagi.');
        }

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
        if ($this->isLockedOrder($order)) {
            return back()->with('error', 'Pesanan sudah selesai diterima. Pembayaran tidak bisa diubah lagi.');
        }

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
            'category' => ['required', Rule::in(['paket', 'layanan', 'wangi'])],
            'price_per_kg' => ['required', 'integer', 'min:0'],
        ]);

        Service::create($validated);

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function updateService(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'service_name' => ['required', 'string', 'max:100'],
            'category' => ['required', Rule::in(['paket', 'layanan', 'wangi'])],
            'price_per_kg' => ['required', 'integer', 'min:0'],
        ]);

        $service->update($validated);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function deleteService(Service $service): RedirectResponse
    {
        if ($service->orderItems()->exists()) {
            return back()->with('error', 'Data tidak bisa dihapus karena sudah dipakai pada pesanan.');
        }

        $service->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function storePickupOption(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:100', 'unique:pickup_options,code'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        PickupOption::create([
            'name' => $validated['name'],
            'code' => str($validated['code'])->slug('_'),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
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
            'price' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $pickupOption->update([
            'name' => $validated['name'],
            'code' => str($validated['code'])->slug('_'),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
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

    public function updateStoreStatus(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'is_open' => ['required', 'boolean'],
            'status_note' => ['nullable', 'string', 'max:255'],
        ]);

        StoreStatus::query()->updateOrCreate(
            ['id' => 1],
            $validated
        );

        return back()->with('success', 'Status toko berhasil diperbarui.');
    }

    private function isLockedOrder(Order $order): bool
    {
        return $order->status === Order::STATUS_SELESAI_DITERIMA;
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
