<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hunian extends Model
{
    use HasFactory;

    protected $table = 'hunian';
    protected $primaryKey = 'id_hunian';

    protected $fillable = [
        'nama_hunian',
        'lokasi',
        'deskripsi',
        'tipe',
        'khusus_kipk',
    ];

    protected function casts(): array
    {
        return [
            'khusus_kipk' => 'boolean',
        ];
    }

    // Relationships
    public function kamar()
    {
        return $this->hasMany(Kamar::class, 'hunian_id', 'id_hunian');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'hunian_id', 'id_hunian');
    }

    public function pengelola()
    {
        return $this->hasMany(Pengelola::class, 'hunian_id', 'id_hunian');
    }
}