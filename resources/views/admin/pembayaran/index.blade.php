@php
    $pembayaranSource = $pembayaran ?? $payments ?? collect();
    $pembayaranItems = method_exists($pembayaranSource, 'items') ? collect($pembayaranSource->items()) : collect($pembayaranSource);
    $activeStatus = request('status', 'Menunggu');
    $filteredItems = $pembayaranItems->isNotEmpty()
        ? $pembayaranItems->filter(fn ($item) => request()->filled('status') ? data_get($item, 'status_verifikasi') === $activeStatus : true)
        : collect();
    $selected = $selectedPembayaran ?? $filteredItems->first() ?? $pembayaranItems->first();

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
@endphp

<x-admin-layout title="Verifikasi Pembayaran" page-title="Verifikasi Pembayaran" active="pembayaran">
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

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_460px]">
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
                        @endphp
                        <a href="{{ request()->fullUrlWithQuery(['selected' => $id]) }}" class="mb-3 block rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 transition last:mb-0 hover:border-brand hover:bg-brand-light">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="font-semibold text-content-main">{{ $nama }}</h3>
                                    <p class="mt-1 text-sm text-content-sub">{{ $nim }} · Rp {{ number_format($jumlah, 0, ',', '.') }}</p>
                                </div>
                                <x-admin.status-badge :status="data_get($item, 'status_verifikasi', 'Menunggu')" />
                            </div>
                        </a>
                    @empty
                        <x-admin.skeleton-list :rows="11" height="h-12" />
                    @endforelse

                    <x-admin.pagination :paginator="$pembayaranSource" />
                </div>
            </x-admin.panel>

            <x-admin.panel title="Detail Pembayaran" icon="bi-receipt" padding="p-0">
                @if ($selected)
                    @php
                        $selectedId = data_get($selected, 'id_bayar', data_get($selected, 'id', 0));
                        $pendaftaran = data_get($selected, 'pendaftaran');
                        $mahasiswa = data_get($pendaftaran, 'mahasiswa', data_get($selected, 'mahasiswa'));
                        $hunian = data_get($pendaftaran, 'hunian', data_get($selected, 'hunian'));
                        $buktiUrl = method_exists($selected, 'getBuktiUrl') ? $selected->getBuktiUrl() : (data_get($selected, 'bukti_transfer') ? asset('storage/' . data_get($selected, 'bukti_transfer')) : null);
                        $tglBayar = data_get($selected, 'tgl_bayar');
                    @endphp
                    <div class="p-5 sm:p-6">
                        <h3 class="text-2xl font-bold text-content-main">{{ data_get($mahasiswa, 'nama', '-') }}</h3>
                        <p class="mt-1 text-content-sub">{{ data_get($mahasiswa, 'nim', '-') }} · {{ data_get($mahasiswa, 'prodi', '-') }} · {{ data_get($mahasiswa, 'status_kipk') ? 'KIPK' : 'Non KIPK' }}</p>
                        <p class="mt-2 text-sm text-content-sub">Dikirim pada {{ optional($tglBayar)->format('d F Y - H.i') ?? '-' }} WIB</p>
                        <x-admin.status-badge :status="data_get($selected, 'status_verifikasi', 'Menunggu')" class="mt-3" />
                    </div>

                    <div class="grid gap-5 border-y border-border-soft p-5 sm:p-6">
                        <x-admin.detail-row label="Tipe Transaksi" :value="data_get($selected, 'jenis_pembayaran', '-') === 'Awal' ? 'Sewa Hunian Baru' : data_get($selected, 'jenis_pembayaran', '-')" />
                        <x-admin.detail-row label="Hunian Dipilih" :value="data_get($hunian, 'nama_hunian', '-')" />
                        <x-admin.detail-row label="Status Kamar" :value="data_get($selected, 'status_kamar', data_get($pendaftaran, 'penempatan.status', 'Menunggu Penempatan'))" />
                        <x-admin.detail-row label="Durasi Awal" :value="$durasiAwal ?? '-'" />
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-content-sub">Total Tagihan</p>
                            <p class="mt-1 text-2xl font-bold text-content-main">Rp {{ number_format((float) data_get($selected, 'jumlah_bayar', 0), 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="border-b border-border-soft p-5 sm:p-6">
                        <p class="mb-4 text-sm font-semibold text-content-main">Bukti Transfer</p>
                        @if ($buktiUrl)
                            <a href="{{ $buktiUrl }}" target="_blank" class="mx-auto flex aspect-[4/3] max-w-64 items-center justify-center overflow-hidden rounded-3xl border border-border-soft bg-bg-surface transition hover:border-brand hover:bg-brand-light">
                                <img src="{{ $buktiUrl }}" alt="Bukti transfer" class="h-full w-full object-cover">
                            </a>
                        @else
                            <div class="mx-auto flex aspect-[4/3] max-w-64 items-center justify-center rounded-3xl bg-content-sub/25 text-content-sub">
                                <i class="bi bi-image text-4xl"></i>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col gap-3 p-5 sm:flex-row sm:justify-center sm:p-6">
                        <form method="POST" action="{{ $safeAction('admin.pembayaran.approve', $selectedId, '#') }}">
                            @csrf
                            @method('PATCH')
                            <x-admin.action-button type="submit" icon="bi-check-lg">Setujui</x-admin.action-button>
                        </form>
                        <form method="POST" action="{{ $safeAction('admin.pembayaran.reject', $selectedId, '#') }}">
                            @csrf
                            @method('PATCH')
                            <x-admin.action-button type="submit" variant="danger" icon="bi-x-lg">Tolak</x-admin.action-button>
                        </form>
                    </div>
                @else
                    <div class="p-5 sm:p-6">
                        <x-admin.skeleton-list :rows="5" height="h-11" />
                    </div>
                    <div class="border-y border-border-soft p-5 sm:p-6">
                        <x-admin.skeleton-list :rows="4" height="h-10" />
                    </div>
                    <div class="p-5 sm:p-6">
                        <div class="mx-auto h-64 max-w-64 rounded-3xl bg-content-sub/25"></div>
                    </div>
                    <div class="flex justify-center gap-3 border-t border-border-soft p-5 sm:p-6">
                        <x-admin.action-button variant="secondary">Setujui</x-admin.action-button>
                        <x-admin.action-button variant="secondary">Tolak</x-admin.action-button>
                    </div>
                @endif
            </x-admin.panel>
        </section>
    </div>
</x-admin-layout>
