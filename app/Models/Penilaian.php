<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    //
    protected $fillable = ['mahasiswa_id', 'kriteria_id', 'nilai'];
}
