<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengelolaSeeder extends Seeder
{
    /**
     * Seed tabel pengelola.
     * FK: user_id → users.id
     *     hunian_id → hunian.id_hunian (nullable)
     *
     * Asumsi:
     *   user_id 2 = pengelola_asrama (dari UserSeeder)
     *   hunian_id 1 = Rusunawa Kampus Indralaya
     */
    public function run(): void
    {
        DB::table('pengelola')->insert([
            [
                'user_id'    => 2,
                'nama'       => 'Hendra Wijaya',
                'email'      => 'hendra.wijaya@sihum.unsri.ac.id',
                'no_hp'      => '085678901234',
                'hunian_id'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
