<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pendaftaran';
    protected $primaryKey = 'id_dokumen';

    protected $fillable = [
        'pendaftaran_id',
        'tipe_dokumen',
        'path_file',
        'uploaded_at',
    ];

    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
        ];
    }

    // Relationships
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id_daftar');
    }

    // Helper methods
    public function getFileUrl()
    {
        return asset('storage/' . $this->path_file);
    }
}