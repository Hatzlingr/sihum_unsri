<x-mahasiswa-layout title="Pengaturan Akun" page-title="Pengaturan" active="pengaturan">
    <div class="space-y-6">

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="rounded-2xl bg-green-50 border border-green-200 p-4 text-sm text-green-600 flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-lg"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Ubah Kata Sandi --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-shield-lock"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Keamanan (Ubah Kata Sandi)</h2>
            </div>
            
            <div class="p-5 sm:p-8 lg:p-10">
                <form action="{{ route('mahasiswa.pengaturan.update-password') }}" method="POST" class="max-w-4xl mx-auto space-y-6">
                    @csrf
                    @method('PUT')
                    
                    {{-- Password Saat Ini --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                        <label for="current_password" class="text-sm font-semibold text-content-main">Password Saat Ini</label>
                        <div class="md:col-span-2 relative">
                            <input type="password" id="current_password" name="current_password" placeholder="••••••••" 
                                class="block w-full rounded-2xl border @error('current_password') border-red-500 @else border-border-soft @enderror bg-bg-base px-4 py-3 pr-10 text-sm focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand transition-all">
                            <button type="button" onclick="togglePass('current_password')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-brand">
                                <i class="bi bi-eye toggle-icon"></i>
                            </button>
                            @error('current_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Password Baru --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                        <label for="new_password" class="text-sm font-semibold text-content-main">Password Baru</label>
                        <div class="md:col-span-2 relative">
                            <input type="password" id="new_password" name="new_password" placeholder="Minimal 8 karakter" 
                                class="block w-full rounded-2xl border @error('new_password') border-red-500 @else border-border-soft @enderror bg-bg-base px-4 py-3 pr-10 text-sm focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand transition-all">
                            <button type="button" onclick="togglePass('new_password')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-brand">
                                <i class="bi bi-eye toggle-icon"></i>
                            </button>
                            @error('new_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Konfirmasi Password Baru --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                        <label for="new_password_confirmation" class="text-sm font-semibold text-content-main">Konfirmasi Password Baru</label>
                        <div class="md:col-span-2 relative">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Ulangi password baru" 
                                class="block w-full rounded-2xl border border-border-soft bg-bg-base px-4 py-3 pr-10 text-sm focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand transition-all">
                            <button type="button" onclick="togglePass('new_password_confirmation')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-brand">
                                <i class="bi bi-eye toggle-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-border-soft">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand px-10 py-2.5 text-sm font-semibold text-white shadow-lg transition hover:bg-brand/90 hover:-translate-y-0.5">
                            <i class="bi bi-key"></i> Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <script>
        function togglePass(id) {
            const el = document.getElementById(id);
            const icon = el.nextElementSibling.querySelector('.toggle-icon');
            if (el.type === 'password') {
                el.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                el.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</x-mahasiswa-layout>