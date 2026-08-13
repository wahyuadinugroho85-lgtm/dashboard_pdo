<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operational_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estate_id')->constrained('estates')->onDelete('cascade');
            $table->date('periode');
            $table->string('tipe');
            $table->decimal('cost_panen', 15, 2)->default(0);
            $table->decimal('cost_rawat', 15, 2)->default(0);
            $table->decimal('cost_kantor', 15, 2)->default(0);
            $table->decimal('cost_teknik', 15, 2)->default(0);
            $table->decimal('cost_pks', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operational_costs');
    }
};