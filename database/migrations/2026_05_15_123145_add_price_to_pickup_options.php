<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Pickup option price
        |--------------------------------------------------------------------------
        | Kolom price dipakai untuk harga opsi antar jemput.
        */
        Schema::table('pickup_options', function (Blueprint $table) {
            if (!Schema::hasColumn('pickup_options', 'price')) {
                $table->unsignedInteger('price')->default(0)->after('description');
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Service category fix
        |--------------------------------------------------------------------------
        | Error sebelumnya muncul karena category belum menerima "layanan".
        | Kita ubah jadi VARCHAR supaya bisa menampung:
        | - paket
        | - layanan
        | - wangi
        */
        DB::statement("ALTER TABLE services MODIFY category VARCHAR(50) NOT NULL");

        /*
        |--------------------------------------------------------------------------
        | Default layanan
        |--------------------------------------------------------------------------
        | Regular dan Express dimasukkan ke tabel services yang sudah ada,
        | dengan category = layanan.
        */
        if (!DB::table('services')->where('category', 'layanan')->where('service_name', 'Regular')->exists()) {
            DB::table('services')->insert([
                'service_name' => 'Regular',
                'category' => 'layanan',
                'price_per_kg' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (!DB::table('services')->where('category', 'layanan')->where('service_name', 'Express')->exists()) {
            DB::table('services')->insert([
                'service_name' => 'Express',
                'category' => 'layanan',
                'price_per_kg' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('services')
            ->where('category', 'layanan')
            ->whereIn('service_name', ['Regular', 'Express'])
            ->delete();

        Schema::table('pickup_options', function (Blueprint $table) {
            if (Schema::hasColumn('pickup_options', 'price')) {
                $table->dropColumn('price');
            }
        });

        /*
        | Catatan:
        | Bagian ini dikembalikan ke VARCHAR saja biar aman.
        | Jangan dipaksa balik ENUM karena struktur awal database kamu belum pasti.
        */
        DB::statement("ALTER TABLE services MODIFY category VARCHAR(50) NOT NULL");
    }
};