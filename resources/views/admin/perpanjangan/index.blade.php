@php
    $perpanjanganSource = $perpanjangan ?? $requests ?? collect();
    $perpanjanganItems = method_exists($perpanjanganSource, 'items') ? collect($perpanjanganSource->items()) : collect($perpanjanganSource);
    $approveTemplate = \Illuminate\Support\Facades\Route::has('admin.perpanjangan.approve')
        ? route('admin.perpanjangan.approve', ['id' => '__ID__'])
        : '#';
    $rejectTemplate = \Illuminate\Support\Facades\Route::has('admin.perpanjangan.reject')
        ? route('admin.perpanjangan.reject', ['id' => '__ID__'])
        : '#';
@endphp

<x-admin-layout title="Perpanjangan Hunian" page-title="Perpanjangan Hunian" active="perpanjangan">
    <div
        x-data="{
            modalOpen: false,
            approveTemplate: @js($approveTemplate),
            rejectTemplate: @js($rejectTemplate),
            detail: {
                id: null,
                mahasiswa: '-',
                durasi_bulan: 0,
                tgl_ajuan: '-',
                tgl_keluar_lama: '-',
                tgl_keluar_baru: '-',
                status: '-',
                alasan: '-',
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
                            @php
                                $id = data_get($item, 'id_perpanjangan', data_get($item, 'id'));
                                $detailPayload = [
                                    'id' => $id,
                                    'mahasiswa' => data_get($item, 'mahasiswa.nama', data_get($item, 'penempatan.pendaftaran.mahasiswa.nama', '-')),
                                    'durasi_bulan' => data_get($item, 'durasi_bulan', 0),
                                    'tgl_ajuan' => optional(data_get($item, 'tgl_ajuan'))->format('d M Y') ?? '-',
                                    'tgl_keluar_lama' => optional(data_get($item, 'penempatan.tgl_keluar'))->format('d M Y') ?? '-',
                                    'tgl_keluar_baru' => optional(data_get($item, 'tgl_keluar_baru'))->format('d M Y') ?? '-',
                                    'status' => data_get($item, 'status', 'Pending'),
                                    'alasan' => data_get($item, 'alasan', '-'),
                                ];
                            @endphp
                            <tr class="transition hover:bg-brand-light/50">
                                <td class="px-5 py-4 font-semibold text-content-main">{{ $detailPayload['mahasiswa'] }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ $detailPayload['durasi_bulan'] }} bulan</td>
                                <td class="px-5 py-4 text-content-sub">{{ $detailPayload['tgl_ajuan'] }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ $detailPayload['tgl_keluar_baru'] }}</td>
                                <td class="px-5 py-4"><x-admin.status-badge :status="$detailPayload['status']" /></td>
                                <td class="px-5 py-4">
                                    <button
                                        type="button"
                                        class="inline-flex items-center justify-center gap-2 rounded-2xl border border-border-soft bg-bg-base px-4 py-2.5 text-sm font-semibold text-content-main transition hover:border-brand hover:bg-brand-light hover:text-brand"
                                        x-on:click="openModal(JSON.parse($el.dataset.detail))"
                                        data-detail='@json($detailPayload)'
                                    >
                                        <i class="bi bi-eye"></i>
                                        <span>Detail</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-6"><x-admin.skeleton-list :rows="8" height="h-11" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($perpanjanganSource && method_exists($perpanjanganSource, 'links'))
                <div class="border-t border-border-soft px-5 pb-5"><x-admin.pagination :paginator="$perpanjanganSource" /></div>
            @endif
        </x-admin.panel>

        <div
            x-cloak
            x-show="modalOpen"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-6"
            aria-modal="true"
            role="dialog"
        >
            <div class="fixed inset-0 bg-content-main/50" @click="closeModal()"></div>
            <div class="relative w-full max-w-2xl">
                <x-admin.panel title="Detail Perpanjangan" icon="bi-calendar-check">
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

                    <div class="space-y-5">
                        <x-admin.detail-row label="Mahasiswa">
                            <span x-text="detail.mahasiswa"></span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Durasi Tambahan">
                            <span x-text="detail.durasi_bulan"></span> bulan
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Tanggal Keluar Lama">
                            <span x-text="detail.tgl_keluar_lama"></span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Tanggal Keluar Baru (Estimasi)">
                            <span x-text="detail.tgl_keluar_baru"></span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Alasan Perpanjangan">
                            <span x-text="detail.alasan"></span>
                        </x-admin.detail-row>
                        <x-admin.status-badge :status="'Status'" x-text="detail.status" />

                        <template x-if="detail.status === 'Pending'">
                            <div class="grid grid-cols-2 gap-3 pt-3">
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
                            <div class="flex justify-end pt-3">
                                <x-admin.action-button type="button" variant="secondary" icon="bi-x-lg" @click="closeModal()">Tutup</x-admin.action-button>
                            </div>
                        </template>
                    </div>
                </x-admin.panel>
            </div>
        </div>
    </div>
</x-admin-layout>
