<footer class="mt-20 bg-bg-surface px-4 lg:px-8">
    <div class="mx-auto max-w-7xl px-5 py-14 md:py-16">
        <div class="grid gap-10 lg:grid-cols-[1.15fr_0.85fr_1fr]">
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-brand">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand text-white shadow-md shadow-brand/20">
                        <i class="bi bi-buildings text-xl"></i>
                    </span>
                    <span>
                        <span class="block text-lg font-black tracking-tight">SIHUM UNSRI</span>
                        <span class="block text-xs font-semibold text-content-sub">Sistem Informasi Hunian Mahasiswa</span>
                    </span>
                </a>

                <p class="mt-5 max-w-md text-sm leading-7 text-content-sub">
                    Platform resmi untuk membantu mahasiswa Universitas Sriwijaya memperoleh informasi hunian, memahami alur pendaftaran, dan mengakses layanan asrama serta rusunawa secara terpadu.
                </p>
            </div>

            <div>
                <h2 class="text-sm font-black uppercase tracking-[0.22em] text-content-main">Navigasi</h2>
                <div class="mt-5 grid gap-3 text-sm font-semibold text-content-sub">
                    <a href="{{ route('hunian.index') }}" class="inline-flex items-center gap-2 transition hover:text-brand">
                        <i class="bi bi-house-door text-brand"></i>
                        Hunian
                    </a>
                    <a href="{{ route('panduan') }}" class="inline-flex items-center gap-2 transition hover:text-brand">
                        <i class="bi bi-journal-text text-brand"></i>
                        Panduan
                    </a>
                    <a href="{{ route('faq') }}" class="inline-flex items-center gap-2 transition hover:text-brand">
                        <i class="bi bi-question-circle text-brand"></i>
                        FAQ
                    </a>
                    <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 transition hover:text-brand">
                        <i class="bi bi-envelope text-brand"></i>
                        Kontak
                    </a>
                </div>
            </div>

            <div>
                <h2 class="text-sm font-black uppercase tracking-[0.22em] text-content-main">Pengembang</h2>
                <p class="mt-5 text-sm leading-7 text-content-sub">
                    Dikembangkan oleh Amirul Nur Cahyo, M. Irfan Nopriansyah, Rama Alfira, dan Wahyu Pratama.
                </p>
                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="rounded-full bg-bg-base px-4 py-2 text-xs font-bold text-content-sub shadow-sm">Laravel 12</span>
                    <span class="rounded-full bg-bg-base px-4 py-2 text-xs font-bold text-content-sub shadow-sm">Tailwind CSS</span>
                    <span class="rounded-full bg-bg-base px-4 py-2 text-xs font-bold text-content-sub shadow-sm">Alpine.js</span>
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-4 rounded-4xl bg-bg-base px-6 py-5 text-sm text-content-sub shadow-sm md:flex-row md:items-center md:justify-between">
            <p>&copy; {{ date('Y') }} SIHUM UNSRI. Hak cipta dilindungi.</p>
            <p class="inline-flex items-center gap-2 font-semibold">
                <i class="bi bi-geo-alt-fill text-brand"></i>
                Universitas Sriwijaya, Sumatera Selatan
            </p>
        </div>
    </div>
</footer>
