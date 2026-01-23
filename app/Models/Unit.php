<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // 1. Relasi ke Parent (Mencari Induknya)
    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    // 2. Relasi ke Children (Mencari Anak/Divisinya)
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

public function activities()
{
    return $this->hasMany(Activity::class, 'unit_id');
}


public function indexGeneral()
{
    // Ambil unit pertama tempat user terdaftar
    $unitUser = UnitUser::where('user_id', Auth::id())->first();
    
    if (!$unitUser) {
        return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar di unit manapun.');
    }

    $unit_id = $unitUser->unit_id;
    
    // Panggil fungsi index yang sudah kita buat sebelumnya untuk mengambil data asli
    return $this->index($unit_id); 
}

}


