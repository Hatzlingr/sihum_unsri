@php
    $stats = $stats ?? [
        ['label' => 'Total Penghuni', 'value' => $totalPenghuni ?? 0, 'icon' => 'bi-people', 'description' => 'Penghuni aktif'],
        ['label' => 'Occupancy Rate', 'value' => ($occupancyRate ?? 0) . '%', 'icon' => 'bi-pie-chart', 'description' => 'Rasio keterisian'],
        ['label' => 'Kamar Kosong', 'value' => $kamarKosong ?? 0, 'icon' => 'bi-door-open', 'description' => 'Siap ditempati'],
        ['label' => 'Menunggu Verifikasi', 'value' => $menungguVerifikasi ?? 0, 'icon' => 'bi-hourglass-split', 'description' => 'Pendaftaran/pembayaran'],
    ];

    $occupancyByHunian = isset($occupancyByHunian)
        ? (method_exists($occupancyByHunian, 'items') ? collect($occupancyByHunian->items()) : collect($occupancyByHunian))
        : collect();

    $paymentStatus = isset($paymentStatus) ? collect($paymentStatus) : collect();
    $roomStatus = isset($roomStatus) ? collect($roomStatus) : collect();
    $latestPendaftaran = isset($latestPendaftaran)
        ? (method_exists($latestPendaftaran, 'items') ? collect($latestPendaftaran->items()) : collect($latestPendaftaran))
        : collect();

    $safeRoute = static fn (string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
@endphp

<x-admin-layout title="Dashboard Admin" page-title="Dashboard" active="dashboard">
    <div class="space-y-6">
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <x-admin.stat-card
                    :label="$stat['label']"
                    :value="$stat['value']"
                    :icon="$stat['icon']"
                    :description="$stat['description'] ?? null"
                />
            @endforeach
        </section>

        <section class="grid gap-6 xl:grid-cols-2">
            <x-admin.panel title="Occupancy per Hunian" icon="bi-buildings">
                @forelse ($occupancyByHunian as $item)
                    @php
                        $nama = data_get($item, 'nama_hunian', data_get($item, 'nama', 'Hunian'));
                        $terisi = (int) data_get($item, 'terisi', 0);
                        $kapasitas = max((int) data_get($item, 'kapasitas', 0), 1);
                        $percent = min(100, round(($terisi / $kapasitas) * 100));
                    @endphp
                    <div class="mb-4 last:mb-0">
                        <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                            <span class="font-semibold text-content-main">{{ $nama }}</span>
                            <span class="text-content-sub">{{ $terisi }}/{{ $kapasitas }} kamar</span>
                        </div>
                        <div class="h-3 overflow-hidden rounded-full bg-bg-surface">
                            <div class="h-full rounded-full bg-brand" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @empty
                    <x-admin.skeleton-list :rows="5" height="h-9" />
                @endforelse
            </x-admin.panel>

            <x-admin.panel title="Status Pembayaran" icon="bi-credit-card">
                @forelse ($paymentStatus as $item)
                    @php
                        $status = data_get($item, 'status', data_get($item, 'status_verifikasi', 'Status'));
                        $total = data_get($item, 'total', data_get($item, 'count', 0));
                    @endphp
                    <div class="mb-3 flex items-center justify-between rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 last:mb-0">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-soft text-brand"><i class="bi bi-receipt"></i></span>
                            <span class="font-semibold text-content-main">{{ $status }}</span>
                        </div>
                        <span class="text-xl font-bold text-content-main">{{ $total }}</span>
                    </div>
                @empty
                    <x-admin.skeleton-list :rows="6" height="h-9" />
                @endforelse
            </x-admin.panel>

            <x-admin.panel title="Aksi Cepat" icon="bi-lightning-charge">
                <div class="grid gap-3 sm:grid-cols-2">
                    <x-admin.action-button :href="$safeRoute('admin.pendaftaran.index', '/admin/pendaftaran')" variant="secondary" icon="bi-file-earmark-check">Verifikasi Pendaftaran</x-admin.action-button>
                    <x-admin.action-button :href="$safeRoute('admin.pembayaran.index', '/admin/pembayaran')" variant="secondary" icon="bi-credit-card">Verifikasi Pembayaran</x-admin.action-button>
                    <x-admin.action-button :href="$safeRoute('admin.penempatan.index', '/admin/penempatan')" variant="secondary" icon="bi-pin-map">Atur Penempatan</x-admin.action-button>
                    <x-admin.action-button :href="$safeRoute('admin.mahasiswa.index', '/admin/mahasiswa')" variant="secondary" icon="bi-mortarboard">Data Mahasiswa</x-admin.action-button>
                </div>
            </x-admin.panel>

            <x-admin.panel title="Status Kamar" icon="bi-door-open">
                @forelse ($roomStatus as $item)
                    @php
                        $status = data_get($item, 'status', 'Status');
                        $total = data_get($item, 'total', data_get($item, 'count', 0));
                    @endphp
                    <div class="mb-3 flex items-center justify-between rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 last:mb-0">
                        <x-admin.status-badge :status="$status" />
                        <span class="text-xl font-bold text-content-main">{{ $total }}</span>
                    </div>
                @empty
                    <x-admin.skeleton-list :rows="5" height="h-9" />
                @endforelse
            </x-admin.panel>
        </section>

        <x-admin.panel title="Pengajuan Terbaru" icon="bi-inbox">
            @if ($latestPendaftaran->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="text-xs uppercase tracking-wide text-content-sub">
                            <tr>
                                <th class="pb-3 pr-4">Mahasiswa</th>
                                <th class="pb-3 pr-4">Hunian</th>
                                <th class="pb-3 pr-4">Tanggal</th>
                                <th class="pb-3 pr-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-soft">
                            @foreach ($latestPendaftaran as $pendaftaran)
                                <tr>
                                    <td class="py-4 pr-4 font-semibold text-content-main">{{ data_get($pendaftaran, 'mahasiswa.nama', '-') }}</td>
                                    <td class="py-4 pr-4 text-content-sub">{{ data_get($pendaftaran, 'hunian.nama_hunian', '-') }}</td>
                                    <td class="py-4 pr-4 text-content-sub">{{ optional(data_get($pendaftaran, 'tgl_pengajuan'))->format('d M Y') ?? '-' }}</td>
                                    <td class="py-4 pr-4"><x-admin.status-badge :status="data_get($pendaftaran, 'status_seleksi', 'Pending')" /></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-admin.skeleton-list :rows="4" height="h-10" />
            @endif
        </x-admin.panel>
    </div>
</x-admin-layout>
