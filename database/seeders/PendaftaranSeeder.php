<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendaftaranSeeder extends Seeder
{
    /**
     * Seed tabel pendaftaran.
     * FK: mahasiswa_id → mahasiswa.id_mahasiswa
     *     hunian_id    → hunian.id_hunian
     * Status: Pending | Disetujui | Ditolak
     */
    public function run(): void
    {
        $pendaftarans = [
            [
                'mahasiswa_id'    => 1,
                'hunian_id'       => 1,
                'tgl_pengajuan'   => '2026-04-01 08:00:00',
                'status_seleksi'  => 'Disetujui',
                'catatan_admin'   => 'Berkas lengkap, mahasiswa memenuhi syarat.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'mahasiswa_id'    => 2,
                'hunian_id'       => 3,
                'tgl_pengajuan'   => '2026-04-02 09:30:00',
                'status_seleksi'  => 'Disetujui',
                'catatan_admin'   => 'Mahasiswa aktif, disetujui.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'mahasiswa_id'    => 3,
                'hunian_id'       => 1,
                'tgl_pengajuan'   => '2026-04-10 10:00:00',
                'status_seleksi'  => 'Pending',
                'catatan_admin'   => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ];

        // Tambahan data dummy calon penempatan (Status: Disetujui, tapi belum ditempatkan)
        for ($i = 4; $i <= 8; $i++) {
            $pendaftarans[] = [
                'mahasiswa_id'    => $i,
                'hunian_id'       => rand(1, 3), // Acak hunian 1-3
                'tgl_pengajuan'   => now()->subDays(rand(1, 10)),
                'status_seleksi'  => 'Disetujui',
                'catatan_admin'   => 'Disetujui secara otomatis untuk testing penempatan.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        DB::table('pendaftaran')->insert($pendaftarans);
    }
}
