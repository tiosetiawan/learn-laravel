<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable = [
        'inf_judul', 'inf_deskripsi', 'inf_gambar','inf_tanggal'
    ];
}
