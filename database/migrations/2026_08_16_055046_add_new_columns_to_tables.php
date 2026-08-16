<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Menambah kolom ha_cavel_real di tabel productions
        Schema::table('productions', function (Blueprint $table) {
            if (!Schema::hasColumn('productions', 'ha_cavel_real')) {
                $table->decimal('ha_cavel_real', 10, 2)->nullable();
            }
        });

        // Menambah kolom pdo_bi dan pdo_sbi di tabel operational_costs
        Schema::table('operational_costs', function (Blueprint $table) {
            if (!Schema::hasColumn('operational_costs', 'pdo_bi')) {
                $table->decimal('pdo_bi', 15, 2)->nullable();
            }
            if (!Schema::hasColumn('operational_costs', 'pdo_sbi')) {
                $table->decimal('pdo_sbi', 15, 2)->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn('ha_cavel_real');
        });

        Schema::table('operational_costs', function (Blueprint $table) {
            $table->dropColumn(['pdo_bi', 'pdo_sbi']);
        });
    }
};