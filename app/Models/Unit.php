<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // 1. Relasi ke Parent (Mencari Induknya)
    // Contoh: $webDev->parent akan mengembalikan object 'Komunitas IT'
    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    // 2. Relasi ke Children (Mencari Anak/Divisinya)
    // Contoh: $komunitasIT->children akan mengembalikan collection ['WebDev', 'Data Science']
    public function children()
    {
        return $this->hasMany(Unit::class, 'parent_id');
    }

    // 3. Relasi ke Users 
public function users()
{
    return $this->belongsToMany(User::class, 'unit_user', 'unit_id', 'user_id')
                ->using(UnitUser::class) // <--- Tambahkan baris ini
                ->withPivot('role_id')
                ->withTimestamps();
}
}