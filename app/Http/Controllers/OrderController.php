<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PickupOption;
use App\Models\Service;
use App\Models\StatusLog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function create(): View
    {
        $packages = Service::query()
            ->where('category', Service::CATEGORY_PAKET)
            ->orderBy('price_per_kg')
            ->get();

        $serviceTypes = Service::query()
            ->where('category', Service::CATEGORY_LAYANAN)
            ->orderBy('price_per_kg')
            ->get();

        $fragrances = Service::query()
            ->where('category', Service::CATEGORY_WANGI)
            ->orderBy('price_per_kg')
            ->get();

        $pickupOptions = PickupOption::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        return view('order.order', [
            'packages' => $packages,
            'serviceTypes' => $serviceTypes,
            'fragrances' => $fragrances,
            'pickupOptions' => $pickupOptions,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (now()->format('H:i') > '17:00') {
            return back()
                ->withInput()
                ->withErrors([
                    'pickup_option_id' => 'Pesanan antar jemput hanya diterima sampai jam 17:00 WITA. Pesanan yang lewat dari jam 17:00 akan ditolak.',
                ]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'min:10', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],

            'google_maps' => ['nullable', 'string', 'max:1000'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'country' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'village' => ['nullable', 'string', 'max:100'],

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
                Rule::exists('pickup_options', 'id')->where('is_active', true),
            ],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.min' => 'Nomor telepon tidak valid, minimal 10 digit.',
            'address.required' => 'Detail alamat wajib diisi.',
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
                    'google_maps' => $validated['google_maps'] ?? null,
                    'latitude' => $validated['latitude'] ?? null,
                    'longitude' => $validated['longitude'] ?? null,
                    'country' => $validated['country'] ?? null,
                    'province' => $validated['province'] ?? null,
                    'city' => $validated['city'] ?? null,
                    'district' => $validated['district'] ?? null,
                    'village' => $validated['village'] ?? null,
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
                'notes' => $validated['notes'] ?? null,
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
                'updated_by' => 'system',
            ];

            if (Schema::hasColumn('status_logs', 'description')) {
                $statusLog['description'] = 'Pesanan baru dibuat oleh pelanggan dan menunggu verifikasi admin.';
            }

            StatusLog::create($statusLog);

            return $order;
        });

        return redirect()
            ->route('order.success', $order->order_code)
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    public function success(Order $order): View
    {
        $order->load(['customer', 'orderItems.service', 'pickupOption']);

        return view('order.success', [
            'order' => $order,
        ]);
    }
}