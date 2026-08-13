<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvest_qualities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estate_id')->constrained('estates')->onDelete('cascade');
            $table->date('periode');
            $table->string('tipe');
            $table->string('kriteria'); // Unripe, Ripe, Over Ripe, Empty Bunch, Abnormal, dll
            $table->decimal('persentase', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvest_qualities');
    }
};