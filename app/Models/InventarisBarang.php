<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisBarang extends Model
{
    use HasFactory;

    protected $fillable = ['nama_barang', 'stok', 'terpakai', 'lokasi'];

    public function mutasis()
    {
        return $this->hasMany(InventarisMutasi::class, 'barang_id');
    }
    
    // Barang juga bisa punya bukti (misal foto barangnya)
    public function buktis()
    {
        return $this->morphMany(Bukti::class, 'model');
    }
}