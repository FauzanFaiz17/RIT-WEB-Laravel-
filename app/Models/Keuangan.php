<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangans';

    protected $fillable = [
        'kategori_keuangan_id', 'uraian', 
        'jenis', 'nominal', 'tanggal', 'keterangan'
    ];

    // Relasi ke Bukti (Polymorphic)
    public function buktis()
    {
        return $this->morphMany(Bukti::class, 'model');
    }


    public function kategori()
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_keuangan_id');
    }

    // Hapus bukti otomatis saat data keuangan dihapus
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($keuangan) {
            $keuangan->buktis()->delete();
        });
    }
}