<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('productions', function (Blueprint $table) {
            // Hapus kolom lama (opsional, jika Anda mau menghapusnya)
            // $table->dropColumn(['oer', 'ker', 'pko']);
            
            // Tambahkan kolom baru
            $table->decimal('ton_cpo', 15, 2)->default(0)->after('kg_hk');
            $table->decimal('ton_ker', 15, 2)->default(0)->after('ton_cpo');
            $table->decimal('ton_pko', 15, 2)->default(0)->after('ton_ker');
        });
    }

    public function down()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn(['ton_cpo', 'ton_ker', 'ton_pko']);
        });
    }
};