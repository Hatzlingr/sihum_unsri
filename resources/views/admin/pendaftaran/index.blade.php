@php
    $pendaftaranSource = $pendaftaran ?? $pengajuan ?? collect();
    $pendaftaranItems = method_exists($pendaftaranSource, 'items') ? collect($pendaftaranSource->items()) : collect($pendaftaranSource);
    $activeStatus = request('status', 'Pending');

    $counts = $counts ?? [
        'Pending' => $pendingCount ?? 0,
        'Disetujui' => $approvedCount ?? 0,
        'Ditolak' => $rejectedCount ?? 0,
    ];

    $statusCards = [
        ['label' => 'Menunggu', 'status' => 'Pending', 'icon' => 'bi-hourglass-split'],
        ['label' => 'Disetujui', 'status' => 'Disetujui', 'icon' => 'bi-check-circle'],
        ['label' => 'Ditolak', 'status' => 'Ditolak', 'icon' => 'bi-x-circle'],
    ];

    $safeAction = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : $fallback;
    $approveTemplate = \Illuminate\Support\Facades\Route::has('admin.pendaftaran.approve')
        ? route('admin.pendaftaran.approve', ['id' => '__ID__'])
        : '#';
    $rejectTemplate = \Illuminate\Support\Facades\Route::has('admin.pendaftaran.reject')
        ? route('admin.pendaftaran.reject', ['id' => '__ID__'])
        : '#';
@endphp

