<?php

namespace Database\Seeders;

use App\Models\StoreStatus;
use Illuminate\Database\Seeder;

class StoreStatusSeeder extends Seeder
{
    public function run(): void
    {
        StoreStatus::updateOrCreate(
            ['id' => 1],
            [
                'is_open' => true,
                'status_note' => 'Kami siap melayani antar jemput hari ini.',
            ]
        );
    }
}