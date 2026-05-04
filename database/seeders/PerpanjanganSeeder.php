<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerpanjanganSeeder extends Seeder
{
    /**
     * Seed tabel perpanjangan.
     * FK: penempatan_id → penempatan.id_penempatan
     *     mahasiswa_id  → mahasiswa.id_mahasiswa
     * Status: Pending | Disetujui | Ditolak
     */
    public function run(): void
    {
        DB::table('perpanjangan')->insert([
            [
                'penempatan_id'  => 1,
                'mahasiswa_id'   => 1,
                'durasi_bulan'   => 6,
                'tgl_ajuan'      => '2026-09-01 10:00:00',
                'tgl_keluar_baru' => '2027-04-05',
                'status'         => 'Pending',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
