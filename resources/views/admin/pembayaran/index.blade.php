@php
    $pembayaranSource = $pembayaran ?? $payments ?? collect();
    $pembayaranItems = method_exists($pembayaranSource, 'items') ? collect($pembayaranSource->items()) : collect($pembayaranSource);
    $activeStatus = request('status', 'Menunggu');
    $filteredItems = $pembayaranItems->isNotEmpty()
        ? $pembayaranItems->filter(fn ($item) => request()->filled('status') ? data_get($item, 'status_verifikasi') === $activeStatus : true)
        : collect();

    $counts = $counts ?? [
        'Menunggu' => $menungguCount ?? $pembayaranItems->where('status_verifikasi', 'Menunggu')->count(),
        'Sudah' => $approvedCount ?? $pembayaranItems->where('status_verifikasi', 'Sudah')->count(),
        'Ditolak' => $rejectedCount ?? $pembayaranItems->where('status_verifikasi', 'Ditolak')->count(),
    ];

    $statusCards = [
        ['label' => 'Menunggu', 'status' => 'Menunggu', 'icon' => 'bi-hourglass-split'],
        ['label' => 'Disetujui', 'status' => 'Sudah', 'icon' => 'bi-check-circle'],
        ['label' => 'Ditolak', 'status' => 'Ditolak', 'icon' => 'bi-x-circle'],
    ];

    $safeAction = static fn (string $name, $param, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name, $param) : $fallback;
    $approveTemplate = \Illuminate\Support\Facades\Route::has('admin.pembayaran.approve')
        ? route('admin.pembayaran.approve', ['id' => '__ID__'])
        : '#';
    $rejectTemplate = \Illuminate\Support\Facades\Route::has('admin.pembayaran.reject')
        ? route('admin.pembayaran.reject', ['id' => '__ID__'])
        : '#';
@endphp

