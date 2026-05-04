<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PindahKamarSeeder extends Seeder
{
    /**
     * Seed tabel pindah_kamar.
     * FK: mahasiswa_id     → mahasiswa.id_mahasiswa
     *     partner_tukar_id → mahasiswa.id_mahasiswa (nullable, untuk jenis Tukar)
     *     kamar_asal_id    → kamar.id_kamar
     *     kamar_tujuan_id  → kamar.id_kamar
     * Jenis: Reguler | Tukar
     * Status partner: Menunggu | Setuju | Ditolak (nullable, hanya untuk Tukar)
     * Status approval: Pending | Disetujui | Ditolak
     */
    public function run(): void
    {
        DB::table('pindah_kamar')->insert([
            // Pengajuan pindah reguler oleh mahasiswa 1
            [
                'mahasiswa_id'      => 1,
                'jenis_pindah'      => 'Reguler',
                'partner_tukar_id'  => null,
                'status_partner'    => null,
                'kamar_asal_id'     => 2,   // A102
                'kamar_tujuan_id'   => 1,   // A101
                'alasan'            => 'Ingin kamar yang lebih dekat dengan tangga untuk kemudahan akses.',
                'status_approval'   => 'Pending',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
    }
}
