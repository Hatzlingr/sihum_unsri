<x-mahasiswa-layout title="Pengaturan Akun" page-title="Pengaturan" active="pengaturan">
    <div class="space-y-6">

        {{-- Informasi Akun --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-person-gear"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Informasi Akun Dasar</h2>
            </div>
            
            <div class="p-5 sm:p-8 lg:p-10">
                <form action="#" method="POST" class="max-w-4xl mx-auto space-y-6">
                    
                    {{-- Username --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                        <label for="username" class="text-sm font-semibold text-content-main">Username</label>
                        <div class="md:col-span-2">
                            <input type="text" id="username" name="username" value="{{ auth()->user()->username ?? 'budi.santoso' }}" class="block w-full rounded-2xl border border-border-soft bg-bg-base px-4 py-3 text-sm text-content-main focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand transition-colors">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                        <label for="email" class="text-sm font-semibold text-content-main">Email</label>
                        <div class="md:col-span-2">
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? 'mahasiswa@unsri.ac.id' }}" class="block w-full rounded-2xl border border-border-soft bg-bg-base px-4 py-3 text-sm text-content-main focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand transition-colors">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-border-soft">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand/90 hover:-translate-y-0.5">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </section>

        {{-- Ubah Kata Sandi --}}
        <section class="overflow-hidden rounded-3xl border border-border-soft bg-bg-base shadow-sm">
            <div class="flex items-center gap-3 border-b border-border-soft px-5 py-4 sm:px-6">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-soft text-brand">
                    <i class="bi bi-shield-lock"></i>
                </span>
                <h2 class="text-base font-semibold text-content-main sm:text-lg">Keamanan (Ubah Kata Sandi)</h2>
            </div>
            
            <div class="p-5 sm:p-8 lg:p-10">
                <form action="#" method="POST" class="max-w-4xl mx-auto space-y-6">
                    
                    {{-- Current Password --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                        <label for="current_password" class="text-sm font-semibold text-content-main">Current Password</label>
                        <div class="md:col-span-2 relative">
                            <input type="password" id="current_password" name="current_password" placeholder="Masukkan kata sandi saat ini" class="block w-full rounded-2xl border border-border-soft bg-bg-base px-4 py-3 pr-10 text-sm text-content-main focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand transition-colors">
                            <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-4 text-content-sub hover:text-brand">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- New Password --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                        <label for="new_password" class="text-sm font-semibold text-content-main">New Password</label>
                        <div class="md:col-span-2 relative">
                            <input type="password" id="new_password" name="new_password" placeholder="Masukkan kata sandi baru" class="block w-full rounded-2xl border border-border-soft bg-bg-base px-4 py-3 pr-10 text-sm text-content-main focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand transition-colors">
                            <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-4 text-content-sub hover:text-brand">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Confirm New Password --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center">
                        <label for="new_password_confirmation" class="text-sm font-semibold text-content-main">Confirm New Password</label>
                        <div class="md:col-span-2 relative">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Ulangi kata sandi baru" class="block w-full rounded-2xl border border-border-soft bg-bg-base px-4 py-3 pr-10 text-sm text-content-main focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand transition-colors">
                            <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-4 text-content-sub hover:text-brand">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-border-soft">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-content-main px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-content-main/90 hover:-translate-y-0.5">
                            Perbarui Kata Sandi
                        </button>
                    </div>

                </form>
            </div>
        </section>

    </div>
</x-mahasiswa-layout>
