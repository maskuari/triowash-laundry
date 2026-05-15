<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'customer_name' => 'Budi Santoso',
                'customer_role' => 'Pelanggan Kos',
                'message' => 'Layanannya praktis, tinggal pesan dan cucian dijemput.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'customer_name' => 'Citra Dewi',
                'customer_role' => 'Pelanggan Harian',
                'message' => 'Suka karena bisa cek status pesanan tanpa harus login.',
                'rating' => 5,
                'is_active' => true,
            ],
            [
                'customer_name' => 'Rahmat Hidayat',
                'customer_role' => 'Pelanggan Walk-in',
                'message' => 'Pembayaran setelah ditimbang bikin tagihannya lebih transparan.',
                'rating' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['customer_name' => $testimonial['customer_name']],
                $testimonial
            );
        }
    }
}