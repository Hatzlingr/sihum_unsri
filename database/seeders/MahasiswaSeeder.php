<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MahasiswaSeeder extends Seeder
{
    /**
     * Seed tabel mahasiswa.
     * FK: user_id → users.id
     *
     * Asumsi user_id mahasiswa dari UserSeeder:
     *   3 = mhs_001
     *   4 = mhs_002  (catatan: id 2 = pengelola, sesuaikan jika urutan berbeda)
     *   5 = mhs_003
     */
    public function run(): void
    {
        $mahasiswa = [
            [
                'user_id'      => 3,
                'nim'          => '001',
                'nama'         => 'Ahmad Fauzi',
                'email'        => 'ahmad.fauzi@student.unsri.ac.id',
                'prodi'        => 'Teknik Informatika',
                'status_kipk'  => 0,
                'no_hp'        => '081234567890',
                'foto_profil'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'user_id'      => 4,
                'nim'          => '002',
                'nama'         => 'Budi Santoso',
                'email'        => 'budi.santoso@student.unsri.ac.id',
                'prodi'        => 'Sistem Informasi',
                'status_kipk'  => 1,
                'no_hp'        => '082345678901',
                'foto_profil'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'user_id'      => 5,
                'nim'          => '003',
                'nama'         => 'Citra Dewi',
                'email'        => 'citra.dewi@student.unsri.ac.id',
                'prodi'        => 'Ilmu Komputer',
                'status_kipk'  => 1,
                'no_hp'        => '083456789012',
                'foto_profil'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ];

        $faker = Faker::create('id_ID');

        // ID user sebelumnya sudah sampai 5 (1 Admin, 1 Pengelola, 3 Mhs)
        // User mahasiswa baru ID 6 s.d 25
        for ($i = 4; $i <= 23; $i++) {
            $mahasiswa[] = [
                'user_id'      => $i + 2, // ID 6, 7, ... 25
                'nim'          => str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama'         => $faker->name(),
                'email'        => 'mhs' . $i . '@student.unsri.ac.id',
                'prodi'        => $faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Ilmu Komputer', 'Teknik Komputer', 'Sistem Komputer']),
                'status_kipk'  => $faker->boolean(20) ? 1 : 0, // 20% chance
                'no_hp'        => '08' . $faker->numerify('##########'),
                'foto_profil'  => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }
        foreach ($mahasiswa as $mhs) {
            // Update username di tabel users menjadi NIM
            DB::table('users')
                ->where('id', $mhs['user_id'])
                ->update(['username' => $mhs['nim']]);
        }

        DB::table('mahasiswa')->insert($mahasiswa);
    }
}
