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
                'nama_hunian'  => 'Rusunawa Putra',
                'lokasi'       => 'Kampus Indralaya, Ogan Ilir, Sumatera Selatan',
                'deskripsi'    => 'Rusunawa khusus mahasiswa laki-laki di kampus Indralaya.',
                'tipe'         => 'Rusunawa',
                'khusus_kipk'  => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama_hunian'  => 'Rusunawa Putri',
                'lokasi'       => 'Kampus Indralaya, Ogan Ilir, Sumatera Selatan',
                'deskripsi'    => 'Rusunawa khusus mahasiswa perempuan di kampus Indralaya.',
                'tipe'         => 'Rusunawa',
                'khusus_kipk'  => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama_hunian'  => 'Rusunawa Bukit',
                'lokasi'       => 'Bukit Besar, Palembang, Sumatera Selatan',
                'deskripsi'    => 'Rusunawa khusus mahasiswa UNSRI di kampus Bukit Besar.',
                'tipe'         => 'Rusunawa',
                'khusus_kipk'  => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama_hunian'  => 'Apartemen Putra',
                'lokasi'       => 'Kampus Indralaya, Ogan Ilir, Sumatera Selatan',
                'deskripsi'    => 'Apartemen khusus mahasiswa laki-laki di kampus Indralaya.',
                'tipe'         => 'Apartemen',
                'khusus_kipk'  => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama_hunian'  => 'Apartemen Putri',
                'lokasi'       => 'Kampus Indralaya, Ogan Ilir, Sumatera Selatan',
                'deskripsi'    => 'Apartemen khusus mahasiswa perempuan di kampus Indralaya.',
                'tipe'         => 'Apartemen',
                'khusus_kipk'  => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama_hunian'  => 'Asrama Muba',
                'lokasi'       => 'Kampus Indralaya, Ogan Ilir, Sumatera Selatan',
                'deskripsi'    => 'Asrama khusus mahasiswa Aktif UNSRI yang berasal dari Musi Banyuasin.',
                'tipe'         => 'Asrama',
                'khusus_kipk'  => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama_hunian'  => 'Asrama Bangka Belitung',
                'lokasi'       => 'Kampus Indralaya, Ogan Ilir, Sumatera Selatan',
                'deskripsi'    => 'Asrama khusus mahasiswa Aktif UNSRI yang berasal dari Bangka Belitung.',
                'tipe'         => 'Asrama',
                'khusus_kipk'  => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
