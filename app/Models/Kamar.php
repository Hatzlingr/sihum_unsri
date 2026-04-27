<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';
    protected $primaryKey = 'id_kamar';

    protected $fillable = [
        'hunian_id',
        'nomor_kamar',
        'lantai',
        'kapasitas',
        'terisi',
        'harga_sewa',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'lantai' => 'integer',
            'kapasitas' => 'integer',
            'terisi' => 'integer',
            'harga_sewa' => 'decimal:2',
        ];
    }

    // Relationships
    public function hunian()
    {
        return $this->belongsTo(Hunian::class, 'hunian_id', 'id_hunian');
    }

    public function penempatan()
    {
        return $this->hasMany(Penempatan::class, 'kamar_id', 'id_kamar');
    }

    public function pindahKamarAsal()
    {
        return $this->hasMany(PindahKamar::class, 'kamar_asal_id', 'id_kamar');
    }

    public function pindahKamarTujuan()
    {
        return $this->hasMany(PindahKamar::class, 'kamar_tujuan_id', 'id_kamar');
    }

    // Helper methods
    public function isFull()
    {
        return $this->terisi >= $this->kapasitas;
    }

    public function isAvailable()
    {
        return $this->status === 'Tersedia' && !$this->isFull();
    }

    public function sisaKapasitas()
    {
        return $this->kapasitas - $this->terisi;
    }
}