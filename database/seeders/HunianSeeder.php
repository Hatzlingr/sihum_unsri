<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HunianSeeder extends Seeder
{
    /**
     * Seed tabel hunian.
     * Tipe: Rusunawa | Asrama | Apartemen
     */
    public function run(): void
    {
        DB::table('hunian')->insert([
            [
                'nama_hunian'  => 'Rusunawa Kampus Indralaya',
                'lokasi'       => 'Kampus Indralaya, Ogan Ilir, Sumatera Selatan',
                'deskripsi'    => 'Rumah susun sewa milik Universitas Sriwijaya di kampus Indralaya, tersedia untuk mahasiswa aktif.',
                'tipe'         => 'Rusunawa',
                'khusus_kipk'  => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama_hunian'  => 'Asrama Putra Bukit Besar',
                'lokasi'       => 'Kampus Bukit Besar, Palembang, Sumatera Selatan',
                'deskripsi'    => 'Asrama khusus mahasiswa putra di kampus Bukit Besar.',
                'tipe'         => 'Asrama',
                'khusus_kipk'  => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama_hunian'  => 'Asrama KIPK Indralaya',
                'lokasi'       => 'Kampus Indralaya, Ogan Ilir, Sumatera Selatan',
                'deskripsi'    => 'Asrama khusus mahasiswa penerima beasiswa KIP-Kuliah.',
                'tipe'         => 'Asrama',
                'khusus_kipk'  => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
