<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_bayar';

    protected $fillable = [
        'pendaftaran_id',
        'perpanjangan_id',
        'jenis_pembayaran',
        'jumlah_bayar',
        'bukti_transfer',
        'tgl_bayar',
        'status_verifikasi',
        'periode_mulai',
        'periode_selesai',
        'catatan_admin',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_bayar' => 'decimal:2',
            'tgl_bayar' => 'datetime',
            'periode_mulai' => 'date',
            'periode_selesai' => 'date',
        ];
    }

    // Relationships
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id_daftar');
    }

    public function perpanjangan()
    {
        return $this->belongsTo(Perpanjangan::class, 'perpanjangan_id', 'id_perpanjangan');
    }

    // Helper methods
    public function isBelumBayar()
    {
        return $this->status_verifikasi === 'Belum Bayar';
    }

    public function isMenunggu()
    {
        return $this->status_verifikasi === 'Menunggu';
    }

    public function isSudahVerifikasi()
    {
        return $this->status_verifikasi === 'Sudah';
    }

    public function isDitolak()
    {
        return $this->status_verifikasi === 'Ditolak';
    }

    public function isPembayaranAwal()
    {
        return $this->jenis_pembayaran === 'Awal';
    }

    public function isPembayaranLanjutan()
    {
        return $this->jenis_pembayaran === 'Sewa Lanjutan';
    }

    public function getBuktiUrl()
    {
        if (!$this->bukti_transfer) {
            return null;
        }
        return asset('storage/' . $this->bukti_transfer);
    }

    public function getDurasiPeriode()
    {
        if (!$this->periode_mulai || !$this->periode_selesai) {
            return 0;
        }

        /** @var \Illuminate\Support\Carbon $mulai */
        $mulai = $this->periode_mulai;

        return $mulai->diffInDays($this->periode_selesai);
    }
}