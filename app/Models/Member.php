<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'nama',
        'plat_nomor',
        'jenis_kendaraan',
        'tipe',
        'expired_at',
        'is_active'
    ];
}