<x-admin-layout title="Verifikasi Pembayaran" page-title="Verifikasi Pembayaran" active="pembayaran">
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
                tgl_bayar: '-',
                status_verifikasi: '-',
                jenis_pembayaran: '-',
                hunian: '-',
                status_kamar: '-',
                durasi_awal: '-',
                jumlah_bayar: '0',
                bukti_url: null,
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
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Menunggu'])" :active="$activeStatus === 'Menunggu'" :count="$counts['Menunggu'] ?? 0">Menunggu</x-admin.tab-button>
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Sudah'])" :active="$activeStatus === 'Sudah'" :count="$counts['Sudah'] ?? 0">Disetujui</x-admin.tab-button>
                    <x-admin.tab-button :href="request()->fullUrlWithQuery(['status' => 'Ditolak'])" :active="$activeStatus === 'Ditolak'" :count="$counts['Ditolak'] ?? 0">Ditolak</x-admin.tab-button>
                </div>

                <div class="p-4 sm:p-5">
                    @forelse (($filteredItems->isNotEmpty() ? $filteredItems : $pembayaranItems) as $item)
                        @php
                            $id = data_get($item, 'id_bayar', data_get($item, 'id'));
                            $pendaftaran = data_get($item, 'pendaftaran');
                            $mahasiswa = data_get($pendaftaran, 'mahasiswa');
                            $nama = data_get($mahasiswa, 'nama', data_get($item, 'mahasiswa.nama', '-'));
                            $nim = data_get($mahasiswa, 'nim', data_get($item, 'mahasiswa.nim', '-'));
                            $jumlah = (float) data_get($item, 'jumlah_bayar', 0);
                            $hunian = data_get($pendaftaran, 'hunian', data_get($item, 'hunian'));
                            $buktiUrl = method_exists($item, 'getBuktiUrl')
                                ? $item->getBuktiUrl()
                                : (data_get($item, 'bukti_transfer') ? asset('storage/' . data_get($item, 'bukti_transfer')) : null);
                            $tglBayar = data_get($item, 'tgl_bayar');
                            $detailPayload = [
                                'id' => $id,
                                'nama' => $nama,
                                'nim' => $nim,
                                'prodi' => data_get($mahasiswa, 'prodi', data_get($item, 'mahasiswa.prodi', '-')),
                                'status_kipk' => data_get($mahasiswa, 'status_kipk', data_get($item, 'mahasiswa.status_kipk')) ? 'KIPK' : 'Non KIPK',
                                'tgl_bayar' => optional($tglBayar)->format('d F Y - H.i') ?? '-',
                                'status_verifikasi' => data_get($item, 'status_verifikasi', 'Menunggu'),
                                'jenis_pembayaran' => data_get($item, 'jenis_pembayaran', '-') === 'Awal'
                                    ? 'Sewa Hunian Baru'
                                    : data_get($item, 'jenis_pembayaran', '-'),
                                'hunian' => data_get($hunian, 'nama_hunian', '-'),
                                'status_kamar' => data_get($item, 'status_kamar', data_get($pendaftaran, 'penempatan.status', 'Menunggu Penempatan')),
                                'durasi_awal' => data_get($item, 'durasi_awal', data_get($item, 'durasi', '-')),
                                'jumlah_bayar' => number_format($jumlah, 0, ',', '.'),
                                'bukti_url' => $buktiUrl,
                            ];
                        @endphp
                        <button
                            type="button"
                            class="mb-3 block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-left transition last:mb-0 hover:border-brand hover:bg-brand-light"
                            @click='openModal(@json($detailPayload))'
                        >
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="font-semibold text-content-main">{{ $nama }}</h3>
                                    <p class="mt-1 text-sm text-content-sub">{{ $nim }} · Rp {{ number_format($jumlah, 0, ',', '.') }}</p>
                                </div>
                                <x-admin.status-badge :status="data_get($item, 'status_verifikasi', 'Menunggu')" />
                            </div>
                        </button>
                    @empty
                        <x-admin.skeleton-list :rows="11" height="h-12" />
                    @endforelse

                    <x-admin.pagination :paginator="$pembayaranSource" />
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
                <x-admin.panel title="Detail Pembayaran" icon="bi-receipt" padding="p-0">
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
                        <h3 class="text-2xl font-bold text-content-main" x-text="detail.nama"></h3>
                        <p class="mt-1 text-content-sub">
                            <span x-text="detail.nim"></span>
                            <span> · </span>
                            <span x-text="detail.prodi"></span>
                            <span> · </span>
                            <span x-text="detail.status_kipk"></span>
                        </p>
                        <p class="mt-2 text-sm text-content-sub">Dikirim pada <span x-text="detail.tgl_bayar"></span> WIB</p>
                        <div class="mt-3">
                            <x-admin.status-badge :status="'Status'" x-text="detail.status_verifikasi" />
                        </div>
                    </div>

                    <div class="grid gap-5 border-y border-border-soft p-5 sm:p-6">
                        <x-admin.detail-row label="Tipe Transaksi">
                            <span x-text="detail.jenis_pembayaran"></span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Hunian Dipilih">
                            <span x-text="detail.hunian"></span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Status Kamar">
                            <span x-text="detail.status_kamar"></span>
                        </x-admin.detail-row>
                        <x-admin.detail-row label="Durasi Awal">
                            <span x-text="detail.durasi_awal"></span>
                        </x-admin.detail-row>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Total Tagihan</p>
                            <p class="mt-1 text-2xl font-bold text-content-main">Rp <span x-text="detail.jumlah_bayar"></span></p>
                        </div>
                    </div>

                    <div class="border-b border-border-soft p-5 sm:p-6">
                        <p class="mb-4 text-sm font-semibold text-content-main">Bukti Transfer</p>
                        <template x-if="detail.bukti_url">
                            <a
                                :href="detail.bukti_url"
                                target="_blank"
                                class="mx-auto flex aspect-4/3 max-w-64 items-center justify-center overflow-hidden rounded-3xl border border-border-soft bg-bg-surface transition hover:border-brand hover:bg-brand-light"
                            >
                                <img :src="detail.bukti_url" alt="Bukti transfer" class="h-full w-full object-cover">
                            </a>
                        </template>
                        <template x-if="!detail.bukti_url">
                            <div class="mx-auto flex aspect-4/3 max-w-64 items-center justify-center rounded-3xl bg-content-sub/25 text-content-sub">
                                <i class="bi bi-image text-4xl"></i>
                            </div>
                        </template>
                    </div>

                    <div class="flex flex-col gap-3 p-5 sm:flex-row sm:justify-center sm:p-6">
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
