<x-guest-layout>
    <x-slot:title>Kontak | SIHUM UNSRI</x-slot:title>

    @php
        $contacts = [
            [
                'icon' => 'bi-envelope-check',
                'title' => 'Email Resmi SIHUM',
                'description' => 'Gunakan email ini untuk kendala akun, pendaftaran, pembayaran, dan informasi sistem SIHUM.',
                'detail' => 'sihum@unsri.ac.id',
            ],
            [
                'icon' => 'bi-whatsapp',
                'title' => 'WhatsApp Layanan',
                'description' => 'Hubungi layanan SIHUM untuk pertanyaan cepat terkait proses pendaftaran dan informasi hunian.',
                'detail' => '08xxxxxxxxxx',
            ],
            [
                'icon' => 'bi-person-lines-fill',
                'title' => 'Pengelola Hunian',
                'description' => 'Untuk kendala kamar, fasilitas, dan operasional harian, mahasiswa dapat menghubungi pengelola hunian di lokasi.',
                'detail' => 'Tersedia di masing-masing hunian',
            ],
        ];
    @endphp

    <x-page-hero
        badge="Kontak"
        badge-icon="bi-envelope-paper"
        title="Kontak dan Layanan Bantuan SIHUM UNSRI."
        description="Temukan kanal bantuan resmi untuk kebutuhan pendaftaran, pembayaran, informasi hunian, dan operasional hunian mahasiswa."
    />

    <section class="bg-bg-surface px-5 py-16 md:py-20">
        <div class="mx-auto grid max-w-7xl gap-5 md:grid-cols-3">
            @foreach ($contacts as $contact)
                <x-contact-card
                    :icon="$contact['icon']"
                    :title="$contact['title']"
                    :description="$contact['description']"
                    :detail="$contact['detail']"
                />
            @endforeach
        </div>
    </section>

    <section class="px-5 py-16 md:py-20">
        <div class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[1fr_1fr] lg:items-stretch">
            <div class="rounded-[2.5rem] bg-bg-base p-8 shadow-xl shadow-slate-200/70 md:p-10">
                <x-section-badge icon="bi-info-circle">Informasi Layanan</x-section-badge>

                <h2 class="mt-5 text-3xl font-black tracking-tight text-content-main md:text-4xl">
                    Butuh bantuan seputar SIHUM?
                </h2>

                <p class="mt-5 text-sm leading-7 text-content-sub md:text-base">
                    Untuk kendala sistem seperti akun, pendaftaran, pembayaran, dan status pengajuan,
                    mahasiswa dapat menghubungi admin SIHUM melalui kontak resmi. Untuk kendala kamar,
                    fasilitas, atau operasional harian, mahasiswa dapat menghubungi pengelola hunian di lokasi.
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <a href="{{ route('faq') }}" class="block rounded-3xl bg-bg-surface p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
                        <i class="bi bi-question-circle text-2xl text-brand"></i>
                        <p class="mt-3 text-sm font-black text-content-main">FAQ</p>
                        <p class="mt-2 text-sm leading-6 text-content-sub">
                            Jawaban cepat untuk pertanyaan umum.
                        </p>
                    </a>

                    <a href="{{ route('panduan') }}" class="block rounded-3xl bg-bg-surface p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
                        <i class="bi bi-journal-text text-2xl text-brand"></i>
                        <p class="mt-3 text-sm font-black text-content-main">Panduan</p>
                        <p class="mt-2 text-sm leading-6 text-content-sub">
                            Tahapan pendaftaran secara ringkas.
                        </p>
                    </a>
                </div>

                <div class="mt-8 rounded-3xl bg-bg-surface p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                            <i class="bi bi-info-lg text-xl"></i>
                        </div>

                        <div>
                            <p class="text-sm font-black text-content-main">
                                Jalur Bantuan
                            </p>
                            <p class="mt-2 text-sm leading-6 text-content-sub">
                                Masalah sistem ditangani oleh admin SIHUM, sedangkan masalah operasional hunian
                                ditangani oleh pengelola hunian yang bertanggung jawab langsung di lokasi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-[2.5rem] bg-brand p-8 text-white shadow-xl shadow-brand/20 md:p-10">
                <div class="absolute -right-16 -top-16 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
                <div class="absolute -bottom-20 -left-16 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>

                <div class="relative z-10 flex h-full flex-col justify-between">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.22em] text-brand-soft">
                            Universitas Sriwijaya
                        </p>

                        <h2 class="mt-5 text-3xl font-black tracking-tight md:text-4xl">
                            Layanan hunian untuk Kampus Indralaya dan Palembang.
                        </h2>

                        <p class="mt-5 text-sm leading-7 text-white/80 md:text-base">
                            SIHUM UNSRI membantu mahasiswa mengakses informasi hunian, memantau pengajuan,
                            mengelola pembayaran, dan mendapatkan layanan hunian melalui satu platform resmi.
                        </p>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="rounded-4xl bg-white/10 p-6 shadow-sm backdrop-blur">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-brand shadow-sm">
                                    <i class="bi bi-geo-alt-fill text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black">Area Layanan</p>
                                    <p class="mt-1 text-sm text-white/75">
                                        Kampus Indralaya dan Palembang.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-4xl bg-white/10 p-6 shadow-sm backdrop-blur">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-brand shadow-sm">
                                    <i class="bi bi-clock-history text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black">Akses Informasi</p>
                                    <p class="mt-1 text-sm text-white/75">
                                        Informasi publik dapat diakses kapan saja melalui SIHUM.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-bg-surface px-5 py-16 md:py-20">
        <div class="mx-auto max-w-7xl">
            <x-cta-card
                overline="Pertanyaan Umum"
                title="Cek FAQ sebelum menghubungi layanan SIHUM."
                description="Banyak informasi dasar tentang pendaftaran, pembayaran, hunian, dan layanan mahasiswa sudah tersedia di halaman FAQ."
                :href="route('faq')"
                button-text="Buka FAQ"
                icon="bi-question-circle"
            />
        </div>
    </section>
</x-guest-layout>