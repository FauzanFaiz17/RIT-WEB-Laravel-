<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat', 'tipe_surat', 
        'perihal', 'asal_tujuan', 'tanggal', 'ringkasan'
    ];

    public function buktis()
    {
        return $this->morphMany(Bukti::class, 'model');
    }


    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($surat) {
            $surat->buktis()->delete();
        });
    }
}