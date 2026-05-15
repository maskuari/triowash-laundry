<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'service_name' => 'Setrika + Lipat',
                'category' => 'paket',
                'price_per_kg' => 5000,
            ],
            [
                'service_name' => 'Lipat Saja',
                'category' => 'paket',
                'price_per_kg' => 3000,
            ],
            [
                'service_name' => 'Setrika Saja',
                'category' => 'paket',
                'price_per_kg' => 4000,
            ],
            [
                'service_name' => 'Wangi Bunga',
                'category' => 'wangi',
                'price_per_kg' => 1000,
            ],
            [
                'service_name' => 'Wangi Sport',
                'category' => 'wangi',
                'price_per_kg' => 1000,
            ],
            [
                'service_name' => 'Wangi Original',
                'category' => 'wangi',
                'price_per_kg' => 0,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                [
                    'service_name' => $service['service_name'],
                    'category' => $service['category'],
                ],
                [
                    'price_per_kg' => $service['price_per_kg'],
                ]
            );
        }
    }
}