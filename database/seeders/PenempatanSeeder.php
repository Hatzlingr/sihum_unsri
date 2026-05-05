<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenempatanSeeder extends Seeder
{
    /**
     * Seed tabel penempatan.
     * FK: pendaftaran_id → pendaftaran.id_daftar
     *     kamar_id       → kamar.id_kamar
     * Status: Aktif | Pindah | Selesai | Keluar
     *
     * Hanya pendaftaran yang sudah Disetujui yang mendapat penempatan.
     */
    public function run(): void
    {
        DB::table('penempatan')->insert([
            [
                'pendaftaran_id' => 1,
                'kamar_id'       => 2,  // A102 - Rusunawa Putra
                'tgl_masuk'      => '2026-04-05',
                'tgl_keluar'     => '2026-10-05',
                'status'         => 'Aktif',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'pendaftaran_id' => 2,
                'kamar_id'       => 42, // C102 - Rusunawa Bukit
                'tgl_masuk'      => '2026-04-06',
                'tgl_keluar'     => '2026-10-06',
                'status'         => 'Aktif',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
