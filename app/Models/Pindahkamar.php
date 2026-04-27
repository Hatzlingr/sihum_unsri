<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PindahKamar extends Model
{
    use HasFactory;

    protected $table = 'pindah_kamar';
    protected $primaryKey = 'id_pindah';

    protected $fillable = [
        'mahasiswa_id',
        'jenis_pindah',
        'partner_tukar_id',
        'status_partner',
        'kamar_asal_id',
        'kamar_tujuan_id',
        'alasan',
        'status_approval',
    ];

    // Relationships
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id_mahasiswa');
    }

    public function partnerTukar()
    {
        return $this->belongsTo(Mahasiswa::class, 'partner_tukar_id', 'id_mahasiswa');
    }

    public function kamarAsal()
    {
        return $this->belongsTo(Kamar::class, 'kamar_asal_id', 'id_kamar');
    }

    public function kamarTujuan()
    {
        return $this->belongsTo(Kamar::class, 'kamar_tujuan_id', 'id_kamar');
    }

    // Helper methods
    public function isReguler()
    {
        return $this->jenis_pindah === 'Reguler';
    }

    public function isTukar()
    {
        return $this->jenis_pindah === 'Tukar';
    }

    public function isPending()
    {
        return $this->status_approval === 'Pending';
    }

    public function isDisetujui()
    {
        return $this->status_approval === 'Disetujui';
    }

    public function isDitolak()
    {
        return $this->status_approval === 'Ditolak';
    }

    public function isPartnerSetuju()
    {
        return $this->status_partner === 'Setuju';
    }

    public function isPartnerDitolak()
    {
        return $this->status_partner === 'Ditolak';
    }

    public function isPartnerMenunggu()
    {
        return $this->status_partner === 'Menunggu';
    }
}