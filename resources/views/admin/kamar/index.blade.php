@php
    $kamarSource = $kamars ?? $kamar ?? collect();
    $kamarItems = method_exists($kamarSource, 'items') ? collect($kamarSource->items()) : collect($kamarSource);
@endphp

<x-admin-layout title="Manajemen Kamar" page-title="Manajemen Kamar" active="kamar">
    <div class="space-y-6">
        <x-admin.search-bar placeholder="Cari Kamar atau Hunian">
            <x-admin.action-button variant="secondary" icon="bi-funnel">Filter</x-admin.action-button>
            <x-admin.action-button icon="bi-plus-lg">Tambah Kamar</x-admin.action-button>
        </x-admin.search-bar>

        <x-admin.panel title="Daftar Kamar" icon="bi-door-open" padding="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-border-soft bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                        <tr>
                            <th class="px-5 py-4">Hunian</th>
                            <th class="px-5 py-4">Nomor</th>
                            <th class="px-5 py-4">Lantai</th>
                            <th class="px-5 py-4">Kapasitas</th>
                            <th class="px-5 py-4">Harga</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-soft">
                        @forelse ($kamarItems as $item)
                            <tr class="transition hover:bg-brand-light/50">
                                <td class="px-5 py-4 font-semibold text-content-main">{{ data_get($item, 'hunian.nama_hunian', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'nomor_kamar', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'lantai', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'terisi', 0) }}/{{ data_get($item, 'kapasitas', 0) }}</td>
                                <td class="px-5 py-4 text-content-sub">Rp {{ number_format((float) data_get($item, 'harga_sewa', 0), 0, ',', '.') }}</td>
                                <td class="px-5 py-4"><x-admin.status-badge :status="data_get($item, 'status', '-')" /></td>
                                <td class="px-5 py-4"><x-admin.action-button variant="secondary" icon="bi-pencil-square">Kelola</x-admin.action-button></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-6"><x-admin.skeleton-list :rows="8" height="h-11" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-border-soft px-5 pb-5"><x-admin.pagination :paginator="$kamarSource" /></div>
        </x-admin.panel>
    </div>
</x-admin-layout>
