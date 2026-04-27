<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perpanjangan extends Model
{
    use HasFactory;

    protected $table = 'perpanjangan';
    protected $primaryKey = 'id_perpanjangan';

    protected $fillable = [
        'penempatan_id',
        'mahasiswa_id',
        'durasi_bulan',
        'tgl_ajuan',
        'tgl_keluar_baru',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'durasi_bulan' => 'integer',
            'tgl_ajuan' => 'datetime',
            'tgl_keluar_baru' => 'date',
        ];
    }

    // Relationships
    public function penempatan()
    {
        return $this->belongsTo(Penempatan::class, 'penempatan_id', 'id_penempatan');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id_mahasiswa');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'perpanjangan_id', 'id_perpanjangan');
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'Pending';
    }

    public function isDisetujui()
    {
        return $this->status === 'Disetujui';
    }

    public function isDitolak()
    {
        return $this->status === 'Ditolak';
    }

    public function getTotalBiaya()
    {
        $kamar = $this->penempatan->kamar;
        return $kamar->harga_sewa * $this->durasi_bulan;
    }
}