<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worker_performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estate_id')->constrained('estates')->onDelete('cascade');
            $table->date('periode');
            $table->string('tipe');
            $table->string('kategori'); // Masuk, Keluar, Umur, Status Keluarga, Masa Kerja
            $table->string('sub_kategori')->nullable(); // Bi, Sbi, <25, dll
            $table->integer('jumlah_tk')->default(0); // Tenaga Kerja
            $table->decimal('persentase', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_performances');
    }
};