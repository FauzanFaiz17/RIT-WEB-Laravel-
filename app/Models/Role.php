<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // relasi ke user (via pivot)
    public function unitUsers()
    {
        return $this->hasMany(UnitUser::class);
    }
}
