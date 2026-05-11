<x-mahasiswa-layout title="Pengajuan Hunian" page-title="Pengajuan" active="pengajuan">
    @php
        // CEK: Apakah mahasiswa sudah ada penempatan kamar yang AKTIF?
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;
        
        // Ambil penempatan AKTIF
        $penempatan_aktif = \App\Models\Penempatan::whereHas('pendaftaran', function($q) use ($mahasiswa) {
            $q->where('mahasiswa_id', $mahasiswa->id_mahasiswa);
        })->where('status', 'Aktif')->first();
        
        // Jika ada penempatan aktif, cek pengajuan perpanjangan terakhir
        $perpanjangan_terakhir = null;
        if ($penempatan_aktif) {
            $perpanjangan_terakhir = \App\Models\Perpanjangan::where('penempatan_id', $penempatan_aktif->id_penempatan)
                ->latest('tgl_ajuan')
                ->first();
        }
        
        // Ambil riwayat pendaftaran
        $riwayat = \App\Models\Pendaftaran::where('mahasiswa_id', $mahasiswa->id_mahasiswa)
            ->with('hunian')
            ->latest('tgl_pengajuan')
            ->get();
    @endphp

    <div class="space-y-6" x-data="{ 
        tab: '{{ $penempatan_aktif ? 'perpanjangan' : 'pendaftaran' }}',
        hargaPerBulan: 0,
        durasi: 6,
        get totalHarga() {
            return this.hargaPerBulan * this.durasi;
        },
        formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR', 
                maximumFractionDigits: 0 
            }).format(number);
        }
    }">

        {{-- Form Area --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex p-4 border-b border-border-soft gap-4 bg-bg-surface/50">
                {{-- TAB PENDAFTARAN --}}
                <button @click="tab = 'pendaftaran'"
                    @if($penempatan_aktif) disabled @endif
                    :class="tab === 'pendaftaran' 
                        ? 'bg-brand text-white shadow-md shadow-brand/20' 
                        : 'bg-bg-surface text-content-sub'"
                    :disabled="{{ $penempatan_aktif ? 'true' : 'false' }}"
                    class="flex-1 py-3 px-4 rounded-2xl text-sm font-bold text-center transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    Pendaftaran
                </button>

                {{-- TAB PERPANJANGAN --}}
                <button @click="tab = 'perpanjangan'"
                    @if(!$penempatan_aktif) disabled @endif
                    :class="tab === 'perpanjangan' 
                        ? 'bg-brand text-white shadow-md shadow-brand/20' 
                        : 'bg-bg-surface text-content-sub'"
                    :disabled="{{ !$penempatan_aktif ? 'true' : 'false' }}"
                    class="flex-1 py-3 px-4 rounded-2xl text-sm font-bold text-center transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    Perpanjangan
                </button>
            </div>

            <div class="p-5 sm:p-8 lg:p-10">
                {{-- ALERT: Belum ada penempatan (hanya tab pendaftaran bisa diakses) --}}
                @if(!$penempatan_aktif)
                    <div class="mb-8 flex items-center gap-3 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-blue-800">
                        <i class="bi bi-info-circle-fill text-xl"></i>
                        <p class="text-sm font-medium">Anda belum memiliki hunian. Silakan ajukan pendaftaran untuk memulai proses.</p>
                    </div>
                @endif

                {{-- ALERT: Ada penempatan aktif (perpanjangan bisa diakses) --}}
                @if($penempatan_aktif)
                    <div class="mb-8 flex items-center gap-3 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-800">
                        <i class="bi bi-house-check-fill text-xl"></i>
                        <div>
                            <p class="text-sm font-semibold">Anda Memiliki Hunian Aktif ✓</p>
                            <p class="text-xs mt-1">
                                Hunian: <span class="font-bold">{{ $penempatan_aktif->kamar->hunian->nama_hunian }}</span> | 
                                Kamar: <span class="font-bold">{{ $penempatan_aktif->kamar->nomor_kamar }}</span>
                            </p>
                        </div>
                    </div>
                @endif

                {{-- ALERT: Pengajuan sedang pending (baik pendaftaran atau perpanjangan) --}}
                @if($penempatan_aktif && $perpanjangan_terakhir && $perpanjangan_terakhir->status == 'Pending')
                    <div class="mb-8 flex items-center gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-amber-800">
                        <i class="bi bi-hourglass-split text-xl"></i>
                        <p class="text-sm font-medium">Pengajuan perpanjangan Anda sedang dalam proses verifikasi dokumen. Harap tunggu keputusan admin.</p>
                    </div>
                @elseif(!$penempatan_aktif && $riwayat->where('status_seleksi', 'Pending')->first())
                    <div class="mb-8 flex items-center gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-amber-800">
                        <i class="bi bi-hourglass-split text-xl"></i>
                        <p class="text-sm font-medium">Pengajuan pendaftaran Anda sedang dalam proses verifikasi dokumen. Harap tunggu keputusan admin.</p>
                    </div>
                @endif

                {{-- ALERT: Pengajuan ditolak --}}
                @if($penempatan_aktif && $perpanjangan_terakhir && $perpanjangan_terakhir->status == 'Ditolak')
                    <div class="mb-8 flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800">
                        <i class="bi bi-exclamation-circle-fill text-xl"></i>
                        <div>
                            <p class="text-sm font-semibold">Pengajuan Perpanjangan Ditolak</p>
                            <p class="text-xs mt-1">Silakan perbaiki dokumen dan ajukan kembali.</p>
                        </div>
                    </div>
                @elseif(!$penempatan_aktif && $riwayat->where('status_seleksi', 'Ditolak')->first())
                    <div class="mb-8 flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800">
                        <i class="bi bi-exclamation-circle-fill text-xl"></i>
                        <div>
                            <p class="text-sm font-semibold">Pengajuan Pendaftaran Ditolak</p>
                            <p class="text-xs mt-1">{{ $riwayat->where('status_seleksi', 'Ditolak')->first()?->catatan_admin ?? 'Silakan perbaiki dokumen dan ajukan kembali.' }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('mahasiswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data"
                    class="max-w-4xl mx-auto space-y-8">
                    @csrf

                    <div class="space-y-6">
                        {{-- INPUT JENIS HUNIAN - HANYA UNTUK PENDAFTARAN BARU --}}
                        <template x-if="tab === 'pendaftaran'">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
                                <label for="hunian_id" class="text-sm font-semibold text-content-main md:pt-3">Pilih Hunian</label>
                                <div class="md:col-span-2">
                                    <select id="hunian_id" name="hunian_id" required
                                        @change="hargaPerBulan = $el.options[$el.selectedIndex].getAttribute('data-harga') || 0"
                                        class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm focus:ring-1 focus:ring-brand focus:outline-none">
                                        <option value="">-- Pilih Jenis Hunian --</option>
                                        @foreach(\App\Models\Hunian::with('kamar')->get() as $h)
                                            <option value="{{ $h->id_hunian }}"
                                                data-harga="{{ $h->kamar->where('status', 'Tersedia')->min('harga_sewa') ?? 0 }}">
                                                {{ $h->nama_hunian }} ({{ $h->tipe }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </template>

                        {{-- INFO HUNIAN AKTIF - HANYA UNTUK PERPANJANGAN --}}
                        <template x-if="tab === 'perpanjangan'">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
                                <label class="text-sm font-semibold text-content-main md:pt-3">Hunian Anda</label>
                                <div class="md:col-span-2">
                                    <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200">
                                        <h4 class="font-bold text-blue-900">{{ $penempatan_aktif?->kamar->hunian->nama_hunian ?? '-' }}</h4>
                                        <p class="text-sm text-blue-700 mt-1">
                                            Kamar {{ $penempatan_aktif?->kamar->nomor_kamar ?? '-' }} | Lantai {{ $penempatan_aktif?->kamar->lantai ?? '-' }}
                                        </p>
                                    </div>
                                    <input type="hidden" name="hunian_id" value="{{ $penempatan_aktif?->kamar->hunian->id_hunian }}">
                                </div>
                            </div>
                        </template>

                        {{-- DURASI SEWA --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                            <label for="durasi_sewa" class="text-sm font-semibold text-content-main">Durasi Sewa</label>
                            <div class="md:col-span-2">
                                <select id="durasi_sewa" name="durasi_sewa" x-model="durasi"
                                    class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm focus:ring-1 focus:ring-brand focus:outline-none">
                                    <option value="6">6 Bulan</option>
                                    <option value="12">12 Bulan</option>
                                </select>
                            </div>
                        </div>

                        {{-- ESTIMASI BIAYA --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                            <label class="text-sm font-semibold text-content-main">Estimasi Biaya</label>
                            <div class="md:col-span-2">
                                <div class="block w-full rounded-2xl bg-brand-soft px-4 py-3 text-sm font-bold text-brand border border-brand/10">
                                    <span x-text="formatRupiah(totalHarga)"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- UPLOAD BERKAS --}}
                    <div class="pt-2">
                        <label class="block text-sm font-semibold text-content-main mb-3">
                            Unggah Berkas
                            <template x-if="tab === 'pendaftaran'">
                                <span class="text-xs text-content-sub">(KTP, KTM, KK, Surat Pernyataan, dll)</span>
                            </template>
                            <template x-if="tab === 'perpanjangan'">
                                <span class="text-xs text-content-sub">(KTM/Bukti Bayar, dll)</span>
                            </template>
                        </label>

                        <div class="mt-2 flex justify-center rounded-3xl border-2 border-dashed border-border-soft bg-bg-surface px-6 py-12 transition-all hover:border-brand/50 hover:bg-brand/5 group cursor-pointer">
                            <div class="text-center">
                                <i class="bi bi-cloud-arrow-up text-4xl text-brand mb-4 block group-hover:scale-110 transition-transform"></i>
                                <label for="file-upload" class="cursor-pointer font-semibold text-brand hover:underline text-sm sm:text-base">
                                    <span>Klik untuk pilih berkas atau drag & drop</span>
                                    <input id="file-upload" name="file_upload[]" type="file" class="sr-only" multiple required accept=".pdf,.png,.jpg,.jpeg">
                                </label>
                                <p class="text-[10px] sm:text-xs text-content-sub mt-2">PDF, JPG, PNG (Maksimal 5MB per file)</p>
                                <div id="file-preview" class="mt-4 text-left"></div>
                            </div>
                        </div>

                        @error('file_upload')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- BUTTON SUBMIT --}}
                    <div class="flex justify-end pt-4 border-t border-border-soft">
                        <button type="submit" 
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-brand/90 shadow-md shadow-brand/20">
                            <i class="bi bi-send-check"></i>
                            <span x-text="tab === 'pendaftaran' ? 'Ajukan Pendaftaran' : 'Ajukan Perpanjangan'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </section>

        {{-- Riwayat Pengajuan (Pendaftaran + Perpanjangan) --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-clock-history"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Riwayat Pengajuan</h2>
            </div>
            <div class="p-5 sm:p-6">
                <div class="overflow-x-auto rounded-2xl border border-border-soft">
                    <table class="min-w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-bg-surface text-[10px] uppercase tracking-wider text-content-sub">
                            <tr>
                                <th class="px-5 py-4 font-bold">Jenis</th>
                                <th class="px-5 py-4 font-bold">Hunian</th>
                                <th class="px-5 py-4 font-bold">Tanggal Pengajuan</th>
                                <th class="px-5 py-4 font-bold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-soft">
                            @php
                                // Gabungkan riwayat pendaftaran
                                $all_riwayat = [];
                                
                                // Tambahkan semua pendaftaran
                                foreach ($riwayat as $p) {
                                    $all_riwayat[] = (object) [
                                        'jenis' => 'Pendaftaran',
                                        'hunian_nama' => $p->hunian->nama_hunian,
                                        'hunian_tipe' => $p->hunian->tipe,
                                        'tanggal' => $p->tgl_pengajuan,
                                        'status' => $p->status_seleksi,
                                        'type' => 'pendaftaran'
                                    ];
                                }
                                
                                // Tambahkan semua perpanjangan
                                if ($penempatan_aktif) {
                                    $perpanjangan_all = \App\Models\Perpanjangan::where('penempatan_id', $penempatan_aktif->id_penempatan)
                                        ->orderBy('tgl_ajuan', 'desc')
                                        ->get();
                                    
                                    foreach ($perpanjangan_all as $pr) {
                                        $all_riwayat[] = (object) [
                                            'jenis' => 'Perpanjangan',
                                            'hunian_nama' => $penempatan_aktif->kamar->hunian->nama_hunian,
                                            'hunian_tipe' => $penempatan_aktif->kamar->hunian->tipe,
                                            'tanggal' => $pr->tgl_ajuan,
                                            'status' => $pr->status,
                                            'type' => 'perpanjangan'
                                        ];
                                    }
                                }
                                
                                // Sort by tanggal terbaru dulu
                                usort($all_riwayat, function($a, $b) {
                                    return strtotime($b->tanggal) - strtotime($a->tanggal);
                                });
                            @endphp

                            @forelse($all_riwayat as $item)
                                <tr class="hover:bg-bg-surface/50 transition-colors">
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-[9px] font-bold uppercase
                                            {{ $item->type == 'perpanjangan' ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-700' }}">
                                            {{ $item->jenis }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-content-main">{{ $item->hunian_nama }}</div>
                                        <div class="text-[10px] text-content-sub">{{ $item->hunian_tipe }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-content-sub">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] font-bold uppercase
                                            {{ 
                                                in_array($item->status, ['Disetujui', 'Sudah']) ? 'bg-green-100 text-green-700' : 
                                                (in_array($item->status, ['Ditolak']) ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')
                                            }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center text-content-sub italic">Belum ada riwayat pengajuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Handle file preview
        document.getElementById('file-upload').addEventListener('change', function(e) {
            const preview = document.getElementById('file-preview');
            const files = Array.from(e.target.files);
            
            if (files.length > 0) {
                preview.innerHTML = '<div class="mt-3 p-3 rounded-2xl bg-green-50 border border-green-200">' +
                    '<p class="text-xs font-semibold text-green-700">✓ ' + files.length + ' file dipilih:</p>' +
                    '<ul class="text-xs text-green-600 mt-2">' +
                    files.map(f => '<li>• ' + f.name + ' (' + (f.size / 1024).toFixed(0) + ' KB)</li>').join('') +
                    '</ul></div>';
            } else {
                preview.innerHTML = '';
            }
        });
    </script>
</x-mahasiswa-layout>