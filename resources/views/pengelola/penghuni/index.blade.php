@php
    $penghuniSource = $penghunis ?? $penghuni ?? collect([
        ['nim' => '09021282429069', 'nama' => 'Rahma Afvira', 'prodi' => 'Teknik Informatika', 'kamar' => '201', 'status_hunian' => 'Aktif', 'status_kipk' => 'KIPK', 'tanggal_masuk' => '12 April 2026'],
        ['nim' => '09021282429070', 'nama' => 'Wahyu Baca Buku', 'prodi' => 'Sistem Informasi', 'kamar' => '308', 'status_hunian' => 'Aktif', 'status_kipk' => 'Non KIPK', 'tanggal_masuk' => '15 April 2026'],
        ['nim' => '09021282429071', 'nama' => 'Aulia Putri', 'prodi' => 'Teknik Komputer', 'kamar' => '202', 'status_hunian' => 'Masa Tinggal Berakhir', 'status_kipk' => 'KIPK', 'tanggal_masuk' => '20 April 2026'],
    ]);
    $penghuniItems = method_exists($penghuniSource, 'items') ? collect($penghuniSource->items()) : collect($penghuniSource);
    $selectedPenghuni = $selectedPenghuni ?? $penghuniItems->first();
@endphp

<x-pengelola-layout title="Manajemen Penghuni" page-title="Manajemen Penghuni" active="penghuni">
    <div class="space-y-6">
        <x-pengelola.search-bar placeholder="Cari Nama atau NIM" />

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
            <x-pengelola.panel title="Daftar Penghuni" icon="bi-people" padding="p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="border-b border-border-soft bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                            <tr>
                                <th class="px-5 py-4">NIM</th>
                                <th class="px-5 py-4">Nama</th>
                                <th class="px-5 py-4">Kamar</th>
                                <th class="px-5 py-4">Status Hunian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-soft">
                            @forelse ($penghuniItems as $item)
                                @php
                                    $nomorKamar = data_get($item, 'kamar.nomor_kamar') ?? data_get($item, 'nomor_kamar') ?? data_get($item, 'kamar') ?? '-';
                                    $nomorKamar = is_scalar($nomorKamar) ? $nomorKamar : '-';
                                @endphp
                                <tr class="transition hover:bg-brand-light/50">
                                    <td class="px-5 py-4 font-semibold text-content-main">{{ data_get($item, 'nim', data_get($item, 'mahasiswa.nim', '-')) }}</td>
                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-content-main">{{ data_get($item, 'nama', data_get($item, 'mahasiswa.nama', '-')) }}</p>
                                        <p class="mt-1 text-xs text-content-sub">{{ data_get($item, 'prodi', data_get($item, 'mahasiswa.prodi', '-')) }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-content-sub">Kamar {{ $nomorKamar }}</td>
                                    <td class="px-5 py-4"><x-pengelola.status-badge :status="data_get($item, 'status_hunian', data_get($item, 'status', 'Aktif'))" /></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-6">
                                        <x-pengelola.skeleton-row :rows="10" height="h-11" />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-border-soft px-5 pb-5">
                    <x-pengelola.pagination :paginator="$penghuniSource" />
                </div>
            </x-pengelola.panel>

            <x-pengelola.detail-panel title="Detail Mahasiswa" icon="bi-person-lines-fill">
                @if ($selectedPenghuni)
                    @php
                        $selectedNomorKamar = data_get($selectedPenghuni, 'kamar.nomor_kamar') ?? data_get($selectedPenghuni, 'nomor_kamar') ?? data_get($selectedPenghuni, 'kamar') ?? '-';
                        $selectedNomorKamar = is_scalar($selectedNomorKamar) ? $selectedNomorKamar : '-';
                    @endphp
                    <div class="space-y-4">
                        <div class="rounded-3xl bg-brand-light p-4">
                            <p class="text-sm text-content-sub">Nama Mahasiswa</p>
                            <p class="mt-1 text-xl font-bold text-content-main">{{ data_get($selectedPenghuni, 'nama', data_get($selectedPenghuni, 'mahasiswa.nama', '-')) }}</p>
                            <p class="mt-1 text-sm text-content-sub">{{ data_get($selectedPenghuni, 'nim', data_get($selectedPenghuni, 'mahasiswa.nim', '-')) }}</p>
                        </div>

                        <div class="space-y-3">
                            <div class="rounded-2xl bg-bg-surface px-4 py-3">
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Program Studi</p>
                                <p class="mt-1 font-semibold text-content-main">{{ data_get($selectedPenghuni, 'prodi', data_get($selectedPenghuni, 'mahasiswa.prodi', '-')) }}</p>
                            </div>
                            <div class="rounded-2xl bg-bg-surface px-4 py-3">
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Kamar</p>
                                <p class="mt-1 font-semibold text-content-main">Kamar {{ $selectedNomorKamar }}</p>
                            </div>
                            <div class="rounded-2xl bg-bg-surface px-4 py-3">
                                <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Tanggal Masuk</p>
                                <p class="mt-1 font-semibold text-content-main">{{ data_get($selectedPenghuni, 'tanggal_masuk', data_get($selectedPenghuni, 'tgl_masuk', '-')) }}</p>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-bg-surface px-4 py-3">
                                <span class="text-sm text-content-sub">KIPK</span>
                                <span class="font-semibold text-content-main">{{ data_get($selectedPenghuni, 'status_kipk', data_get($selectedPenghuni, 'mahasiswa.status_kipk', '-')) }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-bg-surface px-4 py-3">
                                <span class="text-sm text-content-sub">Status Hunian</span>
                                <x-pengelola.status-badge :status="data_get($selectedPenghuni, 'status_hunian', data_get($selectedPenghuni, 'status', 'Aktif'))" />
                            </div>
                        </div>
                    </div>
                @else
                    <x-pengelola.skeleton-row :rows="8" height="h-10" />
                @endif

                <x-slot:actions>
                    <div class="grid grid-cols-2 gap-3">
                        <x-pengelola.button variant="secondary" icon="bi-eye">Detail</x-pengelola.button>
                        <x-pengelola.button variant="dark" icon="bi-clock-history">Riwayat</x-pengelola.button>
                    </div>
                </x-slot:actions>
            </x-pengelola.detail-panel>
        </section>
    </div>
</x-pengelola-layout>
