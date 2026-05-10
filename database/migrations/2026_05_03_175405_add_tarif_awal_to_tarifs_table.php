<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tarifs', function (Blueprint $table) {
            $table->integer('tarif_awal')->default(0)->after('jenis_kendaraan');
            $table->integer('jam_awal')->default(1)->after('tarif_awal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tarifs', function (Blueprint $table) {
            $table->dropColumn(['tarif_awal', 'jam_awal']);
        });
    }
};
