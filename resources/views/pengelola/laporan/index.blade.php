@php
    $occupancyReports = isset($occupancyReports) ? collect($occupancyReports) : collect([
        ['label' => 'Kapasitas Hunian', 'value' => 160],
        ['label' => 'Penghuni Aktif', 'value' => 128],
        ['label' => 'Occupancy Rate', 'value' => '80%'],
    ]);

    $roomReports = isset($roomReports) ? collect($roomReports) : collect([
        ['label' => 'Kamar Kosong', 'value' => 14, 'status' => 'Kosong'],
        ['label' => 'Kamar Terisi', 'value' => 64, 'status' => 'Terisi'],
        ['label' => 'Kamar Rusak', 'value' => 3, 'status' => 'Rusak'],
    ]);

    $penghuniReports = isset($penghuniReports) ? collect($penghuniReports) : collect([
        ['label' => 'Penghuni Baru', 'value' => 12],
        ['label' => 'Penghuni Keluar', 'value' => 4],
        ['label' => 'Pindah Kamar', 'value' => 5],
    ]);

    $monthlySummaries = isset($monthlySummaries) ? collect($monthlySummaries) : collect([
        ['label' => 'Total aktivitas operasional bulan ini', 'value' => 32],
        ['label' => 'Kamar perlu tindak lanjut', 'value' => 3],
        ['label' => 'Pengajuan menunggu keputusan', 'value' => 5],
    ]);
@endphp

<x-pengelola-layout title="Laporan Pengelola" page-title="Laporan" active="laporan">
    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <x-pengelola.button variant="secondary" icon="bi-calendar3">Filter Tanggal</x-pengelola.button>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <x-pengelola.button variant="secondary" icon="bi-file-earmark-pdf">Export PDF</x-pengelola.button>
                <x-pengelola.button variant="secondary" icon="bi-filetype-csv">Export CSV</x-pengelola.button>
            </div>
        </div>

        <section class="grid gap-6 xl:grid-cols-2">
            <x-pengelola.panel title="Occupancy Hunian" icon="bi-buildings">
                @forelse ($occupancyReports as $item)
                    <div class="mb-3 flex items-center justify-between rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 last:mb-0">
                        <span class="text-sm font-semibold text-content-main">{{ data_get($item, 'label', '-') }}</span>
                        <span class="text-xl font-bold text-content-main">{{ data_get($item, 'value', 0) }}</span>
                    </div>
                @empty
                    <x-pengelola.skeleton-row :rows="3" height="h-10" />
                @endforelse
            </x-pengelola.panel>

            <x-pengelola.panel title="Status Kamar" icon="bi-door-open">
                @forelse ($roomReports as $item)
                    <div class="mb-3 flex items-center justify-between rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 last:mb-0">
                        <x-pengelola.status-badge :status="data_get($item, 'status', data_get($item, 'label', '-'))" />
                        <span class="text-xl font-bold text-content-main">{{ data_get($item, 'value', 0) }}</span>
                    </div>
                @empty
                    <x-pengelola.skeleton-row :rows="3" height="h-10" />
                @endforelse
            </x-pengelola.panel>

            <x-pengelola.panel title="Statistik Penghuni" icon="bi-people">
                @forelse ($penghuniReports as $item)
                    <div class="mb-3 flex items-center justify-between rounded-2xl bg-bg-surface px-4 py-3 last:mb-0">
                        <span class="text-sm font-semibold text-content-main">{{ data_get($item, 'label', '-') }}</span>
                        <span class="text-xl font-bold text-content-main">{{ data_get($item, 'value', 0) }}</span>
                    </div>
                @empty
                    <x-pengelola.skeleton-row :rows="3" height="h-10" />
                @endforelse
            </x-pengelola.panel>

            <x-pengelola.panel title="Ringkasan Bulanan" icon="bi-calendar-check">
                @forelse ($monthlySummaries as $item)
                    <div class="mb-3 flex items-center justify-between rounded-2xl bg-bg-surface px-4 py-3 last:mb-0">
                        <span class="text-sm font-semibold text-content-main">{{ data_get($item, 'label', '-') }}</span>
                        <span class="text-xl font-bold text-content-main">{{ data_get($item, 'value', 0) }}</span>
                    </div>
                @empty
                    <x-pengelola.skeleton-row :rows="3" height="h-10" />
                @endforelse
            </x-pengelola.panel>
        </section>
    </div>
</x-pengelola-layout>
