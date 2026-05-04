<x-mahasiswa-layout title="Biodata Diri" page-title="Biodata" active="biodata">
    <div class="space-y-6">

        {{-- Profil Singkat (Foto, Nama, Jurusan) --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm relative">
            {{-- Background Cover --}}
            <div class="h-32 w-full bg-gradient-to-r from-brand to-brand-light/50"></div>
            
            <div class="px-5 sm:px-8 pb-8">
                <div class="flex flex-col sm:flex-row gap-6 sm:items-end -mt-12 sm:-mt-16">
                    {{-- Avatar --}}
                    <div class="relative h-24 w-24 sm:h-32 sm:w-32 rounded-full border-4 border-bg-base bg-brand-soft flex items-center justify-center shrink-0 shadow-md">
                        <i class="bi bi-person-fill text-5xl text-brand"></i>
                        {{-- Edit Photo Button --}}
                        <button type="button" class="absolute bottom-0 right-0 rounded-full bg-brand p-2 text-white shadow-lg transition hover:bg-brand/90 hover:scale-105">
                            <i class="bi bi-camera-fill text-sm"></i>
                        </button>
                    </div>
                    
                    {{-- Info Singkat --}}
                    <div class="flex-1 pb-2">
                        <h2 class="text-2xl font-bold text-content-main">{{ auth()->user()->name ?? 'Budi Santoso' }}</h2>
                        <div class="mt-1 flex flex-col sm:flex-row gap-2 sm:gap-6 text-sm text-content-sub">
                            <span class="flex items-center gap-1.5"><i class="bi bi-mortarboard"></i> Teknik Informatika</span>
                            <span class="flex items-center gap-1.5"><i class="bi bi-person-badge"></i> 09021282126000</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Data Diri Lengkap --}}
        <section class="overflow-hidden rounded-xl border border-border-soft bg-white shadow-sm">
            <div class="p-6 sm:p-8">
                <h2 class="text-xl font-semibold text-slate-800 mb-6">Data Diri</h2>
                
                <form action="#" method="POST" class="space-y-6">
                    
                    {{-- Nama --}}
                    <div class="space-y-2">
                        <label for="nama" class="text-sm font-semibold text-slate-800">Nama</label>
                        <input type="text" id="nama" name="nama" value="{{ auth()->user()->name ?? 'Budi Santoso' }}" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                        {{-- NIK --}}
                        <div class="space-y-2">
                            <label for="nik" class="text-sm font-semibold text-slate-800">NIK</label>
                            <input type="text" id="nik" name="nik" value="16710..." class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
                        </div>

                        {{-- NIM --}}
                        <div class="space-y-2">
                            <label for="nim" class="text-sm font-semibold text-slate-800">NIM</label>
                            <input type="text" id="nim" name="nim" value="09021282126000" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
                        </div>

                        {{-- Tempat Lahir --}}
                        <div class="space-y-2">
                            <label for="tempat_lahir" class="text-sm font-semibold text-slate-800">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" value="Palembang" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="space-y-2">
                            <label for="tanggal_lahir" class="text-sm font-semibold text-slate-800">Tanggal Lahir</label>
                            <input type="text" id="tanggal_lahir" name="tanggal_lahir" value="07-11-2006" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
                        </div>

                        {{-- Agama --}}
                        <div class="space-y-2">
                            <label for="agama" class="text-sm font-semibold text-slate-800">Agama</label>
                            <input type="text" id="agama" name="agama" value="Islam" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
                        </div>

                        {{-- Kewarganegaraan --}}
                        <div class="space-y-2">
                            <label for="kewarganegaraan" class="text-sm font-semibold text-slate-800">Kewarganegaraan</label>
                            <input type="text" id="kewarganegaraan" name="kewarganegaraan" value="Indonesia" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
                        </div>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="space-y-3 pt-2">
                        <label class="text-sm font-semibold text-slate-800">Jenis Kelamin</label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="Laki-Laki" checked class="h-4 w-4 border-slate-300 text-brand focus:ring-brand">
                                <span class="text-sm text-slate-800">Laki-Laki</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" class="h-4 w-4 border-slate-300 text-brand focus:ring-brand">
                                <span class="text-sm text-slate-800">Perempuan</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="Lainnya" class="h-4 w-4 border-slate-300 text-brand focus:ring-brand">
                                <span class="text-sm text-slate-800">Lainnya</span>
                            </label>
                        </div>
                    </div>

                    {{-- Kontak Mahasiswa Header --}}
                    <div class="mt-8 mb-4 border-b border-slate-200 pb-3 flex items-center gap-2 pt-6">
                        <i class="bi bi-person text-slate-800 text-xl"></i>
                        <h3 class="text-lg font-semibold text-slate-800">Kontak Mahasiswa</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                        {{-- Email --}}
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-semibold text-slate-800">Email</label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? 'mahasiswa@unsri.ac.id' }}" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
                        </div>

                        {{-- No. HP --}}
                        <div class="space-y-2">
                            <label for="no_hp" class="text-sm font-semibold text-slate-800">No. HP</label>
                            <input type="text" id="no_hp" name="no_hp" value="081234567890" class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-800 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand">
                        </div>
                    </div>

                    {{-- Submit Action --}}
                    <div class="flex justify-end pt-8">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand/90 hover:-translate-y-0.5">
                            <i class="bi bi-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </section>

    </div>
</x-mahasiswa-layout>
