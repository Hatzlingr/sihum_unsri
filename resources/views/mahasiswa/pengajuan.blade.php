<x-mahasiswa-layout title="Pengajuan Hunian" page-title="Pengajuan" active="pengajuan">
    @php
        // Ambil pendaftaran terakhir untuk menentukan status progress bar
        $latestPendaftaran = $riwayat->first();
        $latestStatus = $latestPendaftaran->status_seleksi ?? 'Belum Ada';
    @endphp

    <div class="space-y-6" x-data="{ 
        tab: 'pendaftaran',
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
                <button @click="tab = 'pendaftaran'"
                    :class="tab === 'pendaftaran' ? 'bg-brand text-white shadow-md shadow-brand/20' : 'bg-bg-surface text-content-sub'"
                    class="flex-1 py-3 px-4 rounded-2xl text-sm font-bold text-center transition-all duration-300">Pendaftaran</button>
                <button @click="tab = 'perpanjangan'"
                    :class="tab === 'perpanjangan' ? 'bg-brand text-white shadow-md shadow-brand/20' : 'bg-bg-surface text-content-sub'"
                    class="flex-1 py-3 px-4 rounded-2xl text-sm font-bold text-center transition-all duration-300">Perpanjangan</button>
            </div>

            <div class="p-5 sm:p-8 lg:p-10">
                {{-- Notifikasi jika sedang diproses --}}
                @if($latestStatus == 'Pending')
                    <div
                        class="mb-8 flex items-center gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-amber-800">
                        <i class="bi bi-info-circle-fill text-xl"></i>
                        <p class="text-sm font-medium">Anda sudah mengirim pengajuan. Mohon tunggu verifikasi admin sebelum
                            mengirim ulang.</p>
                    </div>
                @endif

                <form action="{{ route('mahasiswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data"
                    class="max-w-4xl mx-auto space-y-8">
                    @csrf
                    {{-- Hidden input untuk kasih tau controller ini jenis apa --}}
                    <input type="hidden" name="jenis_pengajuan" :value="tab">

                    <div class="space-y-6">
                        {{-- INPUT JENIS HUNIAN --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
                            <label for="hunian_id" class="text-sm font-semibold text-content-main md:pt-3">Jenis
                                Hunian</label>
                            <div class="md:col-span-2">

                                {{-- TAMPILAN JIKA PENDAFTARAN BARU --}}
                                <template x-if="tab === 'pendaftaran'">
                                    <div>
                                        @if($latestPendaftaran && $latestPendaftaran->status_seleksi == 'Disetujui')
                                            {{-- Alert kalau sudah punya hunian aktif --}}
                                            <div class="p-6 rounded-3xl bg-amber-50 border border-amber-200 text-center">
                                                <div
                                                    class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-amber-600 mb-3">
                                                    <i class="bi bi-house-check-fill text-xl"></i>
                                                </div>
                                                <h4 class="text-sm font-bold text-amber-900">Pendaftaran Terkunci</h4>
                                                <p class="text-xs text-amber-700 mt-1">
                                                    Maaf Wahyu, kamu sudah terdaftar di hunian
                                                    <span class="font-semibold">{{ $latestPendaftaran->hunian->nama_hunian }}</span>.
                                                    Silakan gunakan menu <span class="font-semibold">Perpanjangan</span> jika ingin menambah masa sewa.
                                                </p>
                                            </div>
                                        @else
                                            {{-- Tampilkan Select seperti biasa kalau belum punya hunian --}}
                                            <select id="hunian_id" name="hunian_id" required
                                                @change="hargaPerBulan = $el.options[$el.selectedIndex].getAttribute('data-harga') || 0"
                                                class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm focus:ring-1 focus:ring-brand">
                                                <option value="">Pilih Jenis Hunian...</option>
                                                @foreach($hunians as $h)
                                                    <option value="{{ $h->id_hunian }}"
                                                        data-harga="{{ $h->kamar->where('status', 'Tersedia')->min('harga_sewa') }}">
                                                        {{ $h->nama_hunian }} ({{ $h->tipe }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </template>

                                {{-- TAMPILAN JIKA PERPANJANGAN --}}
                                <template x-if="tab === 'perpanjangan'">
                                    <div>
                                        @php
                                            // Cari pendaftaran terakhir yang disetujui untuk perpanjangan
                                            $currentHunian = $riwayat->where('status_seleksi', 'Disetujui')->first();
                                        @endphp

                                        @if($currentHunian)
                                            <div class="p-4 rounded-2xl bg-blue-50 border border-blue-100 flex justify-between items-center"
                                                x-init="hargaPerBulan = {{ $currentHunian->hunian->kamar->min('harga_sewa') }}">
                                                <div>
                                                    <p class="text-xs text-blue-600 font-bold uppercase tracking-wider">
                                                        Hunian Aktif Anda</p>
                                                    <h4 class="text-lg font-bold text-blue-900">
                                                        {{ $currentHunian->hunian->nama_hunian }}
                                                    </h4>
                                                    <p class="text-sm text-blue-700">{{ $currentHunian->hunian->tipe }}</p>
                                                </div>
                                                <i class="bi bi-lock-fill text-blue-300 text-xl"></i>
                                            </div>
                                            <input type="hidden" name="hunian_id" value="{{ $currentHunian->id_hunian }}">
                                        @else
                                            <div
                                                class="p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm">
                                                <i class="bi bi-exclamation-triangle-fill mr-2"></i>
                                                Anda belum memiliki hunian aktif yang bisa diperpanjang.
                                            </div>
                                        @endif
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- DURASI SEWA (Sama untuk keduanya) --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                            <label for="durasi_sewa" class="text-sm font-semibold text-content-main">Durasi Sewa</label>
                            <div class="md:col-span-2">
                                <select id="durasi_sewa" name="durasi_sewa" x-model="durasi"
                                    class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm focus:ring-1 focus:ring-brand">
                                    <option value="6">6 Bulan (1 Semester)</option>
                                    <option value="12">12 Bulan (2 Semester)</option>
                                </select>
                            </div>
                        </div>

                        {{-- ESTIMASI BIAYA --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                            <label class="text-sm font-semibold text-content-main">Estimasi Biaya</label>
                            <div class="md:col-span-2">
                                <div
                                    class="block w-full rounded-2xl bg-brand-soft px-4 py-3 text-sm font-bold text-brand border border-brand/10">
                                    <span x-text="formatRupiah(totalHarga)"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- UPLOAD BERKAS --}}
                    <div class="pt-2">
                        <label class="block text-sm font-semibold text-content-main mb-3">
                            Unggah Berkas <span
                                x-text="tab === 'perpanjangan' ? 'Pembaruan (KTM/Bukti Bayar)' : 'Persyaratan (KTP/KTM)'"></span>
                        </label>

                        <div
                            class="mt-2 flex justify-center rounded-3xl border-2 border-dashed border-border-soft bg-bg-surface px-6 py-12 transition-all hover:border-brand/50 group">
                            <div class="text-center">
                                <i
                                    class="bi bi-cloud-arrow-up text-4xl text-brand mb-4 block group-hover:scale-110 transition-transform"></i>
                                <label for="file-upload"
                                    class="cursor-pointer font-semibold text-brand hover:underline text-sm sm:text-base">
                                    <span>Klik untuk pilih berkas</span>
                                    {{-- Input file ditaruh sini supaya selalu terkirim baik pendaftaran maupun
                                    perpanjangan --}}
                                    <input id="file-upload" name="file_upload[]" type="file" class="sr-only" multiple
                                        required>
                                </label>
                                <p class="text-[10px] sm:text-xs text-content-sub mt-2">PDF atau JPG (Maksimal 5MB)</p>

                                {{-- Preview sederhana (Opsional) --}}
                                <div id="file-chosen" class="mt-3 text-xs text-brand font-medium"></div>
                            </div>
                        </div>
                    </div>

                </form>

                {{-- BUTTON SUBMIT --}}
                <div class="flex justify-end pt-4 border-t border-border-soft">
                    <button type="submit" :disabled="{{ $latestStatus == 'Pending' ? 'true' : 'false' }} || 
                        (tab === 'pendaftaran' && {{ ($latestPendaftaran && $latestPendaftaran->status_seleksi == 'Disetujui') ? 'true' : 'false' }}) || 
                        (tab === 'perpanjangan' && !{{ isset($currentHunian) ? 'true' : 'false' }})"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-brand/90 disabled:opacity-50 disabled:cursor-not-allowed shadow-md shadow-brand/20">
                        <i class="bi bi-send-check"></i>
                        <span x-text="tab === 'pendaftaran' ? 'Ajukan Sekarang' : 'Ajukan Perpanjangan'"></span>
                    </button>
                </div>
                </form>
            </div>
        </section>

        {{-- Riwayat Pengajuan --}}
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
                                <th class="px-5 py-4 font-bold">Hunian</th>
                                <th class="px-5 py-4 font-bold">Tanggal Pengajuan</th>
                                <th class="px-5 py-4 font-bold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-soft">
                            @forelse($riwayat as $item)
                                <tr class="hover:bg-bg-surface/50 transition-colors">
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-content-main">{{ $item->hunian->nama_hunian }}</div>
                                        <div class="text-[10px] text-content-sub">{{ $item->hunian->tipe }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-content-sub">
                                        {{ \Carbon\Carbon::parse($item->tgl_pengajuan)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] font-bold uppercase
                                                            {{ $item->status_seleksi == 'Disetujui' ? 'bg-green-100 text-green-700' : ($item->status_seleksi == 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                            {{ $item->status_seleksi }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-10 text-center text-content-sub italic">Belum ada riwayat
                                        pengajuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</x-mahasiswa-layout>