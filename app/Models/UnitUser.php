<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UnitUser extends Pivot
{
    // Nama tabel di database
    protected $table = 'unit_user';
    
    // Aktifkan incrementing karena tabel pivot kita punya kolom 'id' utama
    public $incrementing = true; 

    // Relasi ke User (Agar bisa panggil $data->user->name)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Unit (Agar bisa panggil $data->unit->name)
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    // Relasi ke Role (Agar bisa panggil $data->role->name)
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}