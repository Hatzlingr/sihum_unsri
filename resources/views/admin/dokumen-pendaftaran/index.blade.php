@php
    $dokumenSource = $dokumen ?? $documents ?? collect();
    $dokumenItems = method_exists($dokumenSource, 'items') ? collect($dokumenSource->items()) : collect($dokumenSource);
@endphp

<x-admin-layout title="Dokumen Pendaftaran" page-title="Dokumen Pendaftaran" active="pendaftaran">
    <div class="space-y-6">
        <x-admin.search-bar placeholder="Cari Dokumen atau Mahasiswa">
            <x-admin.action-button variant="secondary" icon="bi-funnel">Filter</x-admin.action-button>
        </x-admin.search-bar>

        <x-admin.panel title="Dokumen Masuk" icon="bi-file-earmark-text" padding="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-border-soft bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                        <tr>
                            <th class="px-5 py-4">Mahasiswa</th>
                            <th class="px-5 py-4">Tipe Dokumen</th>
                            <th class="px-5 py-4">Tanggal Upload</th>
                            <th class="px-5 py-4">File</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-soft">
                        @forelse ($dokumenItems as $item)
                            @php
                                $fileUrl = method_exists($item, 'getFileUrl') ? $item->getFileUrl() : (data_get($item, 'path_file') ? asset('storage/' . data_get($item, 'path_file')) : '#');
                            @endphp
                            <tr class="transition hover:bg-brand-light/50">
                                <td class="px-5 py-4 font-semibold text-content-main">{{ data_get($item, 'pendaftaran.mahasiswa.nama', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'tipe_dokumen', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ optional(data_get($item, 'uploaded_at'))->format('d M Y') ?? '-' }}</td>
                                <td class="px-5 py-4"><x-admin.action-button :href="$fileUrl" variant="secondary" icon="bi-box-arrow-up-right">Lihat File</x-admin.action-button></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-6"><x-admin.skeleton-list :rows="8" height="h-11" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-border-soft px-5 pb-5"><x-admin.pagination :paginator="$dokumenSource" /></div>
        </x-admin.panel>
    </div>
</x-admin-layout>
