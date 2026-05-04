<x-mahasiswa-layout title="Pemberhentian" page-title="Pemberhentian" active="pemberhentian">
    <div class="space-y-6">

        {{-- Bar Status Pengajuan --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-bar-chart-steps"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Status Pengajuan Pemberhentian</h2>
            </div>
            <div class="p-5 sm:p-6 lg:px-10">
                {{-- Simple Status Tracker --}}
                <div class="relative flex items-center justify-between">
                    <div class="absolute left-0 top-1/2 -z-10 h-1 w-full -translate-y-1/2 bg-bg-surface"></div>
                    <!-- The active progress bar -->
                    <div class="absolute left-0 top-1/2 -z-10 h-1 w-0 -translate-y-1/2 bg-brand transition-all duration-500"></div>
                    
                    {{-- Step 1 --}}
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand text-white ring-4 ring-bg-base shadow-sm shadow-brand/30">
                            <i class="bi bi-circle-fill text-[8px]"></i>
                        </div>
                        <span class="text-xs font-semibold text-brand">Pengisian Data</span>
                    </div>

                    {{-- Step 2 --}}
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-bg-surface text-content-sub ring-4 ring-bg-base">
                            <span class="text-sm font-medium">2</span>
                        </div>
                        <span class="text-xs font-medium text-content-sub">Verifikasi</span>
                    </div>

                    {{-- Step 3 --}}
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-bg-surface text-content-sub ring-4 ring-bg-base">
                            <span class="text-sm font-medium">3</span>
                        </div>
                        <span class="text-xs font-medium text-content-sub">Persetujuan</span>
                    </div>
                </div>
                <p class="text-sm text-content-sub text-center mt-6">Kamu belum memiliki pengajuan pemberhentian yang aktif.</p>
            </div>
        </section>

        {{-- Form Pemberhentian --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-box-arrow-right"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Formulir Pengajuan Pemberhentian</h2>
            </div>
            
            <div class="p-5 sm:p-8 lg:p-10">
                <form action="#" method="POST" class="max-w-4xl mx-auto space-y-8">
                    
                    <div class="space-y-6">
                        {{-- Nama --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                            <label for="nama" class="text-sm font-semibold text-content-main">Nama</label>
                            <div class="md:col-span-2">
                                <input type="text" id="nama" name="nama" value="{{ auth()->user()->name ?? 'Budi Santoso' }}" readonly class="block w-full rounded-2xl border border-transparent bg-bg-surface px-4 py-3 text-sm font-semibold text-content-sub focus:outline-none cursor-not-allowed">
                            </div>
                        </div>

                        {{-- Nomor Kamar --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                            <label for="nomor_kamar" class="text-sm font-semibold text-content-main">Nomor Kamar</label>
                            <div class="md:col-span-2">
                                <input type="text" id="nomor_kamar" name="nomor_kamar" value="A-102" readonly class="block w-full rounded-2xl border border-transparent bg-bg-surface px-4 py-3 text-sm font-semibold text-content-sub focus:outline-none cursor-not-allowed">
                            </div>
                        </div>

                        {{-- Jenis Hunian --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                            <label for="jenis_hunian" class="text-sm font-semibold text-content-main">Jenis Hunian</label>
                            <div class="md:col-span-2">
                                <input type="text" id="jenis_hunian" name="jenis_hunian" value="Asrama Putra Reguler" readonly class="block w-full rounded-2xl border border-transparent bg-bg-surface px-4 py-3 text-sm font-semibold text-content-sub focus:outline-none cursor-not-allowed">
                            </div>
                        </div>

                        {{-- Tanggal Berhenti --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                            <label for="tanggal_berhenti" class="text-sm font-semibold text-content-main">Tanggal Berhenti</label>
                            <div class="md:col-span-2">
                                <input type="date" id="tanggal_berhenti" name="tanggal_berhenti" class="block w-full rounded-2xl border border-border-soft bg-bg-base px-4 py-3 text-sm text-content-main focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand transition-colors">
                            </div>
                        </div>

                        {{-- Alasan Pemberhentian --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
                            <label for="alasan" class="text-sm font-semibold text-content-main md:pt-3">Alasan Pemberhentian</label>
                            <div class="md:col-span-2">
                                <textarea id="alasan" name="alasan" rows="4" class="block w-full rounded-2xl border border-border-soft bg-bg-base px-4 py-3 text-sm text-content-main focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand transition-colors" placeholder="Jelaskan alasan pengajuan pemberhentian hunian..."></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Unggah Berkas --}}
                    <div class="pt-2">
                        <label class="block text-sm font-semibold text-content-main mb-3">Unggah Berkas Pendukung (Opsional)</label>
                        <div class="mt-2 flex justify-center rounded-3xl border-2 border-dashed border-border-soft bg-bg-surface px-6 py-12 transition-colors hover:border-brand/50 hover:bg-brand-light/30">
                            <div class="text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brand-soft text-brand mb-4">
                                    <i class="bi bi-cloud-arrow-up text-2xl"></i>
                                </div>
                                <div class="mt-4 flex text-sm leading-6 text-content-main justify-center">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-brand focus-within:outline-none focus-within:ring-2 focus-within:ring-brand focus-within:ring-offset-2 hover:text-brand/80">
                                        <span>Pilih file pendukung</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only" multiple>
                                    </label>
                                    <p class="pl-1">atau tarik dan lepas di sini</p>
                                </div>
                                <p class="text-xs leading-5 text-content-sub mt-2">Maksimal 5MB (Format PDF, JPG, PNG)</p>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Action --}}
                    <div class="flex justify-end pt-4 border-t border-border-soft">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand/90 hover:-translate-y-0.5">
                            <i class="bi bi-send-check"></i>
                            Ajukan Pemberhentian
                        </button>
                    </div>

                </form>
            </div>
        </section>

    </div>
</x-mahasiswa-layout>
