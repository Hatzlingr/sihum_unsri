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
                <p class="text-content-sub text-sm">Tampilan Denah Hunian akan ditampilkan di sini.</p>
            </div>
        </section>

        <div class="grid gap-6 lg:grid-cols-2">
            {{-- Data Kamar --}}
            <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm flex flex-col">
                <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                        <i class="bi bi-door-open"></i>
                    </span>
                    <h2 class="text-base font-semibold text-content-main sm:text-lg">Data Kamar</h2>
                </div>
                <div class="p-5 sm:p-6 space-y-4 flex-1">
                    <div class="flex flex-col gap-1 border-b border-border-soft pb-3">
                        <span class="text-xs text-content-sub uppercase tracking-wider">Nama Hunian</span>
                        <span class="font-semibold text-content-main">Asrama Mahasiswa (Contoh)</span>
                    </div>
                    <div class="flex flex-col gap-1 border-b border-border-soft pb-3">
                        <span class="text-xs text-content-sub uppercase tracking-wider">Nomor Kamar</span>
                        <span class="font-semibold text-content-main">A-102</span>
                    </div>
                    <div class="flex flex-col gap-1 border-b border-border-soft pb-3">
                        <span class="text-xs text-content-sub uppercase tracking-wider">Tipe Kamar</span>
                        <span class="font-semibold text-content-main">Reguler (2 Orang)</span>
                    </div>
                    <div class="flex flex-col gap-1 border-b border-border-soft pb-3">
                        <span class="text-xs text-content-sub uppercase tracking-wider">Lantai</span>
                        <span class="font-semibold text-content-main">1</span>
                    </div>
                    <div class="flex flex-col gap-1 border-b border-border-soft pb-3">
                        <span class="text-xs text-content-sub uppercase tracking-wider">Fasilitas</span>
                        <ul class="list-disc list-inside text-sm text-content-main mt-1">
                            <li>Kipas Angin</li>
                            <li>Lemari Pakaian</li>
                            <li>Meja Belajar</li>
                            <li>Kasur & Bantal</li>
                        </ul>
                    </div>
                </div>
            </section>

            <div class="flex flex-col gap-6">
                {{-- Status Pembayaran Bulan Ini --}}
                <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm flex flex-col flex-1">
                    <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                            <i class="bi bi-receipt"></i>
                        </span>
                        <h2 class="text-base font-semibold text-content-main sm:text-lg">Status Pembayaran Bulan Ini</h2>
                    </div>
                    <div class="p-5 sm:p-6 flex flex-col items-center justify-center flex-1 min-h-[160px]">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700 mb-3">
                            <i class="bi bi-check-circle-fill"></i> Lunas
                        </span>
                        <p class="text-sm text-content-sub text-center">Terima kasih, kamu sudah menyelesaikan pembayaran bulan ini.</p>
                    </div>
                </section>

                {{-- Sisa Waktu Sewa --}}
                <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm flex flex-col flex-1">
                    <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                            <i class="bi bi-clock-history"></i>
                        </span>
                        <h2 class="text-base font-semibold text-content-main sm:text-lg">Sisa Waktu Sewa</h2>
                    </div>
                    <div class="p-5 sm:p-6 flex flex-col items-center justify-center flex-1 min-h-[160px]">
                        <div class="text-3xl font-bold text-content-main mb-1">120 <span class="text-lg font-medium text-content-sub">Hari</span></div>
                        <p class="text-sm text-content-sub text-center">Sewa berakhir pada 15 Agustus 2026</p>
                        
                        <div class="w-full bg-bg-surface rounded-full h-2.5 mt-4">
                            <div class="bg-brand h-2.5 rounded-full" style="width: 45%"></div>
                        </div>
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
            <div class="p-5 sm:p-6">
                <div class="flex items-center gap-4 p-4 rounded-2xl border border-border-soft bg-bg-surface">
                    <div class="h-12 w-12 rounded-full bg-brand-soft flex items-center justify-center text-brand text-lg">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-content-main">Budi Santoso</h3>
                        <p class="text-sm text-content-sub">Teknik Informatika - 2024</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Kritik & Saran --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-chat-left-text"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Kritik & Saran</h2>
            </div>
            <div class="p-5 sm:p-6">
                <form action="#" method="POST" class="space-y-4">
                    <div>
                        <label for="saran" class="sr-only">Tulis kritik dan saran</label>
                        <textarea id="saran" name="saran" rows="3" class="block w-full rounded-2xl border border-border-soft bg-bg-base px-4 py-3 text-sm text-content-main focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand" placeholder="Tuliskan kritik, saran, atau laporan fasilitas rusak di sini..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand/90 hover:-translate-y-0.5">
                            <i class="bi bi-send"></i>
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </section>

    </div>
</x-mahasiswa-layout>
