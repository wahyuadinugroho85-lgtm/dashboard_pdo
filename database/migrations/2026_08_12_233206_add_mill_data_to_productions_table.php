<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->decimal('oer', 8, 2)->default(0)->after('kg_hk');
            $table->decimal('ker', 8, 2)->default(0)->after('oer');
            $table->decimal('pko', 8, 2)->default(0)->after('ker');
        });
    }

    public function down(): void
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn(['oer', 'ker', 'pko']);
        });
    }
};