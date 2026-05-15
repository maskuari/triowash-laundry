<?php

namespace Database\Seeders;

use App\Models\PickupOption;
use Illuminate\Database\Seeder;

class PickupOptionSeeder extends Seeder
{
    public function run(): void
    {
        $options = [
            [
                'name' => 'Dijemput & Diantar',
                'code' => 'dijemput_antar',
                'description' => 'Kurir mengambil pakaian dan mengantar kembali setelah selesai.',
            ],
            [
                'name' => 'Dijemput Saja',
                'code' => 'dijemput_saja',
                'description' => 'Kurir hanya mengambil pakaian dari pelanggan.',
            ],
            [
                'name' => 'Diantar Saja',
                'code' => 'diantar_saja',
                'description' => 'Pelanggan mengantar pakaian, kurir mengantar kembali.',
            ],
            [
                'name' => 'Antar & Ambil Sendiri',
                'code' => 'antar_ambil_sendiri',
                'description' => 'Pelanggan mengantar dan mengambil sendiri di toko.',
            ],
        ];

        foreach ($options as $option) {
            PickupOption::updateOrCreate(
                ['code' => $option['code']],
                $option + ['is_active' => true]
            );
        }
    }
}