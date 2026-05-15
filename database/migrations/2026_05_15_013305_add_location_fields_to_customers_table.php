<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('google_maps');
            }

            if (!Schema::hasColumn('customers', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }

            if (!Schema::hasColumn('customers', 'country')) {
                $table->string('country')->nullable()->after('longitude');
            }

            if (!Schema::hasColumn('customers', 'province')) {
                $table->string('province')->nullable()->after('country');
            }

            if (!Schema::hasColumn('customers', 'city')) {
                $table->string('city')->nullable()->after('province');
            }

            if (!Schema::hasColumn('customers', 'district')) {
                $table->string('district')->nullable()->after('city');
            }

            if (!Schema::hasColumn('customers', 'village')) {
                $table->string('village')->nullable()->after('district');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $columns = [
                'latitude',
                'longitude',
                'country',
                'province',
                'city',
                'district',
                'village',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('customers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};