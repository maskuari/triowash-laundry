<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'service_name' => 'Setrika + Lipat',
            'category' => 'paket',
            'price_per_kg' => 5000
        ]);

        Service::create([
            'service_name' => 'Lipat Saja',
            'category' => 'paket',
            'price_per_kg' => 3000
        ]);

        Service::create([
            'service_name' => 'Setrika Saja',
            'category' => 'paket',
            'price_per_kg' => 4000
        ]);

        Service::create([
            'service_name' => 'Wangi Bunga',
            'category' => 'wangi',
            'price_per_kg' => 1000
        ]);

        Service::create([
            'service_name' => 'Wangi Sport',
            'category' => 'wangi',
            'price_per_kg' => 1000
        ]);

        Service::create([
            'service_name' => 'Wangi Original',
            'category' => 'wangi',
            'price_per_kg' => 0
        ]);
    }
}