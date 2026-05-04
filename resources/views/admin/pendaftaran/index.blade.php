@php
    $pendaftaranSource = $pendaftaran ?? $pengajuan ?? collect();
    $pendaftaranItems = method_exists($pendaftaranSource, 'items') ? collect($pendaftaranSource->items()) : collect($pendaftaranSource);
    $activeStatus = request('status', 'Pending');
    $filteredItems = $pendaftaranItems->isNotEmpty()
        ? $pendaftaranItems->filter(fn ($item) => request()->filled('status') ? data_get($item, 'status_seleksi') === $activeStatus : true)
        : collect();
    $selected = $selectedPendaftaran ?? $filteredItems->first() ?? $pendaftaranItems->first();

    $counts = $counts ?? [
        'Pending' => $pendingCount ?? $pendaftaranItems->where('status_seleksi', 'Pending')->count(),
        'Disetujui' => $approvedCount ?? $pendaftaranItems->where('status_seleksi', 'Disetujui')->count(),
        'Ditolak' => $rejectedCount ?? $pendaftaranItems->where('status_seleksi', 'Ditolak')->count(),
    ];

    $statusCards = [
        ['label' => 'Menunggu', 'status' => 'Pending', 'icon' => 'bi-hourglass-split'],
        ['label' => 'Disetujui', 'status' => 'Disetujui', 'icon' => 'bi-check-circle'],
        ['label' => 'Ditolak', 'status' => 'Ditolak', 'icon' => 'bi-x-circle'],
    ];

    $safeAction = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : $fallback;
@endphp

