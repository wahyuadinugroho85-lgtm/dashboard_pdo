<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->decimal('hs_ha', 15, 2)->default(0)->after('luas_cavel');
            $table->integer('hs_pokok')->default(0)->after('hs_ha');
            $table->decimal('kunjungan', 10, 2)->default(0)->after('hs_pokok');
            $table->decimal('ha_hk', 10, 2)->default(0)->after('kunjungan');
            $table->decimal('kg_hk', 10, 2)->default(0)->after('ha_hk');
        });
    }

    public function down(): void
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn(['hs_ha', 'hs_pokok', 'kunjungan', 'ha_hk', 'kg_hk']);
        });
    }
};