<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswa_nim extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_mahasiswa_nim',
        'tempat_lahir',
        'tanggal_lahir',
        'noHp',
        'email',
    ];
}
