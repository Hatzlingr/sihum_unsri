@php
    $hunianSource = $hunians ?? $hunian ?? collect();
    $hunianItems = method_exists($hunianSource, 'items') ? collect($hunianSource->items()) : collect($hunianSource);
@endphp

<x-admin-layout title="Manajemen Hunian" page-title="Manajemen Hunian" active="hunian">
    <div class="space-y-6">
        <x-admin.search-bar placeholder="Cari Hunian">
            <x-admin.action-button variant="secondary" icon="bi-funnel">Filter</x-admin.action-button>
            <x-admin.action-button icon="bi-plus-lg">Tambah Hunian</x-admin.action-button>
        </x-admin.search-bar>

        <x-admin.panel title="Daftar Hunian" icon="bi-buildings" padding="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-border-soft bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                        <tr>
                            <th class="px-5 py-4">Nama Hunian</th>
                            <th class="px-5 py-4">Tipe</th>
                            <th class="px-5 py-4">Lokasi</th>
                            <th class="px-5 py-4">KIPK</th>
                            <th class="px-5 py-4">Total Kamar</th>
                            <th class="px-5 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-soft">
                        @forelse ($hunianItems as $item)
                            <tr class="transition hover:bg-brand-light/50">
                                <td class="px-5 py-4 font-semibold text-content-main">{{ data_get($item, 'nama_hunian', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'tipe', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'lokasi', '-') }}</td>
                                <td class="px-5 py-4"><x-admin.status-badge :status="data_get($item, 'khusus_kipk') ? 'Khusus KIPK' : 'Umum'" /></td>
                                <td class="px-5 py-4 font-semibold text-content-main">{{ collect(data_get($item, 'kamar', []))->count() }}</td>
                                <td class="px-5 py-4"><x-admin.action-button variant="secondary" icon="bi-pencil-square">Kelola</x-admin.action-button></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-6"><x-admin.skeleton-list :rows="8" height="h-11" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-border-soft px-5 pb-5"><x-admin.pagination :paginator="$hunianSource" /></div>
        </x-admin.panel>
    </div>
</x-admin-layout>
