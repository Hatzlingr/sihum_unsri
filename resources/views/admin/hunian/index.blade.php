@php
    $hunianSource = $hunians ?? $hunian ?? collect();
    $hunianItems = method_exists($hunianSource, 'items') ? collect($hunianSource->items()) : collect($hunianSource);
    $safeRoute = static fn (string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
    $safeRouteWithParam = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : url($fallback);
@endphp

<x-admin-layout title="Manajemen Hunian" page-title="Manajemen Hunian" active="hunian">
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <x-admin.search-bar placeholder="Cari Hunian">
            <x-admin.action-button variant="secondary" icon="bi-funnel">Filter</x-admin.action-button>
            <x-admin.action-button :href="$safeRoute('admin.hunian.create', '/admin/hunian/create')" icon="bi-plus-lg">Tambah Hunian</x-admin.action-button>
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
                            @php
                                $id = data_get($item, 'id_hunian', data_get($item, 'id'));
                            @endphp
                            <tr class="transition hover:bg-brand-light/50">
                                <td class="px-5 py-4 font-semibold text-content-main">{{ data_get($item, 'nama_hunian', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'tipe', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'lokasi', '-') }}</td>
                                <td class="px-5 py-4"><x-admin.status-badge :status="data_get($item, 'khusus_kipk') ? 'Khusus KIPK' : 'Umum'" /></td>
                                <td class="px-5 py-4 font-semibold text-content-main">{{ collect(data_get($item, 'kamar', []))->count() }}</td>
                                <td class="px-5 py-4">
                                    <x-admin.action-button :href="$safeRouteWithParam('admin.hunian.edit', $id, '/admin/hunian/' . $id . '/edit')" variant="secondary" icon="bi-pencil-square">Kelola</x-admin.action-button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-6"><x-admin.skeleton-list :rows="8" height="h-11" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($hunianSource && method_exists($hunianSource, 'links'))
                <div class="border-t border-border-soft px-5 pb-5"><x-admin.pagination :paginator="$hunianSource" /></div>
            @endif
        </x-admin.panel>
    </div>
</x-admin-layout>
