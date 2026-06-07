<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    /**
     * Boot the model and add event listeners
     */
    protected static function boot()
    {
        parent::boot();

        // Sync status in-memory every time a member is retrieved
        static::retrieved(function ($member) {
            $member->syncStatusInMemory();
        });
    }

    /**
     * Check if member is truly active (both is_active flag AND expired_at date not passed)
     */
    public function isActuallyActive(): bool
    {
        return $this->is_active && Carbon::parse($this->expired_at)->isAfter(now());
    }

    /**
     * Get the actual status (Aktif or Expired) based on both conditions
     */
    public function getActualStatusAttribute(): string
    {
        return $this->isActuallyActive() ? 'Aktif' : 'Expired';
    }

    /**
     * Sync is_active flag in memory only (no database save)
     */
    public function syncStatusInMemory(): void
    {
        $isExpired = Carbon::parse($this->expired_at)->isBefore(now());
        $this->attributes['is_active'] = !$isExpired;
    }

    /**
     * Sync is_active flag and save to database
     */
    public function syncStatus(): void
    {
        $this->syncStatusInMemory();
        $this->save();
    }
}