<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    // Tambahkan semua kolom baru di dalam array fillable ini
    protected $fillable = [
        'estate_id', 
        'periode', 
        'tipe', 
        'tonase', 
        'janjang', 
        'hk_panen', 
        'luas_cavel',
        'hs_ha',       // Tambahan baru
        'hs_pokok',    // Tambahan baru
        'kunjungan',   // Tambahan baru
        'ha_hk',       // Tambahan baru
        'kg_hk',       // Tambahan baru
        'ton_cpo',     // Menggantikan oer
        'ton_ker',     // Menggantikan ker
        'ton_pko',     // Menggantikan pko
        'ha_cavel_real'// Tambahan baru untuk input manual Ha Cavel
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
}