<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estate_id')->constrained('estates')->onDelete('cascade');
            $table->date('periode'); 
            $table->string('tipe'); // RKB, REAL, BUDGET, SENSUS
            $table->decimal('tonase', 15, 2)->default(0);
            $table->integer('janjang')->default(0);
            $table->decimal('hk_panen', 10, 2)->default(0);
            $table->decimal('luas_cavel', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};