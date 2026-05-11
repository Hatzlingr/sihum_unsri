@php
    $reportCards = $reportCards ?? [
        ['label' => 'Total Penghuni', 'value' => $totalPenghuni ?? 0, 'icon' => 'bi-people'],
        ['label' => 'Pendapatan Bulan Ini', 'value' => 'Rp ' . number_format((float) ($pendapatanBulanIni ?? 0), 0, ',', '.'), 'icon' => 'bi-cash-stack'],
        ['label' => 'Pendaftaran Disetujui', 'value' => $pendaftaranDisetujui ?? 0, 'icon' => 'bi-check-circle'],
        ['label' => 'Kamar Tersedia', 'value' => $kamarTersedia ?? 0, 'icon' => 'bi-door-open'],
    ];

    // TODO(back-end): Provide $nunggakPenempatan as paginator/collection with fields:
    // - mahasiswa.nama, mahasiswa.nim
    // - kamar.hunian.nama_hunian, kamar.nomor_kamar
    // - tgl_keluar (date), status
    // Optional: $cutoffDate for the cutoff info text below.
    $nunggakSource = $nunggakPenempatan ?? collect();
    $nunggakItems = method_exists($nunggakSource, 'items') ? collect($nunggakSource->items()) : collect($nunggakSource);
    $cutoffDate = $cutoffDate ?? null;
@endphp

<x-admin-layout title="Laporan" page-title="Laporan" active="laporan">
    <div class="space-y-6">
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($reportCards as $card)
                <x-admin.stat-card :label="$card['label']" :value="$card['value']" :icon="$card['icon']" />
            @endforeach
        </section>

        <x-admin.panel title="Ringkasan Laporan" icon="bi-clipboard-data">
            <div class="grid gap-4 lg:grid-cols-2">
                <div class="rounded-3xl border border-border-soft bg-bg-surface p-5 flex flex-col h-full">
                    <h3 class="font-semibold text-content-main">Laporan Hunian</h3>
                    <p class="mt-2 text-sm text-content-sub mb-5">Gunakan area ini untuk rekap okupansi dan kapasitas hunian.</p>
                    <div class="overflow-x-auto flex-grow">
                        <table class="min-w-full text-left text-sm">
                            <thead class="border-b border-border-soft text-xs text-content-sub uppercase tracking-wide">
                                <tr>
                                    <th class="py-3 px-2">Hunian</th>
                                    <th class="py-3 px-2 text-center">Kamar</th>
                                    <th class="py-3 px-2 text-center">Kapasitas</th>
                                    <th class="py-3 px-2 text-center">Terisi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-soft">
                                @forelse($hunianStats ?? [] as $hunian)
                                    <tr>
                                        <td class="py-3 px-2 font-medium text-content-main">{{ $hunian->nama_hunian }}</td>
                                        <td class="py-3 px-2 text-center text-content-sub">{{ $hunian->total_kamar }}</td>
                                        <td class="py-3 px-2 text-center text-content-sub">{{ $hunian->kapasitas }}</td>
                                        <td class="py-3 px-2 text-center">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-lg {{ $hunian->terisi >= $hunian->kapasitas ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                {{ $hunian->terisi }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="py-3 text-center text-content-sub">Data tidak tersedia</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="rounded-3xl border border-border-soft bg-bg-surface p-5 flex flex-col h-full">
                    <h3 class="font-semibold text-content-main">Laporan Pembayaran</h3>
                    <p class="mt-2 text-sm text-content-sub mb-5">Rekapitulasi jumlah transaksi dan total nominal berdasarkan status.</p>
                    <div class="overflow-x-auto flex-grow">
                        <table class="min-w-full text-left text-sm">
                            <thead class="border-b border-border-soft text-xs text-content-sub uppercase tracking-wide">
                                <tr>
                                    <th class="py-3 px-2">Status</th>
                                    <th class="py-3 px-2 text-center">Jumlah Transaksi</th>
                                    <th class="py-3 px-2 text-right">Total Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-soft">
                                @forelse($pembayaranStats ?? [] as $stat)
                                    <tr>
                                        <td class="py-3 px-2">
                                            <x-admin.status-badge :status="$stat->status_verifikasi" />
                                        </td>
                                        <td class="py-3 px-2 text-center text-content-sub">{{ $stat->count }}</td>
                                        <td class="py-3 px-2 text-right font-medium text-content-main">Rp {{ number_format($stat->total, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="py-3 text-center text-content-sub">Data tidak tersedia</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </x-admin.panel>

        <x-admin.panel title="Keterlambatan Perpanjangan Masa Tinggal" icon="bi-exclamation-triangle">
            <div class="flex flex-col gap-2 text-sm text-content-sub">
                <p>
                    Menampilkan penghuni yang masa tinggalnya telah berakhir dan belum ada pengajuan
                    perpanjangan, pemberhentian, atau pembayaran setelahnya.
                </p>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-border-soft text-xs uppercase tracking-wide text-content-sub">
                        <tr>
                            <th class="py-3 px-2">Mahasiswa</th>
                            <th class="py-3 px-2">NIM</th>
                            <th class="py-3 px-2">Hunian / Kamar</th>
                            <th class="py-3 px-2">Periode Akhir</th>
                            <th class="py-3 px-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-soft">
                        @forelse ($nunggakItems as $item)
                            @php
                                $mahasiswa = data_get($item, 'mahasiswa', data_get($item, 'pendaftaran.mahasiswa'));
                                $hunian = data_get($item, 'kamar.hunian');
                                $kamar = data_get($item, 'kamar');
                            @endphp
                            <tr>
                                <td class="py-3 px-2 font-semibold text-content-main">{{ data_get($mahasiswa, 'nama', '-') }}</td>
                                <td class="py-3 px-2 text-content-sub">{{ data_get($mahasiswa, 'nim', '-') }}</td>
                                <td class="py-3 px-2 text-content-sub">
                                    {{ data_get($hunian, 'nama_hunian', '-') }}
                                    <span class="text-content-sub">·</span>
                                    {{ data_get($kamar, 'nomor_kamar', '-') }}
                                </td>
                                <td class="py-3 px-2 text-content-sub">{{ optional(data_get($item, 'tgl_keluar'))->format('d M Y') ?? '-' }}</td>
                                <td class="py-3 px-2">
                                    <x-admin.status-badge :status="data_get($item, 'status', '-')" />
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-4 text-center text-content-sub">Tidak ada data keterlambatan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-admin.panel>
    </div>
</x-admin-layout>
