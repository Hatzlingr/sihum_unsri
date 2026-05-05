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
        $kamars = [];
        
        $hunians = [
            1 => ['prefix' => 'A', 'harga' => 150000.00, 'kapasitas' => 2], // Rusunawa Putra (KIPK 1)
            2 => ['prefix' => 'B', 'harga' => 150000.00, 'kapasitas' => 2], // Rusunawa Putri (KIPK 1)
            3 => ['prefix' => 'C', 'harga' => 300000.00, 'kapasitas' => 2], // Rusunawa Bukit (KIPK 0)
            4 => ['prefix' => 'D', 'harga' => 300000.00, 'kapasitas' => 2], // Apartemen Putra (KIPK 0)
            5 => ['prefix' => 'E', 'harga' => 300000.00, 'kapasitas' => 2], // Apartemen Putri (KIPK 0)
            6 => ['prefix' => 'F', 'harga' => 300000.00, 'kapasitas' => 4], // Asrama Muba (KIPK 0)
            7 => ['prefix' => 'G', 'harga' => 300000.00, 'kapasitas' => 4], // Asrama Bangka Belitung (KIPK 0)
        ];

        foreach ($hunians as $hunianId => $data) {
            for ($i = 1; $i <= 20; $i++) {
                $terisi = rand(0, $data['kapasitas']);
                $status = 'Tersedia';
                if ($terisi == $data['kapasitas']) {
                    $status = 'Penuh';
                }
                
                if (rand(1, 100) > 95) {
                    $status = 'Rusak';
                    $terisi = 0;
                }

                // Force specific terisi for Pendaftaran 1 (A102, hunian 1) and Pendaftaran 2 (C102, hunian 3)
                if ($hunianId == 1 && $i == 2) {
                    $terisi = 1;
                    $status = 'Tersedia';
                }
                if ($hunianId == 3 && $i == 2) {
                    $terisi = 1;
                    $status = 'Tersedia';
                }

                $kamars[] = [
                    'hunian_id'    => $hunianId,
                    'nomor_kamar'  => $data['prefix'] . '1' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'lantai'       => 1,
                    'kapasitas'    => $data['kapasitas'],
                    'terisi'       => $terisi,
                    'harga_sewa'   => $data['harga'],
                    'status'       => $status,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }
        }

        DB::table('kamar')->insert($kamars);
    }
}
