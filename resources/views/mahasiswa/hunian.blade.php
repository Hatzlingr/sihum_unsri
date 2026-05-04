<x-mahasiswa-layout title="Informasi Hunian" page-title="Hunian" active="hunian">
    <div class="space-y-6">

        {{-- Denah Hunian --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-map"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Denah Hunian</h2>
            </div>
            <div class="p-5 sm:p-6 min-h-[300px] flex items-center justify-center bg-bg-surface">
                {{-- Kamu bisa menambahkan logika jika ada file gambar denah di tabel hunian nanti --}}
                <p class="text-content-sub text-sm">Denah untuk hunian
                    <strong>{{ $penempatan?->kamar?->hunian?->nama_hunian ?? '...' }}</strong> belum tersedia.
                </p>
            </div>
        </section>

        <div class="grid gap-6 lg:grid-cols-2">
            {{-- Data Kamar --}}
            <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm flex flex-col">
                <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                    <span
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-door-open"></i>
                    </span>
                    <h2 class="text-base font-semibold text-content-main sm:text-lg">Data Kamar</h2>
                </div>
                <div class="p-5 sm:p-6 space-y-4 flex-1">
                    <div class="flex flex-col gap-1 border-b border-border-soft pb-3">
                        <span class="text-xs text-content-sub uppercase tracking-wider">Nama Hunian</span>
                        <span
                            class="font-semibold text-content-main">{{ $penempatan?->kamar?->hunian?->nama_hunian ?? 'Belum Menghuni' }}</span>
                    </div>
                    <div class="flex flex-col gap-1 border-b border-border-soft pb-3">
                        <span class="text-xs text-content-sub uppercase tracking-wider">Nomor Kamar</span>
                        <span
                            class="font-semibold text-content-main">{{ $penempatan?->kamar?->nomor_kamar ?? '--' }}</span>
                    </div>
                    <div class="flex flex-col gap-1 border-b border-border-soft pb-3">
                        <span class="text-xs text-content-sub uppercase tracking-wider">Tipe & Kapasitas</span>
                        <span class="font-semibold text-content-main">
                            {{ $penempatan?->kamar?->hunian?->tipe ?? '--' }}
                            ({{ $penempatan?->kamar?->kapasitas ?? '0' }} Orang)
                        </span>
                    </div>
                    <div class="flex flex-col gap-1 border-b border-border-soft pb-3">
                        <span class="text-xs text-content-sub uppercase tracking-wider">Lantai</span>
                        <span class="font-semibold text-content-main">{{ $penempatan?->kamar?->lantai ?? '--' }}</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-xs text-content-sub uppercase tracking-wider">Lokasi</span>
                        <span
                            class="text-sm text-content-main">{{ $penempatan?->kamar?->hunian?->lokasi ?? '--' }}</span>
                    </div>
                </div>
            </section>

            <div class="flex flex-col gap-6">
                {{-- Status Pembayaran Bulan Ini --}}
                <section
                    class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm flex flex-col flex-1">
                    <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                            <i class="bi bi-receipt"></i>
                        </span>
                        <h2 class="text-base font-semibold text-content-main sm:text-lg">Status Pembayaran</h2>
                    </div>
                    <div class="p-5 sm:p-6 flex flex-col items-center justify-center flex-1 min-h-[160px]">
                        @if($pembayaran)
                            @php
                                $statusClasses = [
                                    'Sudah' => 'bg-green-100 text-green-700',
                                    'Menunggu' => 'bg-yellow-100 text-yellow-700',
                                    'Belum Bayar' => 'bg-red-100 text-red-700',
                                    'Ditolak' => 'bg-gray-100 text-gray-700',
                                ];
                                $class = $statusClasses[$pembayaran->status_verifikasi] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full {{ $class }} px-3 py-1 text-sm font-semibold mb-3">
                                <i class="bi bi-info-circle-fill"></i> {{ $pembayaran->status_verifikasi }}
                            </span>
                            <p class="text-sm text-content-sub text-center">
                                Tagihan periode: <br>
                                <strong>{{ \Carbon\Carbon::parse($pembayaran->periode_mulai)->format('d M') }} -
                                    {{ \Carbon\Carbon::parse($pembayaran->periode_selesai)->format('d M Y') }}</strong>
                            </p>
                        @else
                            <i class="bi bi-wallet2 text-3xl text-content-sub/30 mb-2"></i>
                            <p class="text-sm text-content-sub">Belum ada riwayat pembayaran.</p>
                        @endif
                    </div>
                </section>

                {{-- Sisa Waktu Sewa --}}
                <section
                    class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm flex flex-col flex-1">
                    <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                            <i class="bi bi-clock-history"></i>
                        </span>
                        <h2 class="text-base font-semibold text-content-main sm:text-lg">Sisa Waktu Sewa</h2>
                    </div>
                    <div class="p-5 sm:p-6 flex flex-col items-center justify-center flex-1 min-h-[160px]">
                        @if($penempatan)
                                            <div class="text-3xl font-bold text-content-main mb-1">
                                                {{ $sisaHari > 0 ? $sisaHari : 0 }}
                                                <span class="text-lg font-medium text-content-sub">Hari</span>
                                            </div>
                                            <p class="text-sm text-content-sub text-center">Sewa berakhir pada
                                                {{ \Carbon\Carbon::parse($penempatan->tgl_keluar)->translatedFormat('d F Y') }}
                                            </p>

                              @php
                                // Hitung persentase sederhana (Asumsi sewa 1 tahun / 365 hari)
                                $persen = ($sisaHari / 365) * 100;
                                $persen = max(0, min(100, $persen)); // Supaya tidak minus atau lebih dari 100
                            @endphp
                                            <div class="w-full bg-bg-surface rounded-full h-2.5 mt-4">
                                                <div class="bg-brand h-2.5 rounded-full transition-all duration-500"
                                                    style="width: {{ $persen }}%"></div>
                                            </div>
                        @else
                            <p class="text-sm text-content-sub">Data sewa tidak ditemukan.</p>
                        @endif
                    </div>
                </section>
            </div>
        </div>

        {{-- Teman Sekamar --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-people"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Teman Sekamar</h2>
            </div>
            <div class="p-5 sm:p-6 grid gap-4 md:grid-cols-2">
                @forelse($temanSekamar as $teman)
                    <div class="flex items-center gap-4 p-4 rounded-2xl border border-border-soft bg-bg-surface">
                        <div
                            class="h-12 w-12 rounded-full bg-brand-soft flex items-center justify-center text-brand text-lg overflow-hidden border border-brand/10">
                            @if($teman->foto_profil)
                                <img src="{{ asset('storage/' . $teman->foto_profil) }}" class="h-full w-full object-cover">
                            @else
                                <i class="bi bi-person-fill"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold text-content-main">{{ $teman->nama }}</h3>
                            <p class="text-xs text-content-sub">{{ $teman->prodi }}</p>
                            <p class="text-[10px] text-content-sub/70 uppercase tracking-tight">{{ $teman->nim }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-4 flex flex-col items-center justify-center opacity-60">
                        <i class="bi bi-person-dash text-2xl mb-1"></i>
                        <p class="text-sm text-content-sub italic">Belum ada teman sekamar di kamar ini.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Kritik & Saran --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-chat-left-text"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Kritik & Saran via WhatsApp</h2>
            </div>
            <div class="p-5 sm:p-6">
                <div class="space-y-4">
                    <div>
                        <textarea id="pesan_wa" rows="3"
                            class="block w-full rounded-2xl border border-border-soft bg-bg-base px-4 py-3 text-sm text-content-main focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand"
                            placeholder="Tuliskan kritik, saran, atau laporan fasilitas rusak di sini..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="kirimWA()"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 hover:-translate-y-0.5">
                            <i class="bi bi-whatsapp"></i>
                            Kirim ke WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- Script untuk Handle Pengiriman --}}
        <script>
            function kirimWA() {
                const pesan = document.getElementById('pesan_wa').value;
                const nomorAdmin = "6282256478900";

                if (pesan.trim() === "") {
                    alert("Silahkan tulis pesan terlebih dahulu.");
                    return;
                }

                // Format pesan agar rapi
                const formatPesan = encodeURIComponent(
                    `*KRITIK & SARAN HUNIAN*\n\n` +
                    `Halo Admin, saya ingin menyampaikan:\n` +
                    `"${pesan}"`
                );

                // Buka Tab Baru ke WA
                window.open(`https://wa.me/${nomorAdmin}?text=${formatPesan}`, '_blank');
            }
        </script>

    </div>
</x-mahasiswa-layout>