<x-guest-layout>
    <x-slot:title>Panduan | SIHUM UNSRI</x-slot:title>

@php
    $steps = [
        [
            'number' => '01',
            'icon' => 'bi-person-badge',
            'title' => 'Masuk atau Buat Akun',
            'description' => 'Mahasiswa masuk menggunakan akun SIHUM atau membuat akun baru sebelum mengajukan pendaftaran hunian.',
        ],
        [
            'number' => '02',
            'icon' => 'bi-buildings',
            'title' => 'Pilih Hunian',
            'description' => 'Pilih jenis hunian yang tersedia seperti rusunawa, asrama, atau apartemen sesuai kebutuhan dan ketentuan.',
        ],
        [
            'number' => '03',
            'icon' => 'bi-file-earmark-arrow-up',
            'title' => 'Unggah Dokumen',
            'description' => 'Lengkapi dokumen pendaftaran seperti data diri, Kartu Keluarga, surat pernyataan, dan dokumen KIP-K jika diperlukan.',
        ],
        [
            'number' => '04',
            'icon' => 'bi-clipboard-check',
            'title' => 'Tunggu Seleksi Admin',
            'description' => 'Pengajuan akan diperiksa oleh sistem. Status pendaftaran dapat dipantau melalui dashboard mahasiswa.',
        ],
        [
            'number' => '05',
            'icon' => 'bi-credit-card',
            'title' => 'Lakukan Pembayaran',
            'description' => 'Jika pengajuan disetujui, mahasiswa melakukan pembayaran sesuai tagihan dan mengunggah bukti pembayaran.',
        ],
        [
            'number' => '06',
            'icon' => 'bi-door-open',
            'title' => 'Dapatkan Penempatan',
            'description' => 'Setelah pembayaran diverifikasi, mahasiswa akan mendapatkan penempatan kamar.',
        ],
    ];

    $requirements = [
        [
            'icon' => 'bi-person-vcard',
            'title' => 'Data Mahasiswa',
            'description' => 'NIM, nama lengkap, program studi, fakultas, angkatan, nomor HP, dan alamat aktif.',
        ],
        [
            'icon' => 'bi-file-earmark-text',
            'title' => 'Dokumen Pendaftaran',
            'description' => 'Kartu Keluarga, surat pernyataan, dan berkas pendukung sesuai ketentuan hunian.',
        ],
        [
            'icon' => 'bi-award',
            'title' => 'Dokumen KIP-K',
            'description' => 'Wajib dilampirkan jika mahasiswa mendaftar ke hunian khusus KIP-K atau memiliki status penerima KIP-K.',
        ],
        [
            'icon' => 'bi-credit-card-2-front',
            'title' => 'Bukti Pembayaran',
            'description' => 'Bukti transfer diunggah setelah pengajuan disetujui dan tagihan pembayaran tersedia.',
        ],
    ];
@endphp

    <x-page-hero
        badge="Panduan Pendaftaran"
        badge-icon="bi-journal-bookmark"
        title="Pahami Alur Pendaftaran Hunian Mahasiswa dengan Lebih Mudah."
        description="Halaman ini membantu pengunjung mengetahui tahapan umum sebelum masuk ke proses pendaftaran SIHUM UNSRI."
    >
        <div class="flex flex-col justify-center gap-4 sm:flex-row">
            <x-action-button :href="route('hunian.index')" icon="bi-arrow-right">Lihat Hunian</x-action-button>
            <x-action-button :href="route('faq')" variant="secondary" icon="bi-question-circle">Baca FAQ</x-action-button>
        </div>
    </x-page-hero>

    <section class="bg-bg-surface px-5 py-16 md:py-20">
        <div class="mx-auto max-w-7xl">
            <div class="max-w-2xl">
                <x-section-badge icon="bi-signpost-split">Tahapan Umum</x-section-badge>
                <h2 class="mt-5 text-3xl font-black tracking-tight text-content-main md:text-4xl">Enam langkah sederhana sebelum pengajuan selesai.</h2>
                <p class="mt-4 text-sm leading-7 text-content-sub md:text-base">
                    Panduan ini bersifat informatif untuk membantu mahasiswa memahami proses secara garis besar.
                </p>
            </div>

            <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                @foreach ($steps as $step)
                    <x-step-card :number="$step['number']" :icon="$step['icon']" :title="$step['title']" :description="$step['description']" />
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-5 py-16 md:py-20">
        <div class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
            <div class="rounded-[2.5rem] bg-brand p-8 text-white shadow-xl shadow-brand/20 md:p-10 my-auto">
                <p class="text-sm font-black uppercase tracking-[0.22em] text-brand-soft">Persiapan</p>
                <h2 class="mt-4 text-3xl font-black tracking-tight md:text-4xl">Dokumen dan data yang sebaiknya disiapkan.</h2>
                <p class="mt-5 text-sm leading-7 text-white/80 md:text-base">
                    Persyaratan akhir dapat mengikuti kebijakan pengelola. Gunakan daftar ini sebagai gambaran awal sebelum melakukan pendaftaran.
                </p>
            </div>

            <div class="grid gap-5 md:grid-cols-3 lg:grid-cols-1">
                @foreach ($requirements as $requirement)
                    <x-info-card :icon="$requirement['icon']" :title="$requirement['title']" :description="$requirement['description']" />
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-bg-surface px-5 py-16 md:py-20">
        <div class="mx-auto max-w-7xl">
            <x-cta-card
                overline="Mulai dari Informasi"
                title="Cek daftar hunian sebelum membuat pengajuan."
                description="Lihat pilihan hunian yang tersedia agar proses pendaftaran lebih terarah."
                :href="route('hunian.index')"
                button-text="Lihat Daftar Hunian"
            />
        </div>
    </section>
</x-guest-layout>
