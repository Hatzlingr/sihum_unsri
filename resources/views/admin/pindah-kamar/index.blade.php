@php
    $pindahSource = $pindahKamar ?? $requests ?? collect();
    $pindahItems = method_exists($pindahSource, 'items') ? collect($pindahSource->items()) : collect($pindahSource);
    $approveTemplate = \Illuminate\Support\Facades\Route::has('admin.pindah-kamar.approve')
        ? route('admin.pindah-kamar.approve', ['id' => '__ID__'])
        : '#';
    $rejectTemplate = \Illuminate\Support\Facades\Route::has('admin.pindah-kamar.reject')
        ? route('admin.pindah-kamar.reject', ['id' => '__ID__'])
        : '#';
@endphp

<x-admin-layout title="Pindah Kamar" page-title="Pindah Kamar" active="pindah-kamar">
    <div
        x-data="{
            modalOpen: false,
            approveTemplate: @js($approveTemplate),
            rejectTemplate: @js($rejectTemplate),
            detail: {
                id: null,
                mahasiswa: '-',
                mahasiswa_nim: '-',
                partner_nama: '-',
                partner_nim: '-',
                jenis: '-',
                alasan: '-',
                status_partner: '-',
                status_approval: '-',
                kamar_asal: '-',
                kamar_tujuan: '-',
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
        <x-admin.search-bar placeholder="Cari Nama atau NIM">
            <x-admin.action-button variant="secondary" icon="bi-funnel">Filter</x-admin.action-button>
        </x-admin.search-bar>

        <section>
            <x-admin.panel title="Permintaan Pindah Kamar" icon="bi-arrow-left-right" padding="p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="border-b border-border-soft bg-bg-surface text-xs font-semibold uppercase tracking-wide text-content-sub">
                            <tr>
                                <th class="px-5 py-4">Mahasiswa</th>
                                <th class="px-5 py-4">Jenis</th>
                                <th class="px-5 py-4">Kamar Asal</th>
                                <th class="px-5 py-4">Kamar Tujuan</th>
                                <th class="px-5 py-4">Status</th>
                                <th class="px-5 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-soft">
                            @forelse ($pindahItems as $item)
                                @php
                                    $id = data_get($item, 'id_pindah', data_get($item, 'id'));
                                    $partnerNama = data_get($item, 'partnerTukar.nama', data_get($item, 'partner_tukar.nama', '-'));
                                    $partnerNim = data_get($item, 'partnerTukar.nim', data_get($item, 'partner_tukar.nim', '-'));
                                    $detailPayload = [
                                        'id' => $id,
                                        'mahasiswa' => data_get($item, 'mahasiswa.nama', '-'),
                                        'mahasiswa_nim' => data_get($item, 'mahasiswa.nim', '-'),
                                        'partner_nama' => $partnerNama,
                                        'partner_nim' => $partnerNim,
                                        'jenis' => data_get($item, 'jenis_pindah', '-'),
                                        'alasan' => data_get($item, 'alasan', '-'),
                                        'status_partner' => data_get($item, 'status_partner', '-'),
                                        'status_approval' => data_get($item, 'status_approval', 'Pending'),
                                        'kamar_asal' => data_get($item, 'kamarAsal.nomor_kamar', data_get($item, 'kamar_asal.nomor_kamar', '-')),
                                        'kamar_tujuan' => data_get($item, 'kamarTujuan.nomor_kamar', data_get($item, 'kamar_tujuan.nomor_kamar', '-')),
                                    ];
                                @endphp
                                <tr class="transition hover:bg-brand-light/50">
                                    <td class="px-5 py-4 font-semibold text-content-main">{{ data_get($item, 'mahasiswa.nama', '-') }}</td>
                                    <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'jenis_pindah', '-') }}</td>
                                    <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'kamarAsal.nomor_kamar', data_get($item, 'kamar_asal.nomor_kamar', '-')) }}</td>
                                    <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'kamarTujuan.nomor_kamar', data_get($item, 'kamar_tujuan.nomor_kamar', '-')) }}</td>
                                    <td class="px-5 py-4"><x-admin.status-badge :status="data_get($item, 'status_approval', 'Pending')" /></td>
                                    <td class="px-5 py-4">
                                            <button
                                                type="button"
                                                class="inline-flex items-center justify-center gap-2 rounded-2xl border border-border-soft bg-bg-base px-4 py-2.5 text-sm font-semibold text-content-main transition hover:border-brand hover:bg-brand-light hover:text-brand"
                                                @click='openModal(@json($detailPayload))'
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
                @if ($pindahSource && method_exists($pindahSource, 'links'))
                    <div class="border-t border-border-soft px-5 pb-5"><x-admin.pagination :paginator="$pindahSource" /></div>
                @endif
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
            <div class="relative w-full max-w-2xl">
                <x-admin.panel title="Detail Pindah Kamar" icon="bi-info-circle">
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
                            <span class="text-content-sub">(NIM: <span x-text="detail.mahasiswa_nim"></span>)</span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Partner Tukar">
                            <span x-text="detail.partner_nama"></span>
                            <span class="text-content-sub" x-show="detail.partner_nim && detail.partner_nim !== '-'">(NIM: <span x-text="detail.partner_nim"></span>)</span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Jenis Pindah">
                            <span x-text="detail.jenis"></span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Kamar Asal">
                            <span x-text="detail.kamar_asal"></span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Kamar Tujuan">
                            <span x-text="detail.kamar_tujuan"></span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Alasan">
                            <span x-text="detail.alasan"></span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Status Partner">
                            <span x-text="detail.status_partner"></span>
                        </x-admin.detail-row>
                        <x-admin.status-badge :status="'Status'" x-text="detail.status_approval" />

                        <template x-if="detail.status_approval === 'Pending'">
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
                        <template x-if="detail.status_approval !== 'Pending'">
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
