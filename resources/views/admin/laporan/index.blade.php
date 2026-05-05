@php
    $reportCards = $reportCards ?? [
        ['label' => 'Total Penghuni', 'value' => $totalPenghuni ?? 0, 'icon' => 'bi-people'],
        ['label' => 'Pendapatan Bulan Ini', 'value' => 'Rp ' . number_format((float) ($pendapatanBulanIni ?? 0), 0, ',', '.'), 'icon' => 'bi-cash-stack'],
        ['label' => 'Pendaftaran Disetujui', 'value' => $pendaftaranDisetujui ?? 0, 'icon' => 'bi-check-circle'],
        ['label' => 'Kamar Tersedia', 'value' => $kamarTersedia ?? 0, 'icon' => 'bi-door-open'],
    ];
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
    </div>
</x-admin-layout>
