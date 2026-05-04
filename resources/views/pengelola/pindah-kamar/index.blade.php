@php
    $pindahSource = $pindahKamars ?? $pindahKamar ?? collect([
        ['nama' => 'Wahyu Baca Buku', 'nim' => '09021282429069', 'prodi' => 'Teknik Informatika', 'tanggal_pengajuan' => '12 April 2026', 'status' => 'Pending', 'kamar_awal' => '308', 'kamar_tujuan' => '201', 'no_telepon' => '0812487382856', 'status_kipk' => 'Tidak Terverifikasi', 'alasan' => 'Cape naik turun tangga'],
        ['nama' => 'Rahma Afvira', 'nim' => '09021282429070', 'prodi' => 'Sistem Informasi', 'tanggal_pengajuan' => '13 April 2026', 'status' => 'Pending', 'kamar_awal' => '202', 'kamar_tujuan' => '205', 'no_telepon' => '081234567890', 'status_kipk' => 'Terverifikasi KIPK', 'alasan' => 'Ingin dekat dengan teman satu kelas'],
    ]);
    $pindahItems = method_exists($pindahSource, 'items') ? collect($pindahSource->items()) : collect($pindahSource);
    $selectedPindah = $selectedPindah ?? $pindahItems->first();

    $tabs = [
        ['key' => 'menunggu', 'label' => 'Menunggu'],
        ['key' => 'disetujui', 'label' => 'Disetujui'],
        ['key' => 'ditolak', 'label' => 'Ditolak'],
    ];
@endphp

<x-pengelola-layout title="Verifikasi Pindah Kamar" page-title="Verifikasi Pindah Kamar" active="pindah-kamar">
    <div class="space-y-6">
        <x-pengelola.filter-tabs :tabs="$tabs" active="menunggu" />

        <x-pengelola.search-bar placeholder="Cari Nama atau NIM" />

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_420px]">
            <x-pengelola.panel title="Menunggu ({{ $pindahItems->count() }})" icon="bi-arrow-left-right" padding="p-0">
                <div class="divide-y divide-border-soft">
                    @forelse ($pindahItems as $item)
                        <article class="px-5 py-4 transition hover:bg-brand-light/50">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-content-main">{{ data_get($item, 'nama', data_get($item, 'mahasiswa.nama', '-')) }}</h3>
                                    <p class="mt-1 text-sm text-content-sub">
                                        {{ data_get($item, 'nim', data_get($item, 'mahasiswa.nim', '-')) }} ·
                                        Kamar {{ data_get($item, 'kamar_awal', data_get($item, 'kamarAwal.nomor_kamar', '-')) }} ke
                                        {{ data_get($item, 'kamar_tujuan', data_get($item, 'kamarTujuan.nomor_kamar', '-')) }}
                                    </p>
                                </div>
                                <x-pengelola.status-badge :status="data_get($item, 'status', 'Pending')" />
                            </div>
                        </article>
                    @empty
                        <div class="p-5">
                            <x-pengelola.skeleton-row :rows="10" height="h-12" />
                        </div>
                    @endforelse
                </div>

                <div class="border-t border-border-soft px-5 pb-5">
                    <x-pengelola.pagination :paginator="$pindahSource" />
                </div>
            </x-pengelola.panel>

            <x-pengelola.detail-panel title="Detail Pendaftar" icon="bi-file-earmark-text">
                @if ($selectedPindah)
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-2xl font-bold text-content-main">{{ data_get($selectedPindah, 'nama', data_get($selectedPindah, 'mahasiswa.nama', '-')) }}</h3>
                            <p class="mt-1 text-sm text-content-sub">
                                {{ data_get($selectedPindah, 'nim', data_get($selectedPindah, 'mahasiswa.nim', '-')) }} ·
                                {{ data_get($selectedPindah, 'prodi', data_get($selectedPindah, 'mahasiswa.prodi', '-')) }}
                            </p>
                            <p class="mt-2 text-sm text-content-sub">Diajukan pada tanggal <span class="font-semibold text-content-main">{{ data_get($selectedPindah, 'tanggal_pengajuan', data_get($selectedPindah, 'created_at', '-')) }}</span></p>
                            <div class="mt-3"><x-pengelola.status-badge :status="data_get($selectedPindah, 'status', 'Pending')" /></div>
                        </div>

                        <div class="space-y-4 border-t border-border-soft pt-5">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Kamar Awal</p>
                                <p class="mt-1 font-semibold text-content-main">Kamar {{ data_get($selectedPindah, 'kamar_awal', data_get($selectedPindah, 'kamarAwal.nomor_kamar', '-')) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Kamar Tujuan</p>
                                <p class="mt-1 font-semibold text-content-main">Kamar {{ data_get($selectedPindah, 'kamar_tujuan', data_get($selectedPindah, 'kamarTujuan.nomor_kamar', '-')) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">No. Telepon</p>
                                <p class="mt-1 font-semibold text-content-main">{{ data_get($selectedPindah, 'no_telepon', data_get($selectedPindah, 'mahasiswa.no_telepon', '-')) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Status KIPK</p>
                                <p class="mt-1 font-semibold text-content-main">{{ data_get($selectedPindah, 'status_kipk', data_get($selectedPindah, 'mahasiswa.status_kipk', '-')) }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Alasan</p>
                                <p class="mt-1 leading-relaxed text-content-main">{{ data_get($selectedPindah, 'alasan', '-') }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <x-pengelola.skeleton-row :rows="8" height="h-10" />
                @endif

                <x-slot:actions>
                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-center">
                        <x-pengelola.button icon="bi-check2-circle">Setujui</x-pengelola.button>
                        <x-pengelola.button variant="danger" icon="bi-x-circle">Tolak</x-pengelola.button>
                    </div>
                </x-slot:actions>
            </x-pengelola.detail-panel>
        </section>
    </div>
</x-pengelola-layout>
