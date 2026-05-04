<x-mahasiswa-layout title="Pembayaran" page-title="Pembayaran" active="pembayaran">
    <div class="space-y-6">

        {{-- Cara Pembayaran --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-info-circle"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Cara Pembayaran</h2>
            </div>
            <div class="p-5 sm:p-6 space-y-4">
                <p class="text-sm text-content-sub">Silakan lakukan pembayaran ke salah satu rekening Bank Sumsel Babel berikut ini:</p>
                
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-2xl border border-border-soft bg-bg-surface p-4">
                        <div class="text-xs font-semibold uppercase tracking-wider text-content-sub mb-1">Bank Sumsel Babel (BSB)</div>
                        <div class="text-lg font-bold text-content-main mb-1">123-456-7890</div>
                        <div class="text-sm font-medium text-brand">a.n. BPU UNSRI</div>
                    </div>
                    
                    <div class="rounded-2xl border border-border-soft bg-bg-surface p-4">
                        <div class="text-xs font-semibold uppercase tracking-wider text-content-sub mb-1">Bank Mandiri</div>
                        <div class="text-lg font-bold text-content-main mb-1">098-765-4321</div>
                        <div class="text-sm font-medium text-brand">a.n. BPU UNSRI</div>
                    </div>
                </div>

                <div class="mt-4 rounded-2xl bg-blue-50 p-4 border border-blue-100">
                    <div class="flex gap-3">
                        <i class="bi bi-exclamation-triangle text-blue-600 mt-0.5"></i>
                        <p class="text-sm text-blue-800">
                            <strong>Penting:</strong> Pastikan Anda membayar sesuai dengan <strong>Total Pembayaran</strong> yang tertera. Simpan bukti transfer dan unggah pada form yang tersedia. Verifikasi pembayaran membutuhkan waktu 1x24 jam kerja.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Grid Tengah: Info Pembayaran & Unggah Bukti --}}
        <div class="grid gap-6 lg:grid-cols-2">
            
            {{-- Kolom Kiri: Total & Status --}}
            <div class="flex flex-col gap-6">
                {{-- Total Pembayaran --}}
                <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm flex-1">
                    <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                            <i class="bi bi-wallet2"></i>
                        </span>
                        <h2 class="text-base font-semibold text-content-main sm:text-lg">Total Pembayaran</h2>
                    </div>
                    <div class="p-5 sm:p-6 flex flex-col items-center justify-center min-h-[140px]">
                        <p class="text-sm text-content-sub mb-2">Tagihan Bulan September 2026</p>
                        <div class="text-3xl font-bold tracking-tight text-content-main">Rp 350.000</div>
                    </div>
                </section>

                {{-- Status Pembayaran Bulan Ini --}}
                <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm flex-1">
                    <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                            <i class="bi bi-receipt"></i>
                        </span>
                        <h2 class="text-base font-semibold text-content-main sm:text-lg">Status Pembayaran Bulan Ini</h2>
                    </div>
                    <div class="p-5 sm:p-6 flex flex-col items-center justify-center min-h-[140px]">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-yellow-100 px-4 py-1.5 text-sm font-bold text-yellow-700 mb-3">
                            <i class="bi bi-hourglass-split"></i> Menunggu Pembayaran
                        </span>
                        <p class="text-sm text-content-sub text-center">Silakan unggah bukti pembayaran Anda.</p>
                    </div>
                </section>
            </div>

            {{-- Kolom Kanan: Unggah Bukti Pembayaran --}}
            <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm flex flex-col">
                <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </span>
                    <h2 class="text-base font-semibold text-content-main sm:text-lg">Unggah Bukti Pembayaran</h2>
                </div>
                <div class="p-5 sm:p-6 flex-1 flex flex-col">
                    <form action="#" method="POST" class="flex-1 flex flex-col space-y-4">
                        
                        <div class="flex-1 flex flex-col justify-center rounded-3xl border-2 border-dashed border-border-soft bg-bg-surface px-6 py-10 transition-colors hover:border-brand/50 hover:bg-brand-light/30">
                            <div class="text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brand-soft text-brand mb-4">
                                    <i class="bi bi-file-earmark-image text-2xl"></i>
                                </div>
                                <div class="mt-4 flex text-sm leading-6 text-content-main justify-center">
                                    <label for="bukti-pembayaran" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-brand focus-within:outline-none focus-within:ring-2 focus-within:ring-brand focus-within:ring-offset-2 hover:text-brand/80">
                                        <span>Pilih file bukti transfer</span>
                                        <input id="bukti-pembayaran" name="bukti-pembayaran" type="file" class="sr-only" accept="image/png, image/jpeg, application/pdf">
                                    </label>
                                </div>
                                <p class="text-xs leading-5 text-content-sub mt-2">Format: JPG, PNG, atau PDF (Maks. 2MB)</p>
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-brand px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand/90 hover:-translate-y-0.5">
                                <i class="bi bi-send-check"></i>
                                Kirim Bukti
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        {{-- Riwayat Pembayaran --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-clock-history"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Riwayat Pembayaran</h2>
            </div>
            
            <div class="p-5 sm:p-6">
                <div class="overflow-x-auto rounded-2xl border border-border-soft">
                    <table class="min-w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-bg-surface text-xs uppercase tracking-wide text-content-sub">
                            <tr>
                                <th class="px-5 py-4 font-semibold">Bulan/Periode</th>
                                <th class="px-5 py-4 font-semibold">Tanggal Bayar</th>
                                <th class="px-5 py-4 font-semibold">Nominal</th>
                                <th class="px-5 py-4 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-soft">
                            <tr class="hover:bg-bg-surface/50 transition-colors">
                                <td class="px-5 py-4 font-medium text-content-main">Agustus 2026</td>
                                <td class="px-5 py-4 text-content-sub">02 Agustus 2026</td>
                                <td class="px-5 py-4 font-medium text-content-main">Rp 350.000</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Lunas
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-bg-surface/50 transition-colors">
                                <td class="px-5 py-4 font-medium text-content-main">Juli 2026</td>
                                <td class="px-5 py-4 text-content-sub">05 Juli 2026</td>
                                <td class="px-5 py-4 font-medium text-content-main">Rp 350.000</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Lunas
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
