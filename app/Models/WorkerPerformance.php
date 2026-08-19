<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerPerformance extends Model
{
    use HasFactory;

    protected $guarded = []; 
    // Pastikan menggunakan $guarded = [] atau masukkan 'avr_bln' ke dalam $fillable
}