<x-admin-layout title="Verifikasi Pendaftaran" page-title="Verifikasi Pendaftaran" active="pendaftaran">
    <div
        x-data="{
            modalOpen: false,
            approveTemplate: @js($approveTemplate),
            rejectTemplate: @js($rejectTemplate),
            detail: {
                id: null,
                nama: '-',
                nim: '-',
                prodi: '-',
                status_kipk: '-',
                tgl_pengajuan: '-',
                status_seleksi: '-',
                hunian: '-',
                tipe_hunian: '-',
                no_hp: '-',
                documents: [],
            },
            openModal(payload) {
                this.detail = { ...this.detail, ...payload };
                this.modalOpen = true;
            },
            closeModal() {
                this.modalOpen = false;
            },
            approveAction() {
                return this.approveTemplate === '#'
                    ? '#'
                    : this.approveTemplate.replace('__ID__', this.detail.id ?? '');
            },
            rejectAction() {
                return this.rejectTemplate === '#'
                    ? '#'
                    : this.rejectTemplate.replace('__ID__', this.detail.id ?? '');
            },
        }"
        class="space-y-6"
        @keydown.escape.window="closeModal()"
    >
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

        <section>
            <x-admin.panel padding="p-0">
                <div class="flex gap-2 border-b border-border-soft p-3 sm:p-4">
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Pending'])" :active="$activeStatus === 'Pending'" :count="$counts['Pending'] ?? 0">Menunggu</x-admin.tab-button>
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Disetujui'])" :active="$activeStatus === 'Disetujui'" :count="$counts['Disetujui'] ?? 0">Disetujui</x-admin.tab-button>
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Ditolak'])" :active="$activeStatus === 'Ditolak'" :count="$counts['Ditolak'] ?? 0">Ditolak</x-admin.tab-button>
                </div>

                <div class="p-4 sm:p-5">
                    @forelse ($pendaftaranItems as $item)
                        @php
                            $id = data_get($item, 'id_daftar', data_get($item, 'id'));
                            $documentsPayload = collect(data_get($item, 'dokumen', []))
                                ->map(function ($document) {
                                    $fileUrl = method_exists($document, 'getFileUrl')
                                        ? $document->getFileUrl()
                                        : (data_get($document, 'path_file') ? asset('storage/' . data_get($document, 'path_file')) : '#');

                                    return [
                                        'label' => data_get($document, 'tipe_dokumen', 'Dokumen'),
                                        'url' => $fileUrl,
                                    ];
                                })
                                ->values()
                                ->all();

                            $detailPayload = [
                                'id' => $id,
                                'nama' => data_get($item, 'mahasiswa.nama', '-'),
                                'nim' => data_get($item, 'mahasiswa.nim', '-'),
                                'prodi' => data_get($item, 'mahasiswa.prodi', '-'),
                                'status_kipk' => data_get($item, 'mahasiswa.status_kipk') ? 'KIPK' : 'Non KIPK',
                                'tgl_pengajuan' => optional(data_get($item, 'tgl_pengajuan'))->format('d F Y') ?? '-',
                                'status_seleksi' => data_get($item, 'status_seleksi', 'Pending'),
                                'hunian' => data_get($item, 'hunian.nama_hunian', '-'),
                                'tipe_hunian' => data_get($item, 'hunian.tipe', '-') . (data_get($item, 'hunian.khusus_kipk') ? ' (KIPK)' : ''),
                                'no_hp' => data_get($item, 'mahasiswa.no_hp', '-'),
                                'documents' => $documentsPayload,
                            ];
                        @endphp
                        <button
                            type="button"
                            class="mb-3 block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-left transition last:mb-0 hover:border-brand hover:bg-brand-light"
                            @click='openModal(@json($detailPayload))'
                        >
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="font-semibold text-content-main">{{ data_get($item, 'mahasiswa.nama', '-') }}</h3>
                                    <p class="mt-1 text-sm text-content-sub">{{ data_get($item, 'mahasiswa.nim', '-') }} · {{ data_get($item, 'mahasiswa.prodi', '-') }}</p>
                                </div>
                                <x-admin.status-badge :status="data_get($item, 'status_seleksi', 'Pending')" />
                            </div>
                        </button>
                    @empty
                        <x-admin.skeleton-list :rows="10" height="h-12" />
                    @endforelse

                    <x-admin.pagination :paginator="$pendaftaranSource" />
                </div>
            </x-admin.panel>

        </section>

        <div
            x-cloak
            x-show="modalOpen"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-6"
            aria-modal="true"
            role="dialog"
        >
            <div class="fixed inset-0 bg-content-main/50" @click="closeModal()"></div>
            <div class="relative w-full max-w-3xl">
                <x-admin.panel title="Detail Pendaftar" icon="bi-person-lines-fill" padding="p-0">
                    <x-slot:actions>
                        <button
                            type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-border-soft text-content-sub transition hover:border-brand hover:bg-brand-light hover:text-brand"
                            aria-label="Tutup modal"
                            @click="closeModal()"
                        >
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </x-slot:actions>

                    <div class="p-5 sm:p-6">
                        <div class="space-y-1">
                            <h3 class="text-2xl font-bold text-content-main" x-text="detail.nama"></h3>
                            <p class="text-content-sub">
                                <span x-text="detail.nim"></span>
                                <span> · </span>
                                <span x-text="detail.prodi"></span>
                                <span> · </span>
                                <span x-text="detail.status_kipk"></span>
                            </p>
                            <p class="text-sm text-content-sub">Diajukan pada <span x-text="detail.tgl_pengajuan"></span></p>
                            <div class="mt-2">
                                <x-admin.status-badge :status="'Status'" x-text="detail.status_seleksi" />
                            </div>
                        </div>
                    </div>

                    <div class="border-y border-border-soft p-5 sm:p-6">
                        <div class="grid gap-5 sm:grid-cols-2">
                            <x-admin.detail-row label="Hunian Dipilih">
                                <span x-text="detail.hunian"></span>
                            </x-admin.detail-row>
                            <x-admin.detail-row label="Tipe Hunian">
                                <span x-text="detail.tipe_hunian"></span>
                            </x-admin.detail-row>
                            <x-admin.detail-row label="No. Telepon">
                                <span x-text="detail.no_hp"></span>
                            </x-admin.detail-row>
                            <x-admin.detail-row label="Status KIPK">
                                <span x-text="detail.status_kipk"></span>
                            </x-admin.detail-row>
                        </div>

                        <div class="mt-6">
                            <h4 class="mb-3 font-semibold text-content-main">Dokumen Persyaratan</h4>
                            <div class="grid grid-cols-3 gap-3">
                                <template x-for="doc in detail.documents" :key="doc.url">
                                    <a
                                        :href="doc.url"
                                        target="_blank"
                                        class="flex aspect-square flex-col items-center justify-center rounded-2xl border border-border-soft bg-bg-surface text-center text-xs font-semibold text-content-sub transition hover:border-brand hover:bg-brand-light hover:text-brand"
                                    >
                                        <i class="bi bi-file-earmark-text text-2xl"></i>
                                        <span class="mt-2 line-clamp-2" x-text="doc.label"></span>
                                    </a>
                                </template>
                                <template x-if="detail.documents.length === 0">
                                    <div class="aspect-square rounded-2xl bg-content-sub/25"></div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 p-5 sm:flex-row sm:justify-end sm:p-6">
                        <form method="POST" x-bind:action="approveAction()">
                            @csrf
                            @method('PATCH')
                            <x-admin.action-button type="submit" icon="bi-check-lg">Setujui</x-admin.action-button>
                        </form>
                        <form method="POST" x-bind:action="rejectAction()">
                            @csrf
                            @method('PATCH')
                            <x-admin.action-button type="submit" variant="danger" icon="bi-x-lg">Tolak</x-admin.action-button>
                        </form>
                    </div>
                </x-admin.panel>
            </div>
        </div>
    </div>
</x-admin-layout>
