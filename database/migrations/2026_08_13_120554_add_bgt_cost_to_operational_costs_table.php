<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operational_costs', function (Blueprint $table) {
            // Menambahkan 2 kolom baru setelah kolom cost_pks
            $table->decimal('bgt_cost_palm_produk', 15, 2)->default(0)->after('cost_pks');
            $table->decimal('bgt_cost_palm_oil', 15, 2)->default(0)->after('bgt_cost_palm_produk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operational_costs', function (Blueprint $table) {
            // Menghapus kolom jika di-rollback
            $table->dropColumn(['bgt_cost_palm_produk', 'bgt_cost_palm_oil']);
        });
    }
};