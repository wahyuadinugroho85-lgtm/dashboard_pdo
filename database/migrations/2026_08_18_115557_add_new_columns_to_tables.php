<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menambahkan kolom hke ke tabel productions
        Schema::table('productions', function (Blueprint $table) {
            if (!Schema::hasColumn('productions', 'hke')) {
                $table->decimal('hke', 8, 2)->nullable()->after('ha_cavel_real');
            }
        });

        // Menambahkan kolom cost_ha ke tabel upkeeps
        Schema::table('upkeeps', function (Blueprint $table) {
            if (!Schema::hasColumn('upkeeps', 'cost_ha')) {
                $table->decimal('cost_ha', 15, 2)->nullable()->after('jml_blok');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn('hke');
        });

        Schema::table('upkeeps', function (Blueprint $table) {
            $table->dropColumn('cost_ha');
        });
    }
};