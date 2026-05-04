@php
    $kamarSource = $kamars ?? $kamar ?? collect([
        ['nomor_kamar' => '201', 'kapasitas' => 4, 'terisi' => 3, 'status' => 'Terisi', 'lantai' => 2, 'tipe' => 'Reguler'],
        ['nomor_kamar' => '202', 'kapasitas' => 4, 'terisi' => 0, 'status' => 'Kosong', 'lantai' => 2, 'tipe' => 'Reguler'],
        ['nomor_kamar' => '203', 'kapasitas' => 4, 'terisi' => 4, 'status' => 'Penuh', 'lantai' => 2, 'tipe' => 'KIPK'],
        ['nomor_kamar' => '308', 'kapasitas' => 2, 'terisi' => 1, 'status' => 'Rusak', 'lantai' => 3, 'tipe' => 'Reguler'],
    ]);
    $kamarItems = method_exists($kamarSource, 'items') ? collect($kamarSource->items()) : collect($kamarSource);
    $selectedKamar = $selectedKamar ?? $kamarItems->first();

    $tabs = [
        ['key' => 'semua', 'label' => 'Semua'],
        ['key' => 'kosong', 'label' => 'Kosong'],
        ['key' => 'terisi', 'label' => 'Terisi'],
        ['key' => 'rusak', 'label' => 'Rusak'],
    ];
@endphp

<x-pengelola-layout title="Manajemen Kamar" page-title="Manajemen Kamar" active="kamar">
    <div class="space-y-6">
        <x-pengelola.search-bar placeholder="Cari Kamar" />

        <x-pengelola.filter-tabs :tabs="$tabs" active="semua" />

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
            <x-pengelola.panel title="Daftar Kamar" icon="bi-door-open" padding="p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="border-b border-border-soft bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                            <tr>
                                <th class="px-5 py-4 text-center">No</th>
                                <th class="px-5 py-4">Kamar</th>
                                <th class="px-5 py-4">Kapasitas</th>
                                <th class="px-5 py-4">Status</th>
                                <th class="px-5 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-soft">
                            @forelse ($kamarItems as $item)
                                @php
                                    $status = data_get($item, 'status', ((int) data_get($item, 'terisi', 0) >= (int) data_get($item, 'kapasitas', 1) ? 'Penuh' : 'Kosong'));
                                @endphp
                                <tr class="transition hover:bg-brand-light/50">
                                    <td class="px-5 py-4 text-center font-semibold text-content-main">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-content-main">Kamar {{ data_get($item, 'nomor_kamar', data_get($item, 'nama', '-')) }}</p>
                                        <p class="mt-1 text-xs text-content-sub">Lantai {{ data_get($item, 'lantai', '-') }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'terisi', 0) }}/{{ data_get($item, 'kapasitas', 0) }} orang</td>
                                    <td class="px-5 py-4"><x-pengelola.status-badge :status="$status" /></td>
                                    <td class="px-5 py-4">
                                        <x-pengelola.button variant="secondary" icon="bi-eye" class="px-3 py-2">Detail</x-pengelola.button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-6">
                                        <x-pengelola.skeleton-row :rows="10" height="h-11" />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-border-soft px-5 pb-5">
                    <x-pengelola.pagination :paginator="$kamarSource" />
                </div>
            </x-pengelola.panel>

            <x-pengelola.detail-panel title="Detail Kamar" icon="bi-door-open">
                @if ($selectedKamar)
                    <div class="space-y-4">
                        <div class="rounded-3xl bg-brand-light p-4">
                            <p class="text-sm text-content-sub">Nomor Kamar</p>
                            <p class="mt-1 text-2xl font-bold text-content-main">{{ data_get($selectedKamar, 'nomor_kamar', '-') }}</p>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between rounded-2xl bg-bg-surface px-4 py-3">
                                <span class="text-sm text-content-sub">Lantai</span>
                                <span class="font-semibold text-content-main">{{ data_get($selectedKamar, 'lantai', '-') }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-bg-surface px-4 py-3">
                                <span class="text-sm text-content-sub">Kapasitas</span>
                                <span class="font-semibold text-content-main">{{ data_get($selectedKamar, 'kapasitas', 0) }} orang</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-bg-surface px-4 py-3">
                                <span class="text-sm text-content-sub">Terisi</span>
                                <span class="font-semibold text-content-main">{{ data_get($selectedKamar, 'terisi', 0) }} orang</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-bg-surface px-4 py-3">
                                <span class="text-sm text-content-sub">Tipe</span>
                                <span class="font-semibold text-content-main">{{ data_get($selectedKamar, 'tipe', '-') }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-bg-surface px-4 py-3">
                                <span class="text-sm text-content-sub">Status</span>
                                <x-pengelola.status-badge :status="data_get($selectedKamar, 'status', '-')" />
                            </div>
                        </div>
                    </div>
                @else
                    <x-pengelola.skeleton-row :rows="8" height="h-10" />
                @endif

                <x-slot:actions>
                    <div class="grid grid-cols-2 gap-3">
                        <x-pengelola.button variant="secondary" icon="bi-pencil-square">Edit</x-pengelola.button>
                        <x-pengelola.button variant="dark" icon="bi-arrow-repeat">Status</x-pengelola.button>
                    </div>
                </x-slot:actions>
            </x-pengelola.detail-panel>
        </section>
    </div>
</x-pengelola-layout>
