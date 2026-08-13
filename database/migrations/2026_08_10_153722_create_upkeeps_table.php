<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upkeeps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estate_id')->constrained('estates')->onDelete('cascade');
            $table->date('periode');
            $table->string('tipe');
            $table->string('jenis_pekerjaan'); // Rwt Piringan, Pruning, PPT Chemist, dll
            $table->decimal('luas_ha', 10, 2)->default(0);
            $table->decimal('biaya_material', 15, 2)->default(0);
            $table->decimal('biaya_upah', 15, 2)->default(0);
            $table->integer('jml_blok')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upkeeps');
    }
};