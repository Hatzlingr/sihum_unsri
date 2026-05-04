<x-auth-layout>
    <x-slot:title>Daftar | SIHUM UNSRI</x-slot:title>

    <section class="flex min-h-screen items-center px-4 py-12">
        <div class="mx-auto w-full items-center justify-center">
            <div class="mx-auto w-full max-w-md rounded-3xl bg-bg-base p-8 shadow-xl shadow-slate-200/70">

                {{-- Logo --}}
                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand text-white">
                        <i class="bi bi-buildings text-xl"></i>
                    </div>
                    <span class="text-sm font-semibold">SIHUM UNSRI</span>
                </div>

                <h2 class="text-xl font-semibold">Buat akun mahasiswa</h2>

                {{-- Alert Error jika ada salah satu input yang bermasalah --}}
                @if ($errors->any())
                    <div class="mt-4 rounded-xl bg-red-50 p-3 border border-red-100 flex gap-2">
                        <i class="bi bi-exclamation-circle text-red-500 text-sm"></i>
                        <p class="text-[13px] font-medium text-red-600">Mohon periksa kembali data yang Anda masukkan.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="text-sm font-medium">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" 
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('nama') border-red-500 ring-1 ring-red-500 @enderror"
                            placeholder="Nama Lengkap" required>
                        @error('nama') <p class="mt-1 text-[11px] text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    {{-- NIM --}}
                    <div>
                        <label class="text-sm font-medium">NIM</label>
                        <input type="text" name="nim" value="{{ old('nim') }}" 
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('nim') border-red-500 ring-1 ring-red-500 @enderror"
                            placeholder="Nomor Induk Mahasiswa" required>
                        @error('nim') <p class="mt-1 text-[11px] text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('email') border-red-500 ring-1 ring-red-500 @enderror"
                            placeholder="email@student.unsri.ac.id" required>
                        @error('email') <p class="mt-1 text-[11px] text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="text-sm font-medium">Password</label>
                        <input type="password" name="password" 
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('password') border-red-500 ring-1 ring-red-500 @enderror"
                            placeholder="Minimal 8 karakter" required>
                        @error('password') <p class="mt-1 text-[11px] text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="text-sm font-medium">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" 
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand"
                            placeholder="Ulangi password" required>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-brand py-3 text-sm font-medium text-white shadow-sm hover:shadow-md transition-all active:scale-[0.98]">
                        Daftar Akun
                    </button>

                    <p class="text-center text-sm text-content-sub">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-brand font-medium hover:underline">
                            Masuk
                        </a>
                    </p>

                </form>
            </div>
        </div>
    </section>
</x-auth-layout>