<x-admin-layout title="Verifikasi Pendaftaran" page-title="Verifikasi Pendaftaran" active="pendaftaran">
    <div class="space-y-6">
        <section class="grid gap-4 sm:grid-cols-3 xl:max-w-3xl">
            @foreach ($statusCards as $card)
                <x-admin.stat-card
                    :label="$card['label']"
                    :value="$counts[$card['status']] ?? 0"
                    :icon="$card['icon']"
                />
            @endforeach
        </section>

        <x-admin.search-bar placeholder="Cari Nama atau NIM" />

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_520px]">
            <x-admin.panel padding="p-0">
                <div class="flex gap-2 border-b border-border-soft p-3 sm:p-4">
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Pending'])" :active="$activeStatus === 'Pending'" :count="$counts['Pending'] ?? 0">Menunggu</x-admin.tab-button>
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Disetujui'])" :active="$activeStatus === 'Disetujui'" :count="$counts['Disetujui'] ?? 0">Disetujui</x-admin.tab-button>
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Ditolak'])" :active="$activeStatus === 'Ditolak'" :count="$counts['Ditolak'] ?? 0">Ditolak</x-admin.tab-button>
                </div>

                <div class="p-4 sm:p-5">
                    @forelse (($filteredItems->isNotEmpty() ? $filteredItems : $pendaftaranItems) as $item)
                        @php
                            $id = data_get($item, 'id_daftar', data_get($item, 'id'));
                        @endphp
                        <a href="{{ request()->fullUrlWithQuery(['selected' => $id]) }}" class="mb-3 block rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 transition last:mb-0 hover:border-brand hover:bg-brand-light">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="font-semibold text-content-main">{{ data_get($item, 'mahasiswa.nama', '-') }}</h3>
                                    <p class="mt-1 text-sm text-content-sub">{{ data_get($item, 'mahasiswa.nim', '-') }} · {{ data_get($item, 'mahasiswa.prodi', '-') }}</p>
                                </div>
                                <x-admin.status-badge :status="data_get($item, 'status_seleksi', 'Pending')" />
                            </div>
                        </a>
                    @empty
                        <x-admin.skeleton-list :rows="10" height="h-12" />
                    @endforelse

                    <x-admin.pagination :paginator="$pendaftaranSource" />
                </div>
            </x-admin.panel>

            <x-admin.panel title="Detail Pendaftar" icon="bi-person-lines-fill" padding="p-0">
                @if ($selected)
                    @php
                        $documents = collect(data_get($selected, 'dokumen', []));
                        $selectedId = data_get($selected, 'id_daftar', data_get($selected, 'id', 0));
                    @endphp
                    <div class="p-5 sm:p-6">
                        <div class="space-y-1">
                            <h3 class="text-2xl font-bold text-content-main">{{ data_get($selected, 'mahasiswa.nama', '-') }}</h3>
                            <p class="text-content-sub">{{ data_get($selected, 'mahasiswa.nim', '-') }} · {{ data_get($selected, 'mahasiswa.prodi', '-') }} · {{ data_get($selected, 'mahasiswa.status_kipk') ? 'KIPK' : 'Non KIPK' }}</p>
                            <p class="text-sm text-content-sub">Diajukan pada {{ optional(data_get($selected, 'tgl_pengajuan'))->format('d F Y') ?? '-' }}</p>
                            <x-admin.status-badge :status="data_get($selected, 'status_seleksi', 'Pending')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid gap-5 border-y border-border-soft p-5 sm:p-6">
                        <x-admin.detail-row label="Hunian Dipilih" :value="data_get($selected, 'hunian.nama_hunian', '-')" />
                        <x-admin.detail-row label="Tipe Hunian" :value="data_get($selected, 'hunian.tipe', '-') . (data_get($selected, 'hunian.khusus_kipk') ? ' (KIPK)' : '')" />
                        <x-admin.detail-row label="No. Telepon" :value="data_get($selected, 'mahasiswa.no_hp', '-')" />
                        <x-admin.detail-row label="Status KIPK" :value="data_get($selected, 'mahasiswa.status_kipk') ? 'Terverifikasi KIPK' : 'Non KIPK'" />

                        <div>
                            <h4 class="mb-3 font-semibold text-content-main">Dokumen Persyaratan</h4>
                            <div class="grid grid-cols-3 gap-3">
                                @forelse ($documents as $document)
                                    @php
                                        $fileUrl = method_exists($document, 'getFileUrl') ? $document->getFileUrl() : asset('storage/' . data_get($document, 'path_file'));
                                    @endphp
                                    <a href="{{ $fileUrl }}" target="_blank" class="flex aspect-square flex-col items-center justify-center rounded-2xl border border-border-soft bg-bg-surface text-center text-xs font-semibold text-content-sub transition hover:border-brand hover:bg-brand-light hover:text-brand">
                                        <i class="bi bi-file-earmark-text text-2xl"></i>
                                        <span class="mt-2 line-clamp-2">{{ data_get($document, 'tipe_dokumen', 'Dokumen') }}</span>
                                    </a>
                                @empty
                                    @for ($i = 0; $i < 3; $i++)
                                        <div class="aspect-square rounded-2xl bg-content-sub/25"></div>
                                    @endfor
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 p-5 sm:flex-row sm:justify-end sm:p-6">
                        <form method="POST" action="{{ $safeAction('admin.pendaftaran.approve', $selectedId, '#') }}">
                            @csrf
                            @method('PATCH')
                            <x-admin.action-button type="submit" icon="bi-check-lg">Setujui</x-admin.action-button>
                        </form>
                        <form method="POST" action="{{ $safeAction('admin.pendaftaran.reject', $selectedId, '#') }}">
                            @csrf
                            @method('PATCH')
                            <x-admin.action-button type="submit" variant="danger" icon="bi-x-lg">Tolak</x-admin.action-button>
                        </form>
                    </div>
                @else
                    <div class="p-5 sm:p-6">
                        <x-admin.skeleton-list :rows="5" height="h-11" />
                    </div>
                    <div class="border-t border-border-soft p-5 sm:p-6">
                        <x-admin.skeleton-list :rows="2" height="h-24" />
                    </div>
                    <div class="flex justify-end gap-3 border-t border-border-soft p-5 sm:p-6">
                        <x-admin.action-button variant="secondary">Setujui</x-admin.action-button>
                        <x-admin.action-button variant="secondary">Tolak</x-admin.action-button>
                    </div>
                @endif
            </x-admin.panel>
        </section>
    </div>
</x-admin-layout>
