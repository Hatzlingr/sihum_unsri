<x-guest-layout>
    <x-slot:title>Hunian | SIHUM UNSRI</x-slot:title>

    @php
        $hunians = [
            [
                'name' => 'Rusunawa Mahasiswa Indralaya',
                'type' => 'Rusunawa',
                'location' => 'Kampus Indralaya',
                'capacity' => 'Kapasitas terbatas',
                'price' => 'Informasi biaya mengikuti ketentuan',
                'status' => 'Informasi Publik',
                'icon' => 'bi-building',
                'slug' => 'rusunawa-mahasiswa-indralaya',
            ],
            [
                'name' => 'Asrama Mahasiswa Indralaya',
                'type' => 'Asrama',
                'location' => 'Kampus Indralaya',
                'capacity' => 'Untuk mahasiswa aktif',
                'price' => 'Informasi biaya mengikuti ketentuan',
                'status' => 'Informasi Publik',
                'icon' => 'bi-house-door',
                'slug' => 'asrama-mahasiswa-indralaya',
            ],
            [
                'name' => 'Apartemen Mahasiswa Indralaya',
                'type' => 'Hunian Kampus',
                'location' => 'Kampus Indralaya',
                'capacity' => 'Menyesuaikan ketersediaan',
                'price' => 'Informasi biaya mengikuti ketentuan',
                'status' => 'Informasi Publik',
                'icon' => 'bi-buildings',
                'slug' => 'apartemen-mahasiswa-indralaya',
            ],
            [
                'name' => 'Hunian Mahasiswa Palembang (Comming Soon)',
                'type' => 'Hunian Kampus',
                'location' => 'Kampus Palembang',
                'capacity' => 'Menyesuaikan ketersediaan',
                'price' => 'Informasi biaya mengikuti ketentuan',
                'status' => 'Informasi Publik',
                'icon' => 'bi-buildings',
                'slug' => 'hunian-mahasiswa-palembang',
            ],
        ];
    @endphp

    <x-page-hero
        badge="Daftar Hunian"
        badge-icon="bi-house-door"
        title="Temukan Informasi Asrama, Rusunawa, Apartemen Mahasiswa UNSRI."
        description="Halaman ini menyajikan ringkasan hunian publik agar mahasiswa dapat memahami pilihan tempat tinggal sebelum login atau mendaftar."
    >
        <div class="flex flex-col justify-center gap-4 sm:flex-row">
            <x-action-button :href="route('panduan')" icon="bi-journal-text">Lihat Panduan</x-action-button>
            <x-action-button :href="route('kontak')" variant="secondary" icon="bi-envelope">Kontak Pengelola</x-action-button>
        </div>
    </x-page-hero>

    <section class="bg-bg-surface px-5 py-16 md:py-20">
        <div class="mx-auto max-w-7xl">
            <div class="mb-10 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div class="max-w-2xl">
                    <x-section-badge icon="bi-grid">Pilihan Hunian</x-section-badge>
                    <h2 class="mt-5 text-3xl font-black tracking-tight text-content-main md:text-4xl">Informasi hunian mahasiswa.</h2>
                    <p class="mt-4 text-sm leading-7 text-content-sub md:text-base">
                        Daftar berikut bersifat informatif dan dapat disesuaikan dengan data resmi pengelola hunian.
                    </p>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($hunians as $hunian)
                    <x-housing-card
                        :name="$hunian['name']"
                        :type="$hunian['type']"
                        :location="$hunian['location']"
                        :capacity="$hunian['capacity']"
                        :price="$hunian['price']"
                        :status="$hunian['status']"
                        :icon="$hunian['icon']"
                        :href="route('hunian.show', $hunian['slug'])"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-5 py-16 md:py-20">
        <div class="mx-auto max-w-7xl">
            <x-cta-card
                overline="Belum Yakin?"
                title="Pelajari panduan sebelum memilih hunian."
                description="Baca alur pendaftaran agar lebih siap saat membuat akun dan mengajukan hunian."
                :href="route('panduan')"
                button-text="Buka Panduan"
                icon="bi-journal-text"
            />
        </div>
    </section>
</x-guest-layout>
