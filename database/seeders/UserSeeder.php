<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Seed tabel users.
     * Role: Admin | Mahasiswa | Pengelola
     */
    public function run(): void
    {
        $users = [
            [
                'username'      => 'admin_sihum',
                'password'      => Hash::make('password123'),
                'role'          => 'Admin',
                'is_active'     => 1,
                'last_login_at' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,
            ],
            [
                'username'      => 'pengelola_asrama',
                'password'      => Hash::make('password123'),
                'role'          => 'Pengelola',
                'is_active'     => 1,
                'last_login_at' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,
            ],
            [
                'username'      => 'mahasiswa_unsri',
                'password'      => Hash::make('password123'),
                'role'          => 'Mahasiswa',
                'is_active'     => 1,
                'last_login_at' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,
            ],
            [
                'username'      => 'mhs_001',
                'password'      => Hash::make('mahasiswa123'),
                'role'          => 'Mahasiswa',
                'is_active'     => 1,
                'last_login_at' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,
            ],
            [
                'username'      => 'mhs_002',
                'password'      => Hash::make('mahasiswa123'),
                'role'          => 'Mahasiswa',
                'is_active'     => 1,
                'last_login_at' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,
            ],
            [
                'username'      => 'mhs_003',
                'password'      => Hash::make('mahasiswa123'),
                'role'          => 'Mahasiswa',
                'is_active'     => 1,
                'last_login_at' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,
            ],
        ];

        // Tambahkan 20 mahasiswa tambahan
        for ($i = 4; $i <= 23; $i++) {
            $users[] = [
                'username'      => 'mhs_' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password'      => Hash::make('mahasiswa123'),
                'role'          => 'Mahasiswa',
                'is_active'     => 1,
                'last_login_at' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,
            ];
        }

        DB::table('users')->insert($users);
    }
}
