@php
    $stats = $stats ?? [
        ['label' => 'Total Penghuni', 'value' => data_get($summary ?? [], 'total_penghuni', '128'), 'icon' => 'bi-people', 'description' => 'Penghuni aktif di hunian Anda'],
        ['label' => 'Occupancy Rate', 'value' => data_get($summary ?? [], 'occupancy_rate', '82%'), 'icon' => 'bi-pie-chart', 'description' => 'Rasio keterisian kamar'],
        ['label' => 'Kamar Kosong', 'value' => data_get($summary ?? [], 'kamar_kosong', '14'), 'icon' => 'bi-door-open', 'description' => 'Kamar masih tersedia'],
        ['label' => 'Kamar Rusak', 'value' => data_get($summary ?? [], 'kamar_rusak', '3'), 'icon' => 'bi-tools', 'description' => 'Perlu perbaikan'],
    ];

    $occupancyHunian = isset($occupancyHunian)
        ? (method_exists($occupancyHunian, 'items') ? collect($occupancyHunian->items()) : collect($occupancyHunian))
        : collect([
            ['label' => 'Rusunawa Putra Lama', 'terisi' => 82, 'kapasitas' => 100],
            ['label' => 'Lantai 1', 'terisi' => 35, 'kapasitas' => 40],
            ['label' => 'Lantai 2', 'terisi' => 47, 'kapasitas' => 60],
        ]);

    $statusKamar = isset($statusKamar)
        ? collect($statusKamar)
        : collect([
            ['status' => 'Kosong', 'total' => 14],
            ['status' => 'Terisi', 'total' => 64],
            ['status' => 'Rusak', 'total' => 3],
        ]);

    $statistikPenghuni = isset($statistikPenghuni)
        ? collect($statistikPenghuni)
        : collect([
            ['label' => 'Penghuni Baru Bulan Ini', 'value' => 12],
            ['label' => 'Masa Tinggal Berakhir', 'value' => 8],
            ['label' => 'Pengajuan Pindah Kamar', 'value' => 5],
        ]);

    $activities = isset($activities)
        ? (method_exists($activities, 'items') ? collect($activities->items()) : collect($activities))
        : collect([
            ['title' => 'Status kamar 308 diubah menjadi rusak', 'time' => 'Hari ini, 10.30'],
            ['title' => 'Penghuni baru ditempatkan ke kamar 201', 'time' => 'Kemarin, 14.15'],
            ['title' => 'Pengajuan pindah kamar menunggu verifikasi', 'time' => '2 hari lalu'],
        ]);

    $safeRoute = static fn (string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
@endphp

<x-pengelola-layout title="Dashboard Pengelola" page-title="Dashboard" active="dashboard">
    <div class="space-y-6">
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <x-pengelola.stat-card
                    :label="$stat['label']"
                    :value="$stat['value']"
                    :icon="$stat['icon']"
                    :description="$stat['description'] ?? null"
                />
            @endforeach
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <x-pengelola.panel title="Occupancy Hunian" icon="bi-buildings">
                @forelse ($occupancyHunian as $item)
                    @php
                        $label = data_get($item, 'label', data_get($item, 'nama_hunian', 'Hunian'));
                        $terisi = (int) data_get($item, 'terisi', 0);
                        $kapasitas = max((int) data_get($item, 'kapasitas', 1), 1);
                        $percent = min(100, round(($terisi / $kapasitas) * 100));
                    @endphp
                    <div class="mb-4 last:mb-0">
                        <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                            <span class="font-semibold text-content-main">{{ $label }}</span>
                            <span class="text-content-sub">{{ $terisi }}/{{ $kapasitas }}</span>
                        </div>
                        <div class="h-3 overflow-hidden rounded-full bg-bg-surface">
                            <div class="h-full rounded-full bg-brand" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @empty
                    <x-pengelola.skeleton-row :rows="5" height="h-9" />
                @endforelse
            </x-pengelola.panel>

            <x-pengelola.panel title="Status Kamar" icon="bi-door-open">
                @forelse ($statusKamar as $item)
                    <div class="mb-3 flex items-center justify-between rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 last:mb-0">
                        <x-pengelola.status-badge :status="data_get($item, 'status', 'Status')" />
                        <span class="text-xl font-bold text-content-main">{{ data_get($item, 'total', data_get($item, 'count', 0)) }}</span>
                    </div>
                @empty
                    <x-pengelola.skeleton-row :rows="5" height="h-9" />
                @endforelse
            </x-pengelola.panel>

            <x-pengelola.panel title="Aksi Cepat" icon="bi-lightning-charge">
                <div class="grid gap-3 sm:grid-cols-2">
                    <x-pengelola.button :href="$safeRoute('pengelola.kamar.index', '/pengelola/kamar')" variant="secondary" icon="bi-door-open">Kelola Kamar</x-pengelola.button>
                    <x-pengelola.button :href="$safeRoute('pengelola.penghuni.index', '/pengelola/penghuni')" variant="secondary" icon="bi-people">Lihat Penghuni</x-pengelola.button>
                    <x-pengelola.button :href="$safeRoute('pengelola.pindah-kamar.index', '/pengelola/pindah-kamar')" variant="secondary" icon="bi-arrow-left-right">Verifikasi Pindah</x-pengelola.button>
                    <x-pengelola.button :href="$safeRoute('pengelola.laporan.index', '/pengelola/laporan')" variant="secondary" icon="bi-clipboard-data">Buka Laporan</x-pengelola.button>
                </div>
            </x-pengelola.panel>

            <x-pengelola.panel title="Statistik Penghuni" icon="bi-graph-up-arrow">
                @forelse ($statistikPenghuni as $item)
                    <div class="mb-3 flex items-center justify-between rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 last:mb-0">
                        <span class="text-sm font-semibold text-content-main">{{ data_get($item, 'label', '-') }}</span>
                        <span class="text-xl font-bold text-content-main">{{ data_get($item, 'value', 0) }}</span>
                    </div>
                @empty
                    <x-pengelola.skeleton-row :rows="4" height="h-10" />
                @endforelse
            </x-pengelola.panel>
        </section>

        <x-pengelola.panel title="Aktivitas Terbaru" icon="bi-activity">
            <div class="space-y-3">
                @forelse ($activities as $activity)
                    <div class="flex items-start gap-3 rounded-2xl border border-border-soft bg-bg-surface px-4 py-3">
                        <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-soft text-brand">
                            <i class="bi bi-clock-history"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-content-main">{{ data_get($activity, 'title', data_get($activity, 'description', 'Aktivitas')) }}</p>
                            <p class="mt-1 text-xs text-content-sub">{{ data_get($activity, 'time', data_get($activity, 'created_at', '-')) }}</p>
                        </div>
                    </div>
                @empty
                    <x-pengelola.skeleton-row :rows="4" height="h-10" />
                @endforelse
            </div>
        </x-pengelola.panel>
    </div>
</x-pengelola-layout>
