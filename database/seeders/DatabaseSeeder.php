<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estate;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Daftar Divisi / PT yang ingin ditampilkan menyamping
        $estates = [
            ['kode' => 'H-1', 'nama' => 'Estate H-1'],
            ['kode' => 'H-2', 'nama' => 'Estate H-2'],
            ['kode' => 'T-1', 'nama' => 'Estate T-1'],
            ['kode' => 'T-2', 'nama' => 'Estate T-2'],
            ['kode' => 'T-3', 'nama' => 'Estate T-3'],
        ];

        // Memasukkan data ke dalam tabel estates
        foreach ($estates as $estate) {
            Estate::updateOrCreate(
                ['kode' => $estate['kode']], // Cari berdasarkan kode
                ['nama' => $estate['nama']]  // Update atau masukkan namanya
            );
        }
    }
}