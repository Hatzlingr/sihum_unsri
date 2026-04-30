<x-guest-layout>
    <x-slot:title>Detail Hunian | SIHUM UNSRI</x-slot:title>

    @php
        $hunian = $hunian ?? [
            'name' => 'Rusunawa Mahasiswa Indralaya',
            'type' => 'Rusunawa',
            'location' => 'Kampus Indralaya',
            'price' => 'Mengikuti ketentuan',
            'capacity' => 'Kapasitas terbatas',
            'status' => 'Informasi Publik',
            'description' => 'Hunian mahasiswa yang disediakan untuk mendukung kebutuhan tempat tinggal mahasiswa Universitas Sriwijaya. Informasi detail dapat menyesuaikan data resmi dari pengelola hunian.',
        ];

        $specs = [
            ['icon' => 'bi-house-door', 'label' => 'Jenis', 'value' => $hunian['type']],
            ['icon' => 'bi-geo-alt', 'label' => 'Lokasi', 'value' => $hunian['location']],
            ['icon' => 'bi-people', 'label' => 'Kapasitas', 'value' => $hunian['capacity']],
            ['icon' => 'bi-wallet2', 'label' => 'Biaya', 'value' => $hunian['price']],
        ];

        $facilities = [
            ['icon' => 'bi-door-open', 'title' => 'Kamar Hunian', 'description' => 'Ruang tinggal mahasiswa sesuai ketentuan fasilitas.'],
            ['icon' => 'bi-droplet', 'title' => 'Air Bersih', 'description' => 'Fasilitas dasar untuk kebutuhan harian penghuni.'],
            ['icon' => 'bi-lightning-charge', 'title' => 'Listrik', 'description' => 'Dukungan listrik gratis.'],
            ['icon' => 'bi-shield-check', 'title' => 'Lingkungan Kampus', 'description' => 'Berada dalam area layanan Universitas Sriwijaya.'],
        ];
    @endphp

    <section class="bg-bg-base px-5 py-10">
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-wrap items-center gap-2 text-sm font-semibold text-content-sub">
                <a href="{{ route('home') }}" class="transition hover:text-brand">Beranda</a>
                <i class="bi bi-chevron-right text-xs"></i>
                <a href="{{ route('hunian.index') }}" class="transition hover:text-brand">Hunian</a>
                <i class="bi bi-chevron-right text-xs"></i>
                <span class="text-content-main">Detail</span>
            </div>
        </div>
    </section>

    <section class="px-5 pb-16 md:pb-20">
        <div class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="overflow-hidden rounded-[2.5rem] bg-bg-surface p-6 shadow-xl shadow-slate-200/70">
                <div class="flex min-h-88 items-center justify-center rounded-4xl bg-brand-soft text-brand">
                    <i class="bi bi-building text-8xl md:text-9xl"></i>
                </div>
            </div>

            <aside class="space-y-5">
                <div class="rounded-[2.5rem] bg-bg-base p-7 shadow-xl shadow-slate-200/70">
                    <span class="inline-flex rounded-full bg-brand-soft px-4 py-2 text-xs font-black uppercase tracking-[0.16em] text-brand">{{ $hunian['status'] }}</span>
                    <h1 class="mt-5 text-3xl font-black tracking-tight text-content-main md:text-4xl">{{ $hunian['name'] }}</h1>
                    <p class="mt-4 text-sm leading-7 text-content-sub">{{ $hunian['description'] }}</p>

                    <div class="mt-7 grid gap-3">
                        @foreach ($specs as $spec)
                            <x-detail-spec-card :icon="$spec['icon']" :label="$spec['label']" :value="$spec['value']" />
                        @endforeach
                    </div>

                    <a href="{{ route('daftar') }}" class="mt-7 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-brand px-6 py-4 text-sm font-black text-white shadow-lg shadow-brand/20 transition duration-300 hover:-translate-y-0.5 hover:bg-brand/90 hover:shadow-xl hover:shadow-brand/20">
                        Daftar untuk Mengajukan
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </aside>
        </div>
    </section>

    <section class="bg-bg-surface px-5 py-16 md:py-20">
        <div class="mx-auto max-w-7xl">
            <div class="max-w-2xl">
                <x-section-badge icon="bi-stars">Fasilitas</x-section-badge>
                <h2 class="mt-5 text-3xl font-black tracking-tight text-content-main md:text-4xl">Ringkasan fasilitas hunian.</h2>
                <p class="mt-4 text-sm leading-7 text-content-sub md:text-base">
                    Fasilitas dapat berbeda sesuai unit hunian dan kebijakan pengelola. Detail akhir mengikuti informasi resmi yang berlaku.
                </p>
            </div>

            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($facilities as $facility)
                    <x-facility-card :icon="$facility['icon']" :title="$facility['title']" :description="$facility['description']" />
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-5 py-16 md:py-20">
        <div class="mx-auto max-w-7xl">
            <x-cta-card
                overline="Informasi Lanjutan"
                title="Pahami alur sebelum mengajukan hunian."
                description="Baca panduan pendaftaran agar proses pengajuan lebih jelas dan terarah."
                :href="route('panduan')"
                button-text="Buka Panduan"
                icon="bi-journal-text"
            />
        </div>
    </section>
</x-guest-layout>
