<x-mahasiswa-layout title="Pembayaran" page-title="Pembayaran" active="pembayaran">
    <div class="space-y-6">

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="flex items-center gap-3 p-4 text-sm text-green-600 rounded-2xl bg-green-50 border border-green-200 animate-in fade-in slide-in-from-top-4 duration-300">
                <i class="bi bi-check-circle-fill"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Grid Utama --}}
        <div class="grid gap-6 lg:grid-cols-3">
            
            {{-- KOLOM KIRI: Info & Riwayat (2/3) --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Card Tagihan Aktif --}}
                <div class="grid gap-4 sm:grid-cols-2">
                    <article class="rounded-3xl border border-border-soft bg-bg-base p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                                <i class="bi bi-wallet2 text-xl"></i>
                            </span>
                            @if($tagihanAktif)
                                <span class="px-3 py-1 rounded-full bg-brand/10 text-brand text-[10px] font-bold uppercase tracking-wider">
                                    {{ $tagihanAktif->jenis_pembayaran }}
                                </span>
                            @endif
                        </div>
                        <p class="text-sm font-medium text-content-sub">Tagihan Saat Ini</p>
                        <h3 class="text-2xl font-bold text-content-main mt-1">
                            Rp {{ $tagihanAktif ? number_format($tagihanAktif->jumlah_bayar, 0, ',', '.') : '0' }}
                        </h3>
                        @if($tagihanAktif)
                            <p class="mt-4 text-xs text-content-sub flex items-center gap-2">
                                <i class="bi bi-calendar3"></i>
                                {{ $tagihanAktif->periode_mulai->translatedFormat('d M') }} - {{ $tagihanAktif->periode_selesai->translatedFormat('d M Y') }}
                            </p>
                        @endif
                    </article>

                    <article class="rounded-3xl border border-border-soft bg-bg-base p-6 shadow-sm">
                        <p class="text-sm font-medium text-content-sub mb-4">Status Verifikasi</p>
                        @if($tagihanAktif)
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl font-bold text-sm
                                {{ $tagihanAktif->status_verifikasi == 'Menunggu' ? 'bg-amber-50 text-amber-600 border border-amber-200' : 
                                   ($tagihanAktif->status_verifikasi == 'Ditolak' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-gray-50 text-content-sub border border-border-soft') }}">
                                <span class="relative flex h-2 w-2">
                                    @if($tagihanAktif->status_verifikasi == 'Menunggu')
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    @endif
                                    <span class="relative inline-flex rounded-full h-2 w-2 {{ $tagihanAktif->status_verifikasi == 'Menunggu' ? 'bg-amber-500' : ($tagihanAktif->status_verifikasi == 'Ditolak' ? 'bg-red-500' : 'bg-gray-400') }}"></span>
                                </span>
                                {{ $tagihanAktif->status_verifikasi }}
                            </div>
                            @if($tagihanAktif->catatan_admin)
                                <p class="mt-3 text-xs text-red-500 italic leading-relaxed">
                                    *{{ $tagihanAktif->catatan_admin }}
                                </p>
                            @endif
                        @else
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-green-50 text-green-600 border border-green-200 font-bold text-sm">
                                <i class="bi bi-shield-check"></i> Semua Lunas
                            </div>
                        @endif
                    </article>
                </div>

                {{-- Tabel Riwayat --}}
                <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
                    <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-soft text-brand text-sm">
                            <i class="bi bi-clock-history"></i>
                        </span>
                        <h2 class="font-bold text-content-main">Riwayat Pembayaran</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-bg-surface text-[11px] uppercase tracking-wider text-content-sub font-bold">
                                    <th class="px-6 py-4">Periode</th>
                                    <th class="px-6 py-4">Tanggal Bayar</th>
                                    <th class="px-6 py-4">Nominal</th>
                                    <th class="px-6 py-4 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-soft">
                                @forelse($riwayat as $item)
                                <tr class="group text-sm hover:bg-bg-surface transition-colors">
                                    <td class="px-6 py-4 font-semibold text-content-main">{{ $item->periode_mulai->translatedFormat('F Y') }}</td>
                                    <td class="px-6 py-4 text-content-sub">{{ $item->tgl_bayar?->translatedFormat('d M Y') ?? '-' }}</td>
                                    <td class="px-6 py-4 font-bold text-content-main">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex px-2 py-1 rounded-lg bg-green-100 text-green-700 text-[10px] font-bold">LUNAS</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <p class="text-sm text-content-sub italic">Belum ada catatan riwayat pembayaran.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            {{-- KOLOM KANAN: Upload (1/3) --}}
            <div class="lg:col-span-1">
                <section class="sticky top-6 rounded-3xl border border-border-soft bg-bg-base shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-border-soft bg-bg-surface">
                        <h2 class="font-bold text-content-main">Konfirmasi Bayar</h2>
                        <p class="text-xs text-content-sub mt-1 text-pretty">Kirimkan bukti transfer untuk divalidasi admin.</p>
                    </div>
                    
                    <div class="p-6">
                        @if($tagihanAktif && $tagihanAktif->status_verifikasi != 'Menunggu')
                            <form action="{{ route('mahasiswa.pembayaran.upload', $tagihanAktif->id_bayar) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                
                                <div class="relative group">
                                    <label class="flex flex-col items-center justify-center w-full h-56 border-2 border-dashed border-border-soft rounded-3xl bg-bg-surface cursor-pointer group-hover:border-brand/40 group-hover:bg-brand/5 transition-all">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <div class="p-4 rounded-2xl bg-white shadow-sm mb-4 group-hover:scale-110 transition-transform">
                                                <i class="bi bi-cloud-arrow-up text-3xl text-brand"></i>
                                            </div>
                                            <p class="text-sm font-bold text-content-main">Pilih File Bukti</p>
                                            <p class="text-[11px] text-content-sub mt-1">PNG, JPG, JPEG (Maks. 2MB)</p>
                                        </div>
                                        <input id="bukti_transfer" name="bukti_transfer" type="file" class="hidden" required />
                                    </label>
                                </div>

                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-brand hover:bg-brand-hover text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-brand/20 active:scale-[0.98]">
                                    <i class="bi bi-send-check"></i>
                                    Kirim Bukti
                                </button>
                            </form>
                        @else
                            <div class="text-center py-12 px-4 rounded-3xl bg-bg-surface border border-border-soft border-dashed">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4">
                                    <i class="bi bi-shield-lock text-2xl text-content-sub"></i>
                                </div>
                                <h4 class="text-sm font-bold text-content-main uppercase tracking-tight">Form Terkunci</h4>
                                <p class="text-[11px] text-content-sub mt-2 leading-relaxed">
                                    {{ $tagihanAktif && $tagihanAktif->status_verifikasi == 'Menunggu' 
                                        ? 'Sabar ya, bukti transfer kamu sedang dicek sama admin.' 
                                        : 'Kamu belum punya tagihan baru yang perlu dibayar.' }}
                                </p>
                            </div>
                        @endif

                        <div class="mt-6 p-4 rounded-2xl bg-blue-50 border border-blue-100 space-y-2">
                            <h4 class="text-[10px] font-bold text-blue-700 uppercase tracking-widest flex items-center gap-2">
                                <i class="bi bi-info-circle-fill"></i> Instruksi
                            </h4>
                            <p class="text-[11px] text-blue-600 leading-relaxed">
                                Mohon gunakan nominal yang tepat hingga digit terakhir agar proses verifikasi lebih cepat.
                            </p>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
</x-mahasiswa-layout>