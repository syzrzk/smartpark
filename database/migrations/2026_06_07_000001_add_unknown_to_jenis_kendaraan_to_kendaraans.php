<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE `kendaraans` MODIFY `jenis_kendaraan` ENUM('motor','mobil','unknown') NOT NULL DEFAULT 'unknown'");
    }

    public function down()
    {
        DB::statement("UPDATE `kendaraans` SET `jenis_kendaraan` = 'motor' WHERE `jenis_kendaraan` NOT IN ('motor','mobil')");
        DB::statement("ALTER TABLE `kendaraans` MODIFY `jenis_kendaraan` ENUM('motor','mobil') NOT NULL DEFAULT 'motor'");
    }
};
