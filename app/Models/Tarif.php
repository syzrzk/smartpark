<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $fillable = ['jenis_kendaraan', 'tarif_awal', 'jam_awal', 'harga_per_jam'];
}
