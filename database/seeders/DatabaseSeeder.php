<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Urutan penting karena ada foreign key constraints.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,          // Tidak ada FK
            HunianSeeder::class,        // Tidak ada FK
            KamarSeeder::class,         // FK: hunian
            MahasiswaSeeder::class,     // FK: users
            PengelolaSeeder::class,     // FK: users, hunian
            PendaftaranSeeder::class,   // FK: mahasiswa, hunian
            DokumenPendaftaranSeeder::class, // FK: pendaftaran
            PenempatanSeeder::class,    // FK: pendaftaran, kamar
            PerpanjanganSeeder::class,  // FK: penempatan, mahasiswa
            PembayaranSeeder::class,    // FK: pendaftaran, perpanjangan
            PindahKamarSeeder::class,   // FK: mahasiswa, kamar
        ]);
    }
}
