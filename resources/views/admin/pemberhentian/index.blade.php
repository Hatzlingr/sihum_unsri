@php
    // Logic: controller should pass $pemberhentian (paginated) or $requests (collection) for this view.
    $pemberhentianSource = $pemberhentian ?? $requests ?? collect();
    $pemberhentianItems = method_exists($pemberhentianSource, 'items')
        ? collect($pemberhentianSource->items())
        : collect($pemberhentianSource);
    $statusResolver = static fn ($item) => data_get($item, 'status', data_get($item, 'status_pemberhentian', 'Pending'));
    $activeStatus = request('status', 'Pending');
    $filteredItems = $pemberhentianItems->isNotEmpty()
        ? $pemberhentianItems->filter(fn ($item) => request()->filled('status') ? $statusResolver($item) === $activeStatus : true)
        : collect();

    $counts = $counts ?? [
        'Pending' => $pendingCount ?? $pemberhentianItems->filter(fn ($item) => $statusResolver($item) === 'Pending')->count(),
        'Disetujui' => $approvedCount ?? $pemberhentianItems->filter(fn ($item) => $statusResolver($item) === 'Disetujui')->count(),
        'Ditolak' => $rejectedCount ?? $pemberhentianItems->filter(fn ($item) => $statusResolver($item) === 'Ditolak')->count(),
    ];

    $statusCards = [
        ['label' => 'Menunggu', 'status' => 'Pending', 'icon' => 'bi-hourglass-split'],
        ['label' => 'Disetujui', 'status' => 'Disetujui', 'icon' => 'bi-check-circle'],
        ['label' => 'Ditolak', 'status' => 'Ditolak', 'icon' => 'bi-x-circle'],
    ];

    $approveTemplate = \Illuminate\Support\Facades\Route::has('admin.pemberhentian.approve')
        ? route('admin.pemberhentian.approve', ['id' => '__ID__'])
        : '#';
    $rejectTemplate = \Illuminate\Support\Facades\Route::has('admin.pemberhentian.reject')
        ? route('admin.pemberhentian.reject', ['id' => '__ID__'])
        : '#';

@endphp

<x-admin-layout title="Pemberhentian" page-title="Pemberhentian" active="pemberhentian">
    <div
        x-data="{
            modalOpen: false,
            approveTemplate: @js($approveTemplate),
            rejectTemplate: @js($rejectTemplate),
            detail: {
                id: null,
                nama: '-',
                nim: '-',
                hunian: '-',
                kamar: '-',
                tgl_ajuan: '-',
                tgl_berhenti: '-',
                alasan: '-',
                status: '-',
                berkas_url: null,
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

        <x-admin.search-bar placeholder="Cari Nama atau NIM">
            <x-admin.action-button variant="secondary" icon="bi-funnel">Filter</x-admin.action-button>
        </x-admin.search-bar>

        <section>
            <x-admin.panel padding="p-0">
                <div class="flex gap-2 border-b border-border-soft p-3 sm:p-4">
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Pending'])" :active="$activeStatus === 'Pending'" :count="$counts['Pending'] ?? 0">Menunggu</x-admin.tab-button>
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Disetujui'])" :active="$activeStatus === 'Disetujui'" :count="$counts['Disetujui'] ?? 0">Disetujui</x-admin.tab-button>
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Ditolak'])" :active="$activeStatus === 'Ditolak'" :count="$counts['Ditolak'] ?? 0">Ditolak</x-admin.tab-button>
                </div>

                <div class="p-4 sm:p-5">
                    @forelse (($filteredItems->isNotEmpty() ? $filteredItems : $pemberhentianItems) as $item)
                        @php
                            $id = data_get($item, 'id_pemberhentian', data_get($item, 'id'));
                            $berkasUrl = method_exists($item, 'getBerkasUrl')
                                ? $item->getBerkasUrl()
                                : (data_get($item, 'berkas_path') ? asset('storage/' . data_get($item, 'berkas_path')) : null);
                            $detailPayload = [
                                'id' => $id,
                                'nama' => data_get($item, 'mahasiswa.nama', '-'),
                                'nim' => data_get($item, 'mahasiswa.nim', '-'),
                                'hunian' => data_get($item, 'penempatan.kamar.hunian.nama_hunian', '-'),
                                'kamar' => data_get($item, 'penempatan.kamar.nomor_kamar', '-'),
                                'tgl_ajuan' => optional(data_get($item, 'tgl_ajuan'))->format('d M Y') ?? '-',
                                'tgl_berhenti' => optional(data_get($item, 'tgl_berhenti'))->format('d M Y') ?? '-',
                                'alasan' => data_get($item, 'alasan', '-'),
                                'status' => data_get($item, 'status', 'Pending'),
                                'berkas_url' => $berkasUrl,
                            ];
                        @endphp
                        <button
                            type="button"
                            class="mb-3 block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-left transition last:mb-0 hover:border-brand hover:bg-brand-light"
                            @click='openModal(@json($detailPayload))'
                        >
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="font-semibold text-content-main">{{ $detailPayload['nama'] }}</h3>
                                    <p class="mt-1 text-sm text-content-sub">{{ $detailPayload['nim'] }} · {{ $detailPayload['hunian'] }}</p>
                                </div>
                                <x-admin.status-badge :status="$detailPayload['status']" />
                            </div>
                        </button>
                    @empty
                        <x-admin.skeleton-list :rows="10" height="h-12" />
                    @endforelse

                    @if ($pemberhentianSource && method_exists($pemberhentianSource, 'links'))
                        <x-admin.pagination :paginator="$pemberhentianSource" />
                    @endif
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
                <x-admin.panel title="Detail Pemberhentian" icon="bi-box-arrow-right" padding="p-0">
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
                                <span x-text="detail.hunian"></span>
                                <span> · </span>
                                <span x-text="detail.kamar"></span>
                            </p>
                            <p class="text-sm text-content-sub">Diajukan pada <span x-text="detail.tgl_ajuan"></span></p>
                            <div class="mt-2">
                                <x-admin.status-badge :status="'Status'" x-text="detail.status" />
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-5 border-y border-border-soft p-5 sm:p-6">
                        <x-admin.detail-row label="Tanggal Berhenti">
                            <span x-text="detail.tgl_berhenti"></span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Alasan">
                            <span x-text="detail.alasan"></span>
                        </x-admin.detail-row>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Berkas Pendukung</p>
                            <div class="mt-3">
                                <template x-if="detail.berkas_url">
                                    <a
                                        :href="detail.berkas_url"
                                        target="_blank"
                                        class="inline-flex items-center gap-2 rounded-2xl border border-border-soft bg-bg-surface px-4 py-2 text-sm font-semibold text-content-sub transition hover:border-brand hover:bg-brand-light hover:text-brand"
                                    >
                                        <i class="bi bi-file-earmark-text"></i>
                                        Lihat berkas
                                    </a>
                                </template>
                                <template x-if="!detail.berkas_url">
                                    <p class="text-sm text-content-sub">Tidak ada berkas.</p>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 p-5 sm:flex-row sm:justify-end sm:p-6">
                        <template x-if="detail.status === 'Pending'">
                            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
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
                        </template>
                        <template x-if="detail.status !== 'Pending'">
                            <x-admin.action-button type="button" variant="secondary" icon="bi-x-lg" @click="closeModal()">Tutup</x-admin.action-button>
                        </template>
                    </div>
                </x-admin.panel>
            </div>
        </div>
    </div>
</x-admin-layout>
