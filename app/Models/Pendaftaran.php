<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_daftar';

    protected $fillable = [
        'mahasiswa_id',
        'hunian_id',
        'tgl_pengajuan',
        'status_seleksi',
        'catatan_admin',
    ];

    protected function casts(): array
    {
        return [
            'tgl_pengajuan' => 'datetime',
        ];
    }

    // Relationships
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id_mahasiswa');
    }

    public function hunian()
    {
        return $this->belongsTo(Hunian::class, 'hunian_id', 'id_hunian');
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenPendaftaran::class, 'pendaftaran_id', 'id_daftar');
    }

    public function penempatan()
    {
        return $this->hasOne(Penempatan::class, 'pendaftaran_id', 'id_daftar');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'pendaftaran_id', 'id_daftar');
    }

    // Helper methods
    public function isPending()
    {
        return $this->status_seleksi === 'Pending';
    }

    public function isDisetujui()
    {
        return $this->status_seleksi === 'Disetujui';
    }

    public function isDitolak()
    {
        return $this->status_seleksi === 'Ditolak';
    }
}