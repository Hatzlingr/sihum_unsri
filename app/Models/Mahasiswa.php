<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mahasiswa';

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'email',
        'prodi',
        'status_kipk',
        'no_hp',
        'foto_profil',
    ];

    protected function casts(): array
    {
        return [
            'status_kipk' => 'boolean',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'mahasiswa_id', 'id_mahasiswa');
    }

    public function penempatan()
    {
        return $this->hasOneThrough(
            Penempatan::class, 
            Pendaftaran::class, 
            'mahasiswa_id', // Foreign key on Pendaftaran table...
            'pendaftaran_id', // Foreign key on Penempatan table...
            'id_mahasiswa', // Local key on Mahasiswa table...
            'id_daftar' // Local key on Pendaftaran table...
        );
    }

    public function pindahKamar()
    {
        return $this->hasMany(PindahKamar::class, 'mahasiswa_id', 'id_mahasiswa');
    }

    public function pindahKamarPartner()
    {
        return $this->hasMany(PindahKamar::class, 'partner_tukar_id', 'id_mahasiswa');
    }

    public function perpanjangan()
    {
        return $this->hasMany(Perpanjangan::class, 'mahasiswa_id', 'id_mahasiswa');
    }

    // Helper methods
    public function isKIPK()
    {
        return $this->status_kipk;
    }

    public function getPendaftaranAktif()
    {
        return $this->pendaftaran()
            ->whereIn('status_seleksi', ['Pending', 'Disetujui'])
            ->latest()
            ->first();
    }
}