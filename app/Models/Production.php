<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'estate_id', 
        'periode', 
        'tipe', 
        'tonase', 
        'janjang', 
        'hk_panen', 
        'luas_cavel',
        'hs_ha',       
        'hs_pokok',    
        'kunjungan',   
        'ha_hk',       
        'kg_hk',       
        'ton_cpo',     
        'ton_ker',     
        'ton_pko',     
        'ha_cavel_real',
        'hke'          // TAMBAHAN BARU UNTUK HARI KERJA EFEKTIF
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
}
