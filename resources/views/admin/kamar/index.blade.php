@php
    $kamarSource = $kamars ?? $kamar ?? collect();
    $kamarItems = method_exists($kamarSource, 'items') ? collect($kamarSource->items()) : collect($kamarSource);
    $safeRoute = static fn (string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
    $safeRouteWithParam = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : url($fallback);
@endphp

<x-admin-layout title="Manajemen Kamar" page-title="Manajemen Kamar" active="kamar">
    <div
        x-data="{
            modalOpen: false,
            detail: {
                hunian: '-',
                nomor: '-',
                lantai: '-',
                kapasitas: 0,
                terisi: 0,
                status: '-',
                penghuni: [],
            },
            openModal(payload) {
                this.detail = { ...this.detail, ...payload };
                this.modalOpen = true;
            },
            closeModal() {
                this.modalOpen = false;
            },
        }"
        class="space-y-6"
        @keydown.escape.window="closeModal()"
    >
        <x-admin.search-bar placeholder="Cari Kamar atau Hunian">
            <x-admin.action-button variant="secondary" icon="bi-funnel">Filter</x-admin.action-button>
            <x-admin.action-button :href="$safeRoute('admin.kamar.create', '/admin/kamar/create')" icon="bi-plus-lg">Tambah Kamar</x-admin.action-button>
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
                            @php
                                $id = data_get($item, 'id_kamar', data_get($item, 'id'));
                                $penghuniPayload = collect(data_get($item, 'penempatan', []))
                                    ->map(function ($penempatan) {
                                        $mahasiswa = data_get($penempatan, 'pendaftaran.mahasiswa');

                                        return [
                                            'nama' => data_get($mahasiswa, 'nama', '-'),
                                            'nim' => data_get($mahasiswa, 'nim', '-'),
                                            'prodi' => data_get($mahasiswa, 'prodi', '-'),
                                            'status_kipk' => data_get($mahasiswa, 'status_kipk') ? 'KIPK' : 'Non KIPK',
                                            'tgl_masuk' => optional(data_get($penempatan, 'tgl_masuk'))->format('d M Y') ?? '-',
                                            'tgl_keluar' => optional(data_get($penempatan, 'tgl_keluar'))->format('d M Y') ?? '-',
                                        ];
                                    })
                                    ->values()
                                    ->all();
                                $detailPayload = [
                                    'hunian' => data_get($item, 'hunian.nama_hunian', '-'),
                                    'nomor' => data_get($item, 'nomor_kamar', '-'),
                                    'lantai' => data_get($item, 'lantai', '-'),
                                    'kapasitas' => (int) data_get($item, 'kapasitas', 0),
                                    'terisi' => (int) data_get($item, 'terisi', 0),
                                    'status' => data_get($item, 'status', '-'),
                                    'penghuni' => $penghuniPayload,
                                ];
                            @endphp
                            <tr class="transition hover:bg-brand-light/50">
                                <td class="px-5 py-4 font-semibold text-content-main">{{ data_get($item, 'hunian.nama_hunian', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'nomor_kamar', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'lantai', '-') }}</td>
                                <td class="px-5 py-4 text-content-sub">{{ data_get($item, 'terisi', 0) }}/{{ data_get($item, 'kapasitas', 0) }}</td>
                                <td class="px-5 py-4 text-content-sub">Rp {{ number_format((float) data_get($item, 'harga_sewa', 0), 0, ',', '.') }}</td>
                                <td class="px-5 py-4"><x-admin.status-badge :status="data_get($item, 'status', '-')" /></td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <button
                                            type="button"
                                            class="inline-flex items-center justify-center gap-2 rounded-2xl border border-border-soft bg-bg-base px-4 py-2.5 text-sm font-semibold text-content-main transition hover:border-brand hover:bg-brand-light hover:text-brand"
                                            @click='openModal(@json($detailPayload))'
                                        >
                                            <i class="bi bi-eye"></i>
                                            Detail
                                        </button>
                                        <x-admin.action-button :href="$safeRouteWithParam('admin.kamar.edit', $id, '/admin/kamar/' . $id . '/edit')" variant="secondary" icon="bi-pencil-square">Kelola</x-admin.action-button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-6"><x-admin.skeleton-list :rows="8" height="h-11" /></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-border-soft px-5 pb-5"><x-admin.pagination :paginator="$kamarSource" /></div>
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
            <div class="relative w-full max-w-3xl">
                <x-admin.panel title="Detail Penghuni Kamar" icon="bi-people" padding="p-0">
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
                        <h3 class="text-2xl font-bold text-content-main">
                            <span x-text="detail.hunian"></span>
                            <span>·</span>
                            <span>Kamar</span>
                            <span x-text="detail.nomor"></span>
                        </h3>
                        <p class="mt-2 text-sm text-content-sub">
                            Lantai <span x-text="detail.lantai"></span>
                            <span> · </span>
                            <span x-text="detail.terisi"></span>/<span x-text="detail.kapasitas"></span> penghuni
                            <span> · </span>
                            <span x-text="detail.status"></span>
                        </p>
                    </div>

                    <div class="border-t border-border-soft p-5 sm:p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm">
                                <thead class="border-b border-border-soft text-xs uppercase tracking-wide text-content-sub">
                                    <tr>
                                        <th class="py-3 px-2">Nama</th>
                                        <th class="py-3 px-2">NIM</th>
                                        <th class="py-3 px-2">Prodi</th>
                                        <th class="py-3 px-2">KIPK</th>
                                        <th class="py-3 px-2">Masuk</th>
                                        <th class="py-3 px-2">Keluar</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border-soft">
                                    <template x-for="penghuni in detail.penghuni" :key="penghuni.nim + penghuni.nama">
                                        <tr>
                                            <td class="py-3 px-2 font-semibold text-content-main" x-text="penghuni.nama"></td>
                                            <td class="py-3 px-2 text-content-sub" x-text="penghuni.nim"></td>
                                            <td class="py-3 px-2 text-content-sub" x-text="penghuni.prodi"></td>
                                            <td class="py-3 px-2"><x-admin.status-badge :status="'KIPK'" x-text="penghuni.status_kipk" /></td>
                                            <td class="py-3 px-2 text-content-sub" x-text="penghuni.tgl_masuk"></td>
                                            <td class="py-3 px-2 text-content-sub" x-text="penghuni.tgl_keluar"></td>
                                        </tr>
                                    </template>
                                    <template x-if="detail.penghuni.length === 0">
                                        <tr>
                                            <td colspan="6" class="py-4 text-center text-content-sub">Belum ada penghuni aktif.</td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-admin.action-button type="button" variant="secondary" icon="bi-x-lg" @click="closeModal()">Tutup</x-admin.action-button>
                        </div>
                    </div>
                </x-admin.panel>
            </div>
        </div>
    </div>
</x-admin-layout>
