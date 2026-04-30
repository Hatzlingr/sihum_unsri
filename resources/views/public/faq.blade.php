<x-guest-layout>
    <x-slot:title>FAQ | SIHUM UNSRI</x-slot:title>

@php
    $categories = [
        [
            'icon' => 'bi-pencil-square',
            'title' => 'Pendaftaran',
            'description' => 'Informasi terkait akun, pengajuan hunian, dan proses seleksi.',
            'items' => [
                [
                    'question' => 'Bagaimana cara mendaftar hunian?',
                    'answer' => 'Mahasiswa membuat akun SIHUM, melengkapi biodata, memilih hunian, lalu mengunggah dokumen pendaftaran. Setelah itu, pengajuan akan diproses oleh admin SIHUM.',
                ],
                [
                    'question' => 'Apakah mahasiswa bisa mengajukan lebih dari satu pendaftaran?',
                    'answer' => 'Tidak. Mahasiswa hanya dapat memiliki satu pendaftaran aktif. Pengajuan baru hanya dapat dilakukan jika pengajuan sebelumnya ditolak atau dibatalkan.',
                ],
                [
                    'question' => 'Kapan status pendaftaran dapat dilihat?',
                    'answer' => 'Status pengajuan dapat dipantau melalui dashboard mahasiswa setelah pengajuan dikirim dan akan diperbarui sesuai proses seleksi oleh admin SIHUM.',
                ],
                [
                    'question' => 'Apa yang terjadi jika pengajuan disetujui?',
                    'answer' => 'Mahasiswa akan menerima tagihan pembayaran. Setelah pembayaran diverifikasi oleh admin SIHUM, mahasiswa akan mendapatkan penempatan kamar.',
                ],
            ],
        ],
        [
            'icon' => 'bi-buildings',
            'title' => 'Hunian',
            'description' => 'Informasi tentang jenis hunian, kamar, dan fasilitas.',
            'items' => [
                [
                    'question' => 'Apa saja jenis hunian yang tersedia?',
                    'answer' => 'SIHUM UNSRI menyediakan informasi hunian seperti rusunawa, asrama, dan apartemen sesuai data resmi Universitas Sriwijaya.',
                ],
                [
                    'question' => 'Apakah semua hunian berada di satu kampus?',
                    'answer' => 'Hunian tersedia di area kampus Indralaya dan Palembang, sesuai dengan lokasi yang dikelola oleh universitas.',
                ],
                [
                    'question' => 'Apakah kapasitas kamar ditampilkan?',
                    'answer' => 'Ya. Informasi kamar mencakup kapasitas, jumlah penghuni, harga sewa, lantai, serta status kamar seperti tersedia atau penuh.',
                ],
                [
                    'question' => 'Siapa yang menentukan kamar mahasiswa?',
                    'answer' => 'Penempatan kamar ditentukan oleh admin SIHUM setelah proses pendaftaran dan pembayaran selesai.',
                ],
            ],
        ],
        [
            'icon' => 'bi-credit-card',
            'title' => 'Pembayaran',
            'description' => 'Informasi terkait tagihan, bukti pembayaran, dan verifikasi.',
            'items' => [
                [
                    'question' => 'Kapan mahasiswa melakukan pembayaran?',
                    'answer' => 'Pembayaran dilakukan setelah pengajuan hunian disetujui dan tagihan tersedia di dashboard mahasiswa.',
                ],
                [
                    'question' => 'Bagaimana cara mengirim bukti pembayaran?',
                    'answer' => 'Mahasiswa mengunggah bukti transfer melalui halaman Pembayaran. Bukti tersebut akan diverifikasi oleh admin SIHUM.',
                ],
                [
                    'question' => 'Apa yang terjadi jika pembayaran ditolak?',
                    'answer' => 'Mahasiswa perlu mengunggah ulang bukti pembayaran sesuai catatan yang diberikan oleh admin SIHUM.',
                ],
                [
                    'question' => 'Apakah tunggakan memengaruhi layanan?',
                    'answer' => 'Ya. Mahasiswa tidak dapat mengajukan perpanjangan masa tinggal selama masih memiliki tunggakan pembayaran.',
                ],
            ],
        ],
        [
            'icon' => 'bi-arrow-repeat',
            'title' => 'Layanan Penghuni',
            'description' => 'Informasi terkait perpanjangan, pindah kamar, dan berhenti hunian.',
            'items' => [
                [
                    'question' => 'Kapan mahasiswa bisa mengajukan perpanjangan?',
                    'answer' => 'Perpanjangan dapat diajukan oleh mahasiswa yang sudah memiliki penempatan aktif dan tidak memiliki tunggakan pembayaran.',
                ],
                [
                    'question' => 'Apakah mahasiswa bisa mengajukan pindah kamar?',
                    'answer' => 'Bisa. Mahasiswa dapat mengajukan pindah kamar melalui dashboard. Proses ini akan ditinjau oleh admin dan dapat melibatkan pengelola hunian di lokasi.',
                ],
                [
                    'question' => 'Bagaimana cara berhenti dari hunian?',
                    'answer' => 'Mahasiswa dapat mengajukan berhenti melalui dashboard. Pengajuan akan diproses oleh admin SIHUM sesuai ketentuan yang berlaku.',
                ],
            ],
        ],
        [
            'icon' => 'bi-life-preserver',
            'title' => 'Bantuan',
            'description' => 'Informasi kontak dan dukungan layanan SIHUM.',
            'items' => [
                [
                    'question' => 'Ke mana harus menghubungi jika ada kendala?',
                    'answer' => 'Mahasiswa dapat menghubungi pengelola hunian di lokasi atau melihat informasi kontak resmi melalui halaman Kontak SIHUM.',
                ],
                [
                    'question' => 'Apakah halaman informasi bisa diakses tanpa login?',
                    'answer' => 'Bisa. Halaman Beranda, Hunian, Panduan, FAQ, dan Kontak dapat diakses sebagai informasi publik tanpa login.',
                ],
                [
                    'question' => 'Apakah SIHUM menggantikan seluruh layanan tatap muka?',
                    'answer' => 'SIHUM mendukung proses digital seperti pendaftaran, pembayaran, dan layanan hunian. Layanan langsung tetap mengikuti kebijakan universitas dan pengelola hunian.',
                ],
            ],
        ],
    ];
@endphp

    <x-page-hero
        badge="Tanya Jawab"
        badge-icon="bi-question-circle"
        title="Pertanyaan yang Sering Diajukan Seputar SIHUM UNSRI."
        description="Temukan jawaban singkat mengenai halaman publik, informasi hunian, alur pendaftaran, dan kanal bantuan."
    />

    <section class="bg-bg-surface px-5 py-16 md:py-20">
        <div class="mx-auto max-w-5xl space-y-6">
            @foreach ($categories as $category)
                <x-faq-category :icon="$category['icon']" :title="$category['title']" :description="$category['description']">
                    @foreach ($category['items'] as $item)
                        <x-faq-item :question="$item['question']" :answer="$item['answer']" />
                    @endforeach
                </x-faq-category>
            @endforeach
        </div>
    </section>

    <section class="px-5 py-16 md:py-20">
        <div class="mx-auto max-w-7xl">
            <x-cta-card
                overline="Butuh Bantuan?"
                title="Masih ada pertanyaan lain?"
                description="Kunjungi halaman kontak untuk melihat informasi layanan dan kanal komunikasi SIHUM UNSRI."
                :href="route('kontak')"
                button-text="Buka Kontak"
                icon="bi-envelope"
            />
        </div>
    </section>
</x-guest-layout>
