<x-mahasiswa-layout title="Dashboard Mahasiswa" page-title="Dashboard" active="dashboard">
    <div class="space-y-6">

        {{-- Welcome Banner --}}
        <section class="overflow-hidden rounded-3xl bg-brand p-6 sm:p-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-white/70">Selamat datang kembali,</p>
                    <h2 class="mt-1 text-2xl font-bold text-white sm:text-3xl">
                        {{ auth()->user()->name ?? 'Mahasiswa' }} 👋
                    </h2>
                    <p class="mt-1 text-sm text-white/70">Pantau status hunian dan pembayaran kamu di sini.</p>
                </div>
                <span class="hidden h-20 w-20 shrink-0 items-center justify-center rounded-full bg-white/10 text-white sm:flex">
                    <i class="bi bi-mortarboard text-4xl"></i>
                </span>
            </div>
        </section>

        {{-- Stat Cards --}}
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-3xl border border-border-soft bg-bg-base p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-brand/40 hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-content-sub">Status Hunian</p>
                        <p class="mt-3 text-2xl font-bold tracking-tight text-content-main">Aktif</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-buildings text-lg"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-content-sub">Kamar ditempati</span>
                </div>
            </article>

            <article class="rounded-3xl border border-border-soft bg-bg-base p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-brand/40 hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-content-sub">Status Pembayaran</p>
                        <p class="mt-3 text-2xl font-bold tracking-tight text-content-main">Menunggu</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-credit-card text-lg"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-content-sub">Pembayaran bulan ini</span>
                </div>
            </article>

            <article class="rounded-3xl border border-border-soft bg-bg-base p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-brand/40 hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-content-sub">Sisa Waktu Sewa</p>
                        <p class="mt-3 text-2xl font-bold tracking-tight text-content-main">-- hari</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-calendar-check text-lg"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-content-sub">Periode sewa aktif</span>
                </div>
            </article>

            <article class="rounded-3xl border border-border-soft bg-bg-base p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-brand/40 hover:shadow-md">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-content-sub">Nomor Kamar</p>
                        <p class="mt-3 text-2xl font-bold tracking-tight text-content-main">--</p>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-door-open text-lg"></i>
                    </span>
                </div>
                <div class="mt-4">
                    <span class="text-xs text-content-sub">Kamar yang ditempati</span>
                </div>
            </article>
        </section>

        {{-- Grid 2 Kolom: Info Hunian & Aksi Cepat --}}
        <section class="grid gap-6 xl:grid-cols-2">
            {{-- Info Hunian --}}
            <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
                <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-house-door"></i>
                    </span>
                    <h2 class="text-base font-semibold text-content-main sm:text-lg">Informasi Hunian</h2>
                </div>
                <div class="p-5 sm:p-6 space-y-4">
                    <div class="flex items-center justify-between rounded-2xl border border-border-soft bg-bg-surface px-4 py-3">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-soft text-brand">
                                <i class="bi bi-buildings"></i>
                            </span>
                            <span class="text-sm font-medium text-content-main">Nama Hunian</span>
                        </div>
                        <span class="text-sm font-semibold text-content-sub">-- </span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl border border-border-soft bg-bg-surface px-4 py-3">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-soft text-brand">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <span class="text-sm font-medium text-content-main">Lokasi</span>
                        </div>
                        <span class="text-sm font-semibold text-content-sub">--</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl border border-border-soft bg-bg-surface px-4 py-3">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-soft text-brand">
                                <i class="bi bi-door-open"></i>
                            </span>
                            <span class="text-sm font-medium text-content-main">Nomor Kamar</span>
                        </div>
                        <span class="text-sm font-semibold text-content-sub">--</span>
                    </div>
                </div>
            </section>

            {{-- Aksi Cepat --}}
            <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
                <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-lightning-charge"></i>
                    </span>
                    <h2 class="text-base font-semibold text-content-main sm:text-lg">Aksi Cepat</h2>
                </div>
                <div class="p-5 sm:p-6">
                    <div class="grid gap-3 sm:grid-cols-2">
                        <a href="{{ route('mahasiswa.pengajuan') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-border-soft bg-bg-base px-4 py-2.5 text-sm font-semibold text-content-main transition hover:border-brand hover:bg-brand-light hover:text-brand">
                            <i class="bi bi-file-earmark-plus"></i>
                            Ajukan Hunian
                        </a>
                        <a href="{{ route('mahasiswa.pembayaran') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-border-soft bg-bg-base px-4 py-2.5 text-sm font-semibold text-content-main transition hover:border-brand hover:bg-brand-light hover:text-brand">
                            <i class="bi bi-credit-card"></i>
                            Bayar Sekarang
                        </a>
                        <a href="{{ route('mahasiswa.pindah-kamar') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-border-soft bg-bg-base px-4 py-2.5 text-sm font-semibold text-content-main transition hover:border-brand hover:bg-brand-light hover:text-brand">
                            <i class="bi bi-arrow-left-right"></i>
                            Pindah Kamar
                        </a>
                        <a href="{{ route('mahasiswa.biodata') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-border-soft bg-bg-base px-4 py-2.5 text-sm font-semibold text-content-main transition hover:border-brand hover:bg-brand-light hover:text-brand">
                            <i class="bi bi-person-lines-fill"></i>
                            Lihat Biodata
                        </a>
                    </div>
                </div>
            </section>
        </section>

        {{-- Pengumuman --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-megaphone"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Pengumuman</h2>
            </div>
            <div class="p-5 sm:p-6">
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <span class="flex h-16 w-16 items-center justify-center rounded-full bg-bg-surface text-content-sub">
                        <i class="bi bi-megaphone text-3xl"></i>
                    </span>
                    <p class="mt-4 text-sm font-medium text-content-sub">Belum ada pengumuman saat ini.</p>
                </div>
            </div>
        </section>

    </div>
</x-mahasiswa-layout>