@php
    $logsSource = $activityLogs ?? $logs ?? collect();
    $logItems = method_exists($logsSource, 'items') ? collect($logsSource->items()) : collect($logsSource);
@endphp

<x-admin-layout title="Activity Log" page-title="Activity Log" active="activity-log">
    <div class="space-y-6">
        <x-admin.search-bar placeholder="Cari Aktivitas" class="xl:grid xl:grid-cols-[minmax(280px,520px)_repeat(4,minmax(120px,1fr))]">
            <select name="aksi" class="h-12 rounded-2xl border border-border-soft bg-bg-base px-4 text-sm outline-none transition focus:border-brand focus:ring-4 focus:ring-brand-soft">
                <option value="">Filter Aksi</option>
                <option value="create" @selected(request('aksi') === 'create')>Create</option>
                <option value="update" @selected(request('aksi') === 'update')>Update</option>
                <option value="delete" @selected(request('aksi') === 'delete')>Delete</option>
            </select>
            <select name="modul" class="h-12 rounded-2xl border border-border-soft bg-bg-base px-4 text-sm outline-none transition focus:border-brand focus:ring-4 focus:ring-brand-soft">
                <option value="">Filter Modul</option>
                <option value="pendaftaran" @selected(request('modul') === 'pendaftaran')>Pendaftaran</option>
                <option value="pembayaran" @selected(request('modul') === 'pembayaran')>Pembayaran</option>
                <option value="penempatan" @selected(request('modul') === 'penempatan')>Penempatan</option>
                <option value="mahasiswa" @selected(request('modul') === 'mahasiswa')>Mahasiswa</option>
            </select>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="h-12 rounded-2xl border border-border-soft bg-bg-base px-4 text-sm outline-none transition focus:border-brand focus:ring-4 focus:ring-brand-soft">
            <x-admin.action-button :href="url()->current()" variant="muted" icon="bi-arrow-counterclockwise">Reset</x-admin.action-button>
        </x-admin.search-bar>

        <x-admin.panel padding="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-border-soft bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                        <tr>
                            <th class="px-5 py-4">Timestamp</th>
                            <th class="px-5 py-4">Actor</th>
                            <th class="px-5 py-4">Action</th>
                            <th class="px-5 py-4">Description</th>
                            <th class="px-5 py-4">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-soft">
                        @forelse ($logItems as $log)
                            <tr class="transition hover:bg-brand-light/50">
                                <td class="whitespace-nowrap px-5 py-4 text-content-sub">{{ optional(data_get($log, 'created_at'))->format('d M Y, H:i') ?? '-' }}</td>
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-content-main">{{ data_get($log, 'user.name', data_get($log, 'user.username', 'System')) }}</p>
                                    <p class="text-xs text-content-sub">{{ data_get($log, 'user.email', '-') }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <x-admin.status-badge :status="data_get($log, 'aksi', '-')" />
                                </td>
                                <td class="min-w-[320px] px-5 py-4 text-content-sub">
                                    <span class="font-semibold text-content-main">{{ data_get($log, 'modul', '-') }}</span>
                                    @if (data_get($log, 'target_id'))
                                        <span class="text-content-sub">#{{ data_get($log, 'target_id') }}</span>
                                    @endif
                                    <p class="mt-1">{{ is_array(data_get($log, 'detail')) ? json_encode(data_get($log, 'detail')) : data_get($log, 'detail', '-') }}</p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 font-mono text-xs text-content-sub">{{ data_get($log, 'ip_address', '-') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-6">
                                    <x-admin.empty-state 
                                        title="Belum ada aktivitas" 
                                        description="Tidak ada log aktivitas yang ditemukan berdasarkan pencarian Anda." 
                                        icon="bi-activity"
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-border-soft px-5 pb-5">
                <x-admin.pagination :paginator="$logsSource" />
            </div>
        </x-admin.panel>
    </div>
</x-admin-layout>
