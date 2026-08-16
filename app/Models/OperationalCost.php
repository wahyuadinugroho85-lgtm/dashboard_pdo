<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'estate_id', 
        'periode', 
        'tipe', 
        'cost_panen', 
        'cost_rawat', 
        'cost_kantor', 
        'cost_teknik', 
        'cost_pks',
        'bgt_cost_palm_produk', // Tambahan Baru
        'bgt_cost_palm_oil',    // Tambahan Baru
        'pdo_bi',               // Tambahan baru untuk biaya PDO Bi
        'pdo_sbi'               // Tambahan baru untuk biaya PDO Sbi
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
}