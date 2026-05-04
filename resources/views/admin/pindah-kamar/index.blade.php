@php
    $pindahSource = $pindahKamar ?? $requests ?? collect();
    $pindahItems = method_exists($pindahSource, 'items') ? collect($pindahSource->items()) : collect($pindahSource);
    $selected = $selectedPindahKamar ?? $pindahItems->first();
@endphp

<x-admin-layout title="Pindah Kamar" page-title="Pindah Kamar" active="pindah-kamar">
    <div class="space-y-6">
        <x-admin.search-bar placeholder="Cari Nama atau NIM">
            <x-admin.action-button variant="secondary" icon="bi-funnel">Filter</x-admin.action-button>
        </x-admin.search-bar>

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_420px]">
            <x-admin.panel title="Permintaan Pindah Kamar" icon="bi-arrow-left-right" padding="p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="border-b border-border-soft bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                            <tr>
                                <th class="px-5 py-4">Mahasiswa</th>
                                <th class="px-5 py-4">Jenis</th>
                                <th class="px-5 py-4">Kamar Asal</th>
                                <th class="px-5 py-4">Kamar Tujuan</th>
                                <th class="px-5 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-soft">
                            @forelse ($pindahItems as $item)
                                <tr class="transition hover:bg-brand-light/50">
                                    <td class="px-5 py-4 font-semibold text-content-main">{{ data_get($item, 'mahasiswa.nama', '-') }}</td>
                                    <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'jenis_pindah', '-') }}</td>
                                    <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'kamarAsal.nomor_kamar', data_get($item, 'kamar_asal.nomor_kamar', '-')) }}</td>
                                    <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'kamarTujuan.nomor_kamar', data_get($item, 'kamar_tujuan.nomor_kamar', '-')) }}</td>
                                    <td class="px-5 py-4"><x-admin.status-badge :status="data_get($item, 'status_approval', 'Pending')" /></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-5 py-6"><x-admin.skeleton-list :rows="8" height="h-11" /></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-border-soft px-5 pb-5"><x-admin.pagination :paginator="$pindahSource" /></div>
            </x-admin.panel>

            <x-admin.panel title="Detail Pindah Kamar" icon="bi-info-circle">
                @if ($selected)
                    <div class="space-y-5">
                        <x-admin.detail-row label="Mahasiswa" :value="data_get($selected, 'mahasiswa.nama', '-')" />
                        <x-admin.detail-row label="Jenis Pindah" :value="data_get($selected, 'jenis_pindah', '-')" />
                        <x-admin.detail-row label="Alasan" :value="data_get($selected, 'alasan', '-')" />
                        <x-admin.detail-row label="Status Partner" :value="data_get($selected, 'status_partner', '-')" />
                        <x-admin.status-badge :status="data_get($selected, 'status_approval', 'Pending')" />
                        <div class="grid grid-cols-2 gap-3 pt-3">
                            <x-admin.action-button icon="bi-check-lg">Setujui</x-admin.action-button>
                            <x-admin.action-button variant="danger" icon="bi-x-lg">Tolak</x-admin.action-button>
                        </div>
                    </div>
                @else
                    <x-admin.skeleton-list :rows="7" height="h-11" />
                @endif
            </x-admin.panel>
        </section>
    </div>
</x-admin-layout>
