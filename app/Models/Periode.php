<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nama_periode',
        'tanggal_mulai',
        'tanggal_akhir',
        'is_aktif',
    ];
}
