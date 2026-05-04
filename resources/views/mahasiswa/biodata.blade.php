<x-mahasiswa-layout title="Biodata Diri" page-title="Biodata" active="biodata">
    <div class="space-y-6">

        {{-- Alert Sukses --}}
        @if(session('success'))
            <div class="rounded-2xl bg-green-50 border border-green-200 p-4 text-sm text-green-600 flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-lg"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Header Profil --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm relative">
            <div class="h-32 w-full bg-linear-to-r from-brand to-brand-light/50"></div>
            <div class="px-5 sm:px-8 pb-8">
                <div class="flex flex-col sm:flex-row gap-6 sm:items-end -mt-12 sm:-mt-16">
                    <div class="h-24 w-24 sm:h-32 sm:w-32 rounded-full border-4 border-bg-base bg-brand-soft flex items-center justify-center shrink-0 shadow-md">
                        <i class="bi bi-person-fill text-5xl text-brand"></i>
                    </div>
                    <div class="flex-1 pb-2">
                        <div class="flex items-center gap-3">
                            <h2 class="text-2xl font-bold text-content-main">{{ $mahasiswa->nama }}</h2>
                            {{-- Hanya tampil jika KIP-K --}}
                            @if($mahasiswa->status_kipk)
                                <span class="rounded-full bg-green-100 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-green-600 border border-green-200">
                                    <i class="bi bi-patch-check-fill"></i> KIP-K
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-content-sub mt-1">
                            <i class="bi bi-mortarboard"></i> {{ $mahasiswa->prodi }} | {{ $mahasiswa->nim }}
                        </p>
                    </div>
                    <div class="pb-2">
                        <button type="button" id="btn-edit" onclick="enableEditMode()" class="flex items-center gap-2 rounded-xl border border-brand text-brand px-5 py-2.5 text-sm font-semibold hover:bg-brand hover:text-white transition shadow-sm">
                            <i class="bi bi-pencil-square"></i> Ubah Kontak
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- Detail Informasi --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="p-6 sm:p-8">
                <form action="{{ route('mahasiswa.biodata.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        {{-- Identitas Akademik (ReadOnly) --}}
                        <div>
                            <h3 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-4 flex items-center gap-2">
                                <i class="bi bi-shield-lock"></i> Identitas Akademik
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-content-main">Nama Lengkap</label>
                                    <input type="text" value="{{ $mahasiswa->nama }}" disabled class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm text-content-sub cursor-not-allowed">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-content-main">NIM</label>
                                    <input type="text" value="{{ $mahasiswa->nim }}" disabled class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm text-content-sub cursor-not-allowed">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-content-main">Program Studi</label>
                                    <input type="text" value="{{ $mahasiswa->prodi }}" disabled class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm text-content-sub cursor-not-allowed">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-content-main">Status Beasiswa</label>
                                    <input type="text" value="{{ $mahasiswa->status_kipk ? 'Penerima KIP-K' : 'Non-KIPK' }}" disabled class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm text-content-sub cursor-not-allowed">
                                </div>
                            </div>
                        </div>

                        {{-- Kontak Personal (Editable Mode) --}}
                        <div class="pt-6 border-t border-dashed border-border-soft">
                            <h3 class="text-sm font-bold uppercase tracking-widest text-brand mb-4 flex items-center gap-2">
                                <i class="bi bi-person-lines-fill"></i> Kontak Personal
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-content-main">Email Utama</label>
                                    <input type="text" value="{{ $mahasiswa->email }}" disabled class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm text-content-sub cursor-not-allowed">
                                    <p class="text-[10px] text-slate-400 mt-1">*Email digunakan untuk login sistem</p>
                                </div>
                                <div class="space-y-2">
                                    <label for="input-wa" class="text-sm font-semibold text-content-main">Nomor WhatsApp</label>
                                    <input type="text" id="input-wa" name="no_hp" value="{{ $mahasiswa->no_hp }}" disabled 
                                        class="block w-full rounded-2xl border border-border-soft bg-bg-surface px-4 py-3 text-sm text-content-sub transition-all duration-300 cursor-not-allowed">
                                    @error('no_hp')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div id="action-buttons" class="hidden justify-end gap-3 pt-8 mt-8 border-t border-border-soft">
                        <button type="button" onclick="window.location.reload()" class="rounded-2xl bg-slate-100 px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-200 transition">
                            Batal
                        </button>
                        <button type="submit" class="rounded-2xl bg-brand px-10 py-2.5 text-sm font-semibold text-white shadow-lg hover:bg-brand/90 hover:-translate-y-0.5 transition-all">
                            <i class="bi bi-save2 me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    {{-- Edit Mode Script --}}
    <script>
        function enableEditMode() {
            const inputWa = document.getElementById('input-wa');
            const btnEdit = document.getElementById('btn-edit');
            const actionButtons = document.getElementById('action-buttons');

            inputWa.disabled = false;
            inputWa.classList.remove('bg-bg-surface', 'text-content-sub', 'cursor-not-allowed');
            inputWa.classList.add('bg-bg-base', 'border-brand', 'ring-4', 'ring-brand/10', 'text-content-main', 'shadow-sm', 'cursor-text');
            
            inputWa.focus();

            btnEdit.classList.add('hidden');
            actionButtons.classList.remove('hidden');
            actionButtons.classList.add('flex');
        }
    </script>
</x-mahasiswa-layout>