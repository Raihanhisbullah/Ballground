<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $table = 'lapangan';

    protected $fillable = [
        'nama_lapangan',
        'alamat',
        'foto',
        'latitude',
        'longitude',
        'area_coordinates',
        'area_size',
        'area_color',
        'status',
    ];

    public $timestamps = true;

    protected $casts = [
        'area_coordinates' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'area_size' => 'decimal:2'
    ];
}
