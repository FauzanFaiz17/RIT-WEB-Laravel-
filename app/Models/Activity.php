<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    /**
     * Properti yang dapat diisi secara massal.
     */
    protected $fillable = [
        'unit_id',
        'title',
        'type',
        'status',
        'start_date',
        'end_date',
        'location',
        'description',
        'color',
    ];

    /**
     * Relasi ke Unit
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}