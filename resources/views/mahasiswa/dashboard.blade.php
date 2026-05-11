<x-mahasiswa-layout title="Dashboard Mahasiswa" page-title="Dashboard" active="dashboard">
    <div class="space-y-6">

        @if (session('error'))
            <div class="mb-6 rounded-2xl bg-red-50 p-4 border border-red-200 text-red-600 flex items-center gap-3">
                <i class="bi bi-exclamation-circle-fill"></i>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Welcome Banner --}}
        <section class="overflow-hidden rounded-3xl bg-brand p-6 sm:p-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-white/70">Selamat datang kembali,</p>
                    <h2 class="mt-1 text-2xl font-bold text-white sm:text-3xl">
                        {{ $mahasiswa->nama ?? 'Mahasiswa' }}
                    </h2>
                    <p class="mt-1 text-sm text-white/70">Pantau status hunian dan pembayaran kamu di sini.</p>
                </div>
                <span
                    class="hidden h-20 w-20 shrink-0 items-center justify-center rounded-full bg-white/10 text-white sm:flex">
                    <i class="bi bi-mortarboard text-4xl"></i>
                </span>
            </div>
        </section>

        {{-- Stat Cards --}}
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article
                class="rounded-3xl border border-border-soft bg-bg-base p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-brand/40 hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-content-sub">Status Hunian</p>
                        <p class="mt-3 text-2xl font-bold tracking-tight text-content-main">
                            {{ $penempatan?->status ?? 'Belum ada' }}
                        </p>
                    </div>
                    <span
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-buildings text-lg"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-content-sub">Kamar ditempati</span>
                </div>
            </article>

            <article
                class="rounded-3xl border border-border-soft bg-bg-base p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-brand/40 hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        {{-- Card Pembayaran --}}
                        <p class="text-sm font-medium text-content-sub">Status Pembayaran</p>
                        <p class="mt-3 text-2xl font-bold tracking-tight text-content-main">
                            {{ $pembayaranTerakhir?->status_verifikasi ?? 'Belum Ada' }}
                        </p>
                    </div>
                    <span
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-credit-card text-lg"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-content-sub">Pembayaran bulan ini</span>
                </div>
            </article>

            <article
                class="rounded-3xl border border-border-soft bg-bg-base p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-brand/40 hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-content-sub">Periode Sewa</p>
                        <p class="mt-3 text-2xl font-bold tracking-tight text-content-main">
                            {{ $sisaHari }} Hari
                        </p>
                    </div>
                    <span
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-calendar-check text-lg"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-content-sub">Periode sewa aktif</span>
                </div>
            </article>

            <article
                class="rounded-3xl border border-border-soft bg-bg-base p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-brand/40 hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-content-sub">Kamar yang Ditempati</p>
                        <p class="mt-3 text-2xl font-bold tracking-tight text-content-main">
                            {{ $penempatan?->kamar?->nomor_kamar ?? '-' }}
                        </p>
                    </div>
                    <span
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-door-open text-lg"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-content-sub">Kamar yang ditempati</span>
                </div>
            </article>
        </section>

        {{-- Container Utama --}}
        <div class="space-y-6">

            {{-- Baris Atas: Info Hunian & Aksi Cepat --}}
            <div class="grid gap-6 xl:grid-cols-2">

                {{-- Section 1: Info Hunian --}}
                <section
                    class="flex flex-col overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
                    <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                            <i class="bi bi-info-circle"></i>
                        </span>
                        <h2 class="text-base font-semibold text-content-main sm:text-lg">Detail Hunian</h2>
                    </div>

                    <div class="flex-1 p-5 sm:p-6 space-y-3">
                        {{-- Nama Gedung --}}
                        <div
                            class="flex items-center gap-3 rounded-2xl border border-border-soft bg-bg-surface px-4 py-3">
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-soft text-brand">
                                <i class="bi bi-buildings"></i>
                            </span>
                            <div class="flex flex-col min-w-0">
                                <span class="text-xs text-content-sub">Nama Hunian</span>
                                <span class="truncate text-sm font-semibold text-content-main">
                                    {{ $penempatan?->kamar?->hunian?->nama_hunian ?? 'Belum ada data' }}
                                </span>
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div
                            class="flex items-center gap-3 rounded-2xl border border-border-soft bg-bg-surface px-4 py-3">
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-soft text-brand">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <div class="flex flex-col min-w-0">
                                <span class="text-xs text-content-sub">Lokasi</span>
                                <span class="truncate text-sm font-semibold text-content-main">
                                    {{ $penempatan?->kamar?->hunian?->lokasi ?? '-' }}
                                </span>
                            </div>
                        </div>

                        {{-- Kamar --}}
                        <div
                            class="flex items-center gap-3 rounded-2xl border border-border-soft bg-bg-surface px-4 py-3">
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-soft text-brand">
                                <i class="bi bi-door-open"></i>
                            </span>
                            <div class="flex flex-col min-w-0">
                                <span class="text-xs text-content-sub">Detail Kamar</span>
                                <span class="truncate text-sm font-semibold text-content-main">
                                    Kamar {{ $penempatan?->kamar?->nomor_kamar ?? '-' }} | Lantai
                                    {{ $penempatan?->kamar?->lantai ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Section 2: Aksi Cepat --}}
                <section
                    class="flex flex-col overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
                    <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                            <i class="bi bi-lightning-charge"></i>
                        </span>
                        <h2 class="text-base font-semibold text-content-main sm:text-lg">Aksi Cepat</h2>
                    </div>

                    {{-- Tambahkan items-center & justify-center agar konten aksi cepat berada di tengah box jika ada
                    space sisa --}}
                    <div class="flex flex-1 items-center justify-center p-5 sm:p-6">
                        <div class="grid w-full grid-cols-1 gap-3 sm:grid-cols-2">
                            <a href="{{ route('mahasiswa.pengajuan') }}"
                                class="group flex items-center gap-3 rounded-2xl border border-border-soft bg-bg-base p-3 transition-all duration-200 hover:border-brand hover:bg-brand-light/50">
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="bi bi-file-earmark-plus"></i>
                                </span>
                                <div class="flex flex-col min-w-0">
                                    <span class="truncate text-sm font-semibold text-content-main">Ajukan Hunian</span>
                                    <span class="truncate text-xs text-slate-500">Daftar kamar baru</span>
                                </div>
                            </a>

                            <a href="{{ route('mahasiswa.pembayaran') }}"
                                class="group flex items-center gap-3 rounded-2xl border border-border-soft bg-bg-base p-3 transition-all duration-200 hover:border-brand hover:bg-brand-light/50">
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                    <i class="bi bi-credit-card"></i>
                                </span>
                                <div class="flex flex-col min-w-0">
                                    <span class="truncate text-sm font-semibold text-content-main">Bayar Sekarang</span>
                                    <span class="truncate text-xs text-slate-500">Tagihan & riwayat</span>
                                </div>
                            </a>

                            <a href="{{ route('mahasiswa.pindah-kamar') }}"
                                class="group flex items-center gap-3 rounded-2xl border border-border-soft bg-bg-base p-3 transition-all duration-200 hover:border-brand hover:bg-brand-light/50">
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                                    <i class="bi bi-arrow-left-right"></i>
                                </span>
                                <div class="flex flex-col min-w-0">
                                    <span class="truncate text-sm font-semibold text-content-main">Pindah Kamar</span>
                                    <span class="truncate text-xs text-slate-500">Pengajuan mutasi</span>
                                </div>
                            </a>

                            <a href="{{ route('mahasiswa.biodata') }}"
                                class="group flex items-center gap-3 rounded-2xl border border-border-soft bg-bg-base p-3 transition-all duration-200 hover:border-brand hover:bg-brand-light/50">
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                    <i class="bi bi-person-lines-fill"></i>
                                </span>
                                <div class="flex flex-col min-w-0">
                                    <span class="truncate text-sm font-semibold text-content-main">Lihat Biodata</span>
                                    <span class="truncate text-xs text-slate-500">Profil mahasiswa</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Section 3: Pengumuman (Full Width) --}}
            <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
                <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                    <span
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-megaphone"></i>
                    </span>
                    <h2 class="text-base font-semibold text-content-main sm:text-lg">Pengumuman</h2>
                </div>
                <div class="p-5 sm:p-6">
                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <span
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-bg-surface text-content-sub">
                            <i class="bi bi-megaphone text-3xl"></i>
                        </span>
                        <p class="mt-4 text-sm font-medium text-content-sub">Belum ada pengumuman saat ini.</p>
                    </div>
                </div>
            </section>

        </div>

    </div>
</x-mahasiswa-layout>