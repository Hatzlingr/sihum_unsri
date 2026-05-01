<x-guest-layout>
    <x-slot:title>Beranda | SIHUM UNSRI</x-slot:title>

    @php
        $features = [
            ['icon' => 'bi-buildings', 'title' => 'Hunian Resmi', 'description' => 'Informasi asrama, rusunawa, dan apartemen dalam satu platform resmi Universitas Sriwijaya.'],
            ['icon' => 'bi-file-earmark-check', 'title' => 'Administrasi Terarah', 'description' => 'Alur pendaftaran dibuat jelas agar mahasiswa memahami tahapan dari awal sampai verifikasi.'],
            ['icon' => 'bi-geo-alt', 'title' => 'Dua Lokasi Kampus', 'description' => 'Cakupan informasi hunian untuk kebutuhan mahasiswa di kampus Indralaya dan Palembang.'],
        ];

        $steps = [
            ['number' => '01', 'icon' => 'bi-search', 'title' => 'Lihat Informasi Hunian', 'description' => 'Pelajari lokasi, jenis hunian, fasilitas, kapasitas, dan estimasi biaya sebelum mendaftar.'],
            ['number' => '02', 'icon' => 'bi-person-plus', 'title' => 'Buat Akun Mahasiswa', 'description' => 'Gunakan akun untuk mengisi data diri dan mengikuti proses pendaftaran hunian secara digital.'],
            ['number' => '03', 'icon' => 'bi-patch-check', 'title' => 'Ikuti Verifikasi', 'description' => 'Pantau status pengajuan setelah data dan dokumen pendaftaran diperiksa oleh pengelola.'],
        ];
    @endphp

    <section class="relative overflow-hidden bg-bg-base px-5 py-16 md:py-24">
        <div class="absolute left-1/2 top-0 -z-10 h-96 w-96 -translate-x-1/2 rounded-full bg-brand-soft/70 blur-3xl"></div>

        <div class="mx-auto grid max-w-7xl items-center gap-12 lg:grid-cols-[1.05fr_0.95fr]">
            <div>
                <x-section-badge icon="bi-stars">Platform Hunian Resmi UNSRI</x-section-badge>

                <h1 class="mt-6 max-w-4xl text-4xl font-black leading-tight tracking-tight text-content-main md:text-5xl lg:text-6xl">
                    Informasi Hunian Mahasiswa dalam Satu Sistem yang Rapi dan Terpadu.
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-8 text-content-sub md:text-lg">
                    SIHUM UNSRI membantu pengunjung mengenal layanan asrama dan rusunawa, memahami alur pendaftaran, serta menemukan informasi hunian mahasiswa UNSRI.
                </p>

                <div class="mt-9 flex flex-col gap-4 sm:flex-row">
                    <x-action-button :href="route('hunian.index')" icon="bi-arrow-right">Lihat Hunian</x-action-button>
                    <x-action-button :href="route('panduan')" variant="secondary" icon="bi-journal-text">Pelajari Panduan</x-action-button>
                </div>
            </div>

            <div class="relative">
                <div class="rounded-[2.5rem] bg-bg-surface p-4 shadow-xl shadow-slate-200/80">
                    <div class="rounded-4xl bg-bg-base p-6 shadow-sm md:p-8">
                        <div class="flex items-center justify-between gap-5">
                            <div>
                                <p class="text-sm font-black uppercase tracking-[0.18em] text-brand">Ringkasan Layanan</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-content-main">SIHUM Public Portal</h2>
                            </div>
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand text-white shadow-lg shadow-brand/20">
                                <i class="bi bi-house-check text-2xl"></i>
                            </div>
                        </div>

                        <div class="mt-8 space-y-4">
                            <div class="rounded-3xl bg-bg-surface p-5 shadow-sm">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-black text-content-main">Daftar Hunian</p>
                                        <p class="mt-1 text-sm text-content-sub">Asrama dan rusunawa resmi UNSRI.</p>
                                    </div>
                                    <span class="rounded-full bg-brand-soft px-3 py-1 text-xs font-black text-brand">Publik</span>
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-3xl bg-bg-surface p-5 shadow-sm">
                                    <p class="text-3xl font-black text-content-main">2</p>
                                    <p class="mt-1 text-sm text-content-sub">area kampus</p>
                                </div>
                                <div class="rounded-3xl bg-bg-surface p-5 shadow-sm">
                                    <p class="text-3xl font-black text-content-main">24/7</p>
                                    <p class="mt-1 text-sm text-content-sub">akses informasi</p>
                                </div>
                            </div>

                            <div class="rounded-3xl bg-brand p-5 text-white shadow-lg shadow-brand/20">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/15">
                                        <i class="bi bi-info-circle"></i>
                                    </div>
                                    <p class="text-sm font-semibold leading-6 text-white/90">
                                        Informasi publik dapat diakses sebelum mahasiswa login atau membuat akun.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-5 py-8">
        <div class="mx-auto grid max-w-7xl gap-5 md:grid-cols-3">
            @foreach ($features as $feature)
                <x-feature-card :icon="$feature['icon']" :title="$feature['title']" :description="$feature['description']" />
            @endforeach
        </div>
    </section>

    <section class="bg-bg-surface px-5 py-16 md:py-20">
        <div class="mx-auto max-w-7xl">
            <div class="mx-auto max-w-2xl text-center">
                <x-section-badge icon="bi-signpost">Alur Singkat</x-section-badge>
                <h2 class="mt-5 text-3xl font-black tracking-tight text-content-main md:text-4xl">Dari mencari informasi sampai siap mendaftar.</h2>
                <p class="mt-4 text-sm leading-7 text-content-sub md:text-base">
                    Halaman publik dirancang untuk memberi gambaran yang jelas sebelum mahasiswa masuk ke proses pendaftaran.
                </p>
            </div>

            <div class="mt-12 grid gap-5 md:grid-cols-3">
                @foreach ($steps as $step)
                    <x-step-card :number="$step['number']" :icon="$step['icon']" :title="$step['title']" :description="$step['description']" />
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-5 py-16 md:py-20">
        <div class="mx-auto max-w-7xl">
            <x-cta-card
                overline="Pendaftaran Mahasiswa"
                title="Siap mengajukan hunian semester ini?"
                description="Buat akun mahasiswa untuk melengkapi data pendaftaran dan mengikuti proses verifikasi hunian UNSRI."
                :href="route('register')"
                button-text="Daftar Sekarang"
            />
        </div>
    </section>
</x-guest-layout>
