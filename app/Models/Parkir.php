<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parkir extends Model
{
    protected $fillable = [
        'kendaraan_id',
        'waktu_masuk',
        'waktu_keluar',
        'qr_code',
        'status',
        'biaya',
        'foto_masuk',
        'status_member'
    ];
    // app/Models/Parkir.php

public function kendaraan()
{
    return $this->belongsTo(Kendaraan::class);
}

public function tarif()
{
    return $this->hasOne(Tarif::class, 'jenis_kendaraan', 'jenis_kendaraan');
}

// jika ingin langsung ambil jenis kendaraan dari kendaraan:
public function jenisKendaraan()
{
    return $this->kendaraan->jenis_kendaraan ?? null;
}

}
