<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKeuangan extends Model
{
    use HasFactory;

    protected $table = 'kategori_keuangans';

    protected $fillable = ['nama_kategori', 'jenis_transaksi'];

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class);
    }
}