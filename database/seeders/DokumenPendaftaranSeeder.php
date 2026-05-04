<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokumenPendaftaranSeeder extends Seeder
{
    /**
     * Seed tabel dokumen_pendaftaran.
     * FK: pendaftaran_id → pendaftaran.id_daftar
     * Tipe: KPM | KIPK | KK | Surat Pernyataan | Lainnya
     */
    public function run(): void
    {
        DB::table('dokumen_pendaftaran')->insert([
            // Dokumen pendaftaran ke-1 (mahasiswa 1 → Rusunawa)
            [
                'pendaftaran_id' => 1,
                'tipe_dokumen'   => 'KK',
                'path_file'      => 'dokumen/pendaftaran/1/kk_ahmad_fauzi.pdf',
                'uploaded_at'    => now(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'pendaftaran_id' => 1,
                'tipe_dokumen'   => 'Surat Pernyataan',
                'path_file'      => 'dokumen/pendaftaran/1/surat_pernyataan_ahmad.pdf',
                'uploaded_at'    => now(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            // Dokumen pendaftaran ke-2 (mahasiswa KIPK → Asrama KIPK)
            [
                'pendaftaran_id' => 2,
                'tipe_dokumen'   => 'KIPK',
                'path_file'      => 'dokumen/pendaftaran/2/kipk_budi_santoso.pdf',
                'uploaded_at'    => now(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'pendaftaran_id' => 2,
                'tipe_dokumen'   => 'KK',
                'path_file'      => 'dokumen/pendaftaran/2/kk_budi_santoso.pdf',
                'uploaded_at'    => now(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'pendaftaran_id' => 2,
                'tipe_dokumen'   => 'Surat Pernyataan',
                'path_file'      => 'dokumen/pendaftaran/2/surat_pernyataan_budi.pdf',
                'uploaded_at'    => now(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],

            // Dokumen pendaftaran ke-3 (masih Pending)
            [
                'pendaftaran_id' => 3,
                'tipe_dokumen'   => 'KK',
                'path_file'      => 'dokumen/pendaftaran/3/kk_citra_dewi.pdf',
                'uploaded_at'    => now(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
