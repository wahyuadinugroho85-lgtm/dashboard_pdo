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
        Schema::table('worker_performances', function (Blueprint $table) {
            // Mengecek agar tidak error jika kolom sudah ada
            if (!Schema::hasColumn('worker_performances', 'avr_bln')) {
                $table->decimal('avr_bln', 10, 2)->nullable()->after('jumlah_tk');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('worker_performances', function (Blueprint $table) {
            if (Schema::hasColumn('worker_performances', 'avr_bln')) {
                $table->dropColumn('avr_bln');
            }
        });
    }
};