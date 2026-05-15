<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\StoreStatus;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $services = Service::query()
            ->where('category', 'paket')
            ->orderBy('price_per_kg')
            ->get()
            ->unique('service_name')
            ->values();

        $testimonials = class_exists(Testimonial::class)
            ? Testimonial::query()
                ->where('is_active', true)
                ->latest()
                ->take(6)
                ->get()
            : collect();

        $storeStatus = class_exists(StoreStatus::class)
            ? StoreStatus::query()->first()
            : null;

        $orderStats = [
            'total_orders' => Order::query()->count(),
            'completed_orders' => Order::query()->where('status', 'selesai_diterima')->count(),
            'processing_orders' => Order::query()
                ->whereIn('status', [
                    'dijemput',
                    'diproses',
                    'menunggu_pembayaran',
                    'selesai',
                    'diantar',
                ])
                ->count(),
        ];

        return view('home.home', [
            'services' => $services,
            'testimonials' => $testimonials,
            'storeStatus' => $storeStatus,
            'orderStats' => $orderStats,
        ]);
    }
}