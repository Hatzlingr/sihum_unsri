<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KamarSeeder extends Seeder
{
    /**
     * Seed tabel kamar.
     * FK: hunian_id → hunian.id_hunian
     * Status: Tersedia | Penuh | Rusak
     */
    public function run(): void
    {
        $kamars = [
            // --- Rusunawa Kampus Indralaya ---
            [
                'hunian_id'    => 1,
                'nomor_kamar'  => 'A101',
                'lantai'       => 1,
                'kapasitas'    => 2,
                'terisi'       => 0,
                'harga_sewa'   => 300000.00,
                'status'       => 'Tersedia',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'hunian_id'    => 1,
                'nomor_kamar'  => 'A102',
                'lantai'       => 1,
                'kapasitas'    => 2,
                'terisi'       => 1,
                'harga_sewa'   => 300000.00,
                'status'       => 'Tersedia',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'hunian_id'    => 1,
                'nomor_kamar'  => 'B201',
                'lantai'       => 2,
                'kapasitas'    => 2,
                'terisi'       => 2,
                'harga_sewa'   => 350000.00,
                'status'       => 'Penuh',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'hunian_id'    => 1,
                'nomor_kamar'  => 'B202',
                'lantai'       => 2,
                'kapasitas'    => 2,
                'terisi'       => 0,
                'harga_sewa'   => 350000.00,
                'status'       => 'Rusak',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            // --- Asrama Putra Bukit Besar ---
            [
                'hunian_id'    => 2,
                'nomor_kamar'  => '101',
                'lantai'       => 1,
                'kapasitas'    => 4,
                'terisi'       => 2,
                'harga_sewa'   => 200000.00,
                'status'       => 'Tersedia',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'hunian_id'    => 2,
                'nomor_kamar'  => '102',
                'lantai'       => 1,
                'kapasitas'    => 4,
                'terisi'       => 4,
                'harga_sewa'   => 200000.00,
                'status'       => 'Penuh',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],

            // --- Asrama KIPK Indralaya ---
            [
                'hunian_id'    => 3,
                'nomor_kamar'  => 'K101',
                'lantai'       => 1,
                'kapasitas'    => 2,
                'terisi'       => 1,
                'harga_sewa'   => 0.00,
                'status'       => 'Tersedia',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'hunian_id'    => 3,
                'nomor_kamar'  => 'K102',
                'lantai'       => 1,
                'kapasitas'    => 2,
                'terisi'       => 0,
                'harga_sewa'   => 0.00,
                'status'       => 'Tersedia',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ];

        // Tambah kamar Hunian 1
        for ($i = 3; $i <= 20; $i++) {
            $kamars[] = [
                'hunian_id'    => 1,
                'nomor_kamar'  => 'A1' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'lantai'       => 1,
                'kapasitas'    => 2,
                'terisi'       => rand(0, 1),
                'harga_sewa'   => 300000.00,
                'status'       => 'Tersedia',
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        // Tambah kamar Hunian 2
        for ($i = 3; $i <= 20; $i++) {
            $kamars[] = [
                'hunian_id'    => 2,
                'nomor_kamar'  => '1' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'lantai'       => 1,
                'kapasitas'    => 4,
                'terisi'       => rand(0, 2),
                'harga_sewa'   => 200000.00,
                'status'       => 'Tersedia',
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        // Tambah kamar Hunian 3
        for ($i = 3; $i <= 20; $i++) {
            $kamars[] = [
                'hunian_id'    => 3,
                'nomor_kamar'  => 'K1' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'lantai'       => 1,
                'kapasitas'    => 2,
                'terisi'       => rand(0, 1),
                'harga_sewa'   => 0.00,
                'status'       => 'Tersedia',
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        DB::table('kamar')->insert($kamars);
    }
}
