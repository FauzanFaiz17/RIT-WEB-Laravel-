<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bukti extends Model
{
    use HasFactory;

    protected $fillable = ['model_type', 'model_id', 'file_path'];

    // Relasi Polymorphic ke Parent
    public function model()
    {
        return $this->morphTo();
    }
}