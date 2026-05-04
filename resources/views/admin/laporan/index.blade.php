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
                <div class="rounded-3xl border border-border-soft bg-bg-surface p-5">
                    <h3 class="font-semibold text-content-main">Laporan Hunian</h3>
                    <p class="mt-2 text-sm text-content-sub">Gunakan area ini untuk grafik okupansi, rekap kamar, dan performa hunian.</p>
                    <div class="mt-5"><x-admin.skeleton-list :rows="5" height="h-9" /></div>
                </div>
                <div class="rounded-3xl border border-border-soft bg-bg-surface p-5">
                    <h3 class="font-semibold text-content-main">Laporan Pembayaran</h3>
                    <p class="mt-2 text-sm text-content-sub">Gunakan area ini untuk rekap pembayaran masuk, tertunda, dan ditolak.</p>
                    <div class="mt-5"><x-admin.skeleton-list :rows="5" height="h-9" /></div>
                </div>
            </div>
        </x-admin.panel>
    </div>
</x-admin-layout>
