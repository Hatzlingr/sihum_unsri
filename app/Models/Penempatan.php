<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penempatan extends Model
{
    use HasFactory;

    protected $table = 'penempatan';
    protected $primaryKey = 'id_penempatan';

    protected $fillable = [
        'pendaftaran_id',
        'kamar_id',
        'tgl_masuk',
        'tgl_keluar',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tgl_masuk' => 'date',
            'tgl_keluar' => 'date',
        ];
    }

    // Relationships
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id_daftar');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id', 'id_kamar');
    }

    public function perpanjangan()
    {
        return $this->hasMany(Perpanjangan::class, 'penempatan_id', 'id_penempatan');
    }

    // Helper methods
    public function isAktif()
    {
        return $this->status === 'Aktif';
    }

    public function getMahasiswa()
    {
        return $this->pendaftaran->mahasiswa;
    }

    public function getDurasiHari()
    {
        if (!$this->tgl_masuk || !$this->tgl_keluar) {
            return 0;
        }

        /** @var \Illuminate\Support\Carbon $masuk */
        $masuk = $this->tgl_masuk;

        return $masuk->diffInDays($this->tgl_keluar);
    }

    public function sisaHari()
    {
        if (!$this->isAktif()) {
            return 0;
        }

        $now = now();
        if ($now->gt($this->tgl_keluar)) {
            return 0;
        }

        return $now->diffInDays($this->tgl_keluar);
    }
}