<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin_sihum',
                'password' => 'password123',
                'role' => 'Admin',
                'is_active' => true,
            ],
            [
                'username' => 'pengelola_asrama',
                'password' => 'password123',
                'role' => 'Pengelola',
                'is_active' => true,
            ],
            [
                'username' => 'mahasiswa_unsri',
                'password' => 'password123',
                'role' => 'Mahasiswa',
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}