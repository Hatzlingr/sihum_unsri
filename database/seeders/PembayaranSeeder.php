<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    /**
     * Seed tabel pembayaran.
     * FK: pendaftaran_id  → pendaftaran.id_daftar (nullable)
     *     perpanjangan_id → perpanjangan.id_perpanjangan (nullable)
     * Jenis: Awal | Sewa Lanjutan
     * Status verifikasi: Belum Bayar | Menunggu | Sudah | Ditolak
     */
    public function run(): void
    {
        DB::table('pembayaran')->insert([
            // Pembayaran awal - mahasiswa 1 (sudah terverifikasi)
            [
                'pendaftaran_id'    => 1,
                'perpanjangan_id'   => null,
                'jenis_pembayaran'  => 'Awal',
                'jumlah_bayar'      => 300000.00,
                'bukti_transfer'    => 'bukti/pembayaran/1/transfer_april2026.jpg',
                'tgl_bayar'         => '2026-04-04 14:00:00',
                'status_verifikasi' => 'Sudah',
                'periode_mulai'     => '2026-04-05',
                'periode_selesai'   => '2026-10-05',
                'catatan_admin'     => 'Pembayaran telah diverifikasi.',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            // Pembayaran awal - mahasiswa 2 KIPK (gratis, langsung diverifikasi)
            [
                'pendaftaran_id'    => 2,
                'perpanjangan_id'   => null,
                'jenis_pembayaran'  => 'Awal',
                'jumlah_bayar'      => 0.00,
                'bukti_transfer'    => null,
                'tgl_bayar'         => '2026-04-06 08:00:00',
                'status_verifikasi' => 'Sudah',
                'periode_mulai'     => '2026-04-06',
                'periode_selesai'   => '2026-10-06',
                'catatan_admin'     => 'Penerima KIPK, bebas biaya sewa.',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            // Pembayaran perpanjangan - mahasiswa 1 (menunggu verifikasi)
            [
                'pendaftaran_id'    => null,
                'perpanjangan_id'   => 1,
                'jenis_pembayaran'  => 'Sewa Lanjutan',
                'jumlah_bayar'      => 1800000.00,
                'bukti_transfer'    => 'bukti/pembayaran/3/transfer_sept2026.jpg',
                'tgl_bayar'         => '2026-09-03 11:30:00',
                'status_verifikasi' => 'Menunggu',
                'periode_mulai'     => '2026-10-06',
                'periode_selesai'   => '2027-04-05',
                'catatan_admin'     => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],

            // Tagihan belum dibayar - mahasiswa 3 (Pending, belum bayar)
            [
                'pendaftaran_id'    => 3,
                'perpanjangan_id'   => null,
                'jenis_pembayaran'  => 'Awal',
                'jumlah_bayar'      => 300000.00,
                'bukti_transfer'    => null,
                'tgl_bayar'         => null,
                'status_verifikasi' => 'Belum Bayar',
                'periode_mulai'     => '2026-04-15',
                'periode_selesai'   => '2026-10-15',
                'catatan_admin'     => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
    }
}
