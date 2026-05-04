@php
    $perpanjanganSource = $perpanjangan ?? $requests ?? collect();
    $perpanjanganItems = method_exists($perpanjanganSource, 'items') ? collect($perpanjanganSource->items()) : collect($perpanjanganSource);
@endphp

<x-admin-layout title="Perpanjangan Hunian" page-title="Perpanjangan Hunian" active="penempatan">
    <div class="space-y-6">
        <x-admin.search-bar placeholder="Cari Pengajuan Perpanjangan">
            <x-admin.action-button variant="secondary" icon="bi-funnel">Filter</x-admin.action-button>
        </x-admin.search-bar>

        <x-admin.panel title="Daftar Pengajuan Perpanjangan" icon="bi-calendar-plus" padding="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-border-soft bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                        <tr>
                            <th class="px-5 py-4">Mahasiswa</th>
                            <th class="px-5 py-4">Durasi</th>
                            <th class="px-5 py-4">Tanggal Ajuan</th>
                            <th class="px-5 py-4">Keluar Baru</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-soft">
                        @forelse ($perpanjanganItems as $item)
                            <tr class="transition hover:bg-brand-light/50">
                                <td class="px-5 py-4 font-semibold text-content-main">{{ data_get($item, 'mahasiswa.nama', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'durasi_bulan', 0) }} bulan</td>
                                <td class="px-5 py-4 text-content-sub">{{ optional(data_get($item, 'tgl_ajuan'))->format('d M Y') ?? '-' }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ optional(data_get($item, 'tgl_keluar_baru'))->format('d M Y') ?? '-' }}</td>
                                <td class="px-5 py-4"><x-admin.status-badge :status="data_get($item, 'status', 'Pending')" /></td>
                                <td class="px-5 py-4"><x-admin.action-button variant="secondary" icon="bi-eye">Detail</x-admin.action-button></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-6"><x-admin.skeleton-list :rows="8" height="h-11" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-border-soft px-5 pb-5"><x-admin.pagination :paginator="$perpanjanganSource" /></div>
        </x-admin.panel>
    </div>
</x-admin-layout>
