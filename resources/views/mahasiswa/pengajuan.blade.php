<x-mahasiswa-layout title="Pengajuan Hunian" page-title="Pengajuan" active="pengajuan">
    <div class="space-y-6" x-data="{ tab: 'pendaftaran' }">

        {{-- Bar Status Pengajuan --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-bar-chart-steps"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Status Pengajuan Saat Ini</h2>
            </div>
            <div class="p-5 sm:p-6 lg:px-10">
                {{-- Simple Status Tracker --}}
                <div class="relative flex items-center justify-between">
                    <div class="absolute left-0 top-1/2 -z-10 h-1 w-full -translate-y-1/2 bg-bg-surface"></div>
                    <!-- The active progress bar -->
                    <div class="absolute left-0 top-1/2 -z-10 h-1 w-1/2 -translate-y-1/2 bg-brand transition-all duration-500"></div>
                    
                    {{-- Step 1 --}}
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand text-white ring-4 ring-bg-base">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="text-xs font-semibold text-content-main">Pengisian Data</span>
                    </div>

                    {{-- Step 2 --}}
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand text-white ring-4 ring-bg-base shadow-sm shadow-brand/30">
                            <i class="bi bi-circle-fill text-[8px]"></i>
                        </div>
                        <span class="text-xs font-semibold text-brand">Verifikasi Berkas</span>
                    </div>

                    {{-- Step 3 --}}
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-bg-surface text-content-sub ring-4 ring-bg-base">
                            <span class="text-sm font-medium">3</span>
                        </div>
                        <span class="text-xs font-medium text-content-sub">Persetujuan</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- Form Area with Tabs --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            
            {{-- Tab Triggers --}}
            <div class="flex p-4 border-b border-border-soft gap-4 bg-bg-surface/50">
                <button 
                    @click="tab = 'pendaftaran'" 
                    :class="tab === 'pendaftaran' ? 'bg-brand text-white shadow-md shadow-brand/20' : 'bg-bg-surface text-content-sub hover:bg-brand-light hover:text-brand'"
                    class="flex-1 py-3 px-4 rounded-2xl text-sm font-bold text-center transition-all duration-300"
                >
                    Pendaftaran
                </button>
                <button 
                    @click="tab = 'perpanjangan'" 
                    :class="tab === 'perpanjangan' ? 'bg-brand text-white shadow-md shadow-brand/20' : 'bg-bg-surface text-content-sub hover:bg-brand-light hover:text-brand'"
                    class="flex-1 py-3 px-4 rounded-2xl text-sm font-bold text-center transition-all duration-300"
                >
                    Perpanjangan
                </button>
            </div>

            <div class="p-5 sm:p-8 lg:p-10">
                <form action="#" method="POST" class="max-w-4xl mx-auto space-y-8">
                    
                    {{-- Form Fields --}}
                    <div class="space-y-6">
                        {{-- Jenis Hunian --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
                            <label for="jenis_hunian" class="text-sm font-semibold text-content-main md:pt-3">Jenis Hunian</label>
                            <div class="md:col-span-2">
                                <select id="jenis_hunian" name="jenis_hunian" class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm text-content-main focus:border-brand focus:bg-bg-base focus:outline-none focus:ring-1 focus:ring-brand transition-colors">
                                    <option value="">Pilih Jenis Hunian...</option>
                                    <option value="asrama_putra">Asrama Putra</option>
                                    <option value="asrama_putri">Asrama Putri</option>
                                    <option value="rusunawa">Rusunawa</option>
                                </select>
                                <p class="mt-2 text-right text-xs text-content-sub italic">Harga per Bulan menyesuaikan jenis hunian</p>
                            </div>
                        </div>

                        {{-- Durasi Sewa --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                            <label for="durasi_sewa" class="text-sm font-semibold text-content-main">Durasi Sewa</label>
                            <div class="md:col-span-2 relative">
                                <select id="durasi_sewa" name="durasi_sewa" class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm text-content-main focus:border-brand focus:bg-bg-base focus:outline-none focus:ring-1 focus:ring-brand transition-colors">
                                    <option value="6">6 Bulan (1 Semester)</option>
                                    <option value="12">12 Bulan (2 Semester)</option>
                                </select>
                            </div>
                        </div>

                        {{-- Total Harga --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                            <label for="total_harga" class="text-sm font-semibold text-content-main">Total Harga</label>
                            <div class="md:col-span-2">
                                <input type="text" id="total_harga" name="total_harga" value="Rp 0" readonly class="block w-full rounded-2xl border border-transparent bg-brand-light px-4 py-3 text-sm font-bold text-brand focus:outline-none cursor-not-allowed">
                            </div>
                        </div>
                    </div>

                    {{-- Unggah Berkas --}}
                    <div class="pt-2">
                        <label class="block text-sm font-semibold text-content-main mb-3">Unggah Berkas Persyaratan</label>
                        <div class="mt-2 flex justify-center rounded-3xl border-2 border-dashed border-border-soft bg-bg-surface px-6 py-12 transition-colors hover:border-brand/50 hover:bg-brand-light/30">
                            <div class="text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brand-soft text-brand mb-4">
                                    <i class="bi bi-cloud-arrow-up text-2xl"></i>
                                </div>
                                <div class="mt-4 flex text-sm leading-6 text-content-main justify-center">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-brand focus-within:outline-none focus-within:ring-2 focus-within:ring-brand focus-within:ring-offset-2 hover:text-brand/80">
                                        <span>Pilih file</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only" multiple>
                                    </label>
                                    <p class="pl-1">atau tarik dan lepas di sini</p>
                                </div>
                                <p class="text-xs leading-5 text-content-sub mt-2">PDF, PNG, JPG hingga 5MB. KTP, KTM, Surat Pernyataan.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Action --}}
                    <div class="flex justify-end pt-4 border-t border-border-soft">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand/90 hover:-translate-y-0.5">
                            <i class="bi bi-send-check"></i>
                            Ajukan Sekarang
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
                        <thead class="bg-bg-surface text-xs uppercase tracking-wide text-content-sub">
                            <tr>
                                <th class="px-5 py-4 font-semibold">Tipe Pengajuan</th>
                                <th class="px-5 py-4 font-semibold">Hunian</th>
                                <th class="px-5 py-4 font-semibold">Tanggal</th>
                                <th class="px-5 py-4 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-soft">
                            <tr class="hover:bg-bg-surface/50 transition-colors">
                                <td class="px-5 py-4 font-medium text-content-main">Pendaftaran Baru</td>
                                <td class="px-5 py-4 text-content-sub">Asrama Putra - Reguler</td>
                                <td class="px-5 py-4 text-content-sub">12 Agustus 2025</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Disetujui
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-bg-surface/50 transition-colors">
                                <td class="px-5 py-4 font-medium text-content-main">Pendaftaran Baru</td>
                                <td class="px-5 py-4 text-content-sub">Rusunawa - VIP</td>
                                <td class="px-5 py-4 text-content-sub">01 Agustus 2024</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                        Selesai Masa Sewa
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>
</x-mahasiswa-layout>
