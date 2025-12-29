<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisMutasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id','jenis_mutasi', 
        'jumlah', 'sisa_stok_saat_ini', 'tanggal', 'keterangan'
    ];

    public function barang()
    {
        return $this->belongsTo(InventarisBarang::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}