<x-auth-layout>
    <x-slot:title>Masuk | SIHUM UNSRI</x-slot:title>

    <section class="flex min-h-screen items-center px-4 py-12">
        <div class="mx-auto w-full items-center justify-center gap-10">
            {{-- Form --}}
            <div class="mx-auto w-full max-w-md rounded-3xl bg-bg-base p-8 shadow-xl shadow-slate-200/70">

                {{-- Tombol Kembali --}}
                <a href="{{ url('/') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-content-sub transition-colors hover:text-brand">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

                {{-- Logo --}}
                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand text-white">
                        <i class="bi bi-buildings text-xl"></i>
                    </div>
                    <span class="text-sm font-semibold">SIHUM UNSRI</span>
                </div>

                <h2 class="text-xl font-semibold">Masuk ke akun</h2>

                {{-- Alert Error Umum --}}
                @if ($errors->any())
                    <div class="mt-4 rounded-xl bg-red-50 p-3 border border-red-100">
                        <div class="flex gap-2">
                            <i class="bi bi-exclamation-circle text-red-500 text-sm"></i>
                            <p class="text-[13px] font-medium text-red-600">Terjadi kesalahan pada login Anda.</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                    @csrf

                    {{-- Username Field --}}
                    <div>
                        <label class="text-sm font-medium">NIM</label>
                        <input type="text" name="username" 
                            value="{{ old('username') }}"
                            {{-- py-2.5 dan leading-relaxed agar teks simetris di tengah --}}
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-2.5 text-sm leading-relaxed outline-none transition-all focus:ring-1 focus:ring-brand @error('username') border border-red-500 ring-1 ring-red-500 @enderror"
                            placeholder="Masukkan NIM Anda" required>
                        
                        @error('username')
                            <p class="mt-1.5 text-[11px] font-medium text-red-500 flex items-center gap-1">
                                <i class="bi bi-info-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div>
                        <label class="text-sm font-medium">Password</label>
                        <input
                            type="password"
                            name="password"
                            {{-- py-2.5 agar kotak lebih ramping --}}
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-2.5 text-sm leading-relaxed outline-none transition-all focus:ring-1 focus:ring-brand @error('password') border border-red-500 ring-1 ring-red-500 @enderror"
                            placeholder="Masukkan password"
                            required
                        >

                        @error('password')
                            <p class="mt-1.5 text-[11px] font-medium text-red-500 flex items-center gap-1">
                                <i class="bi bi-info-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 text-content-sub cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded text-brand focus:ring-brand">
                            Ingat saya
                        </label>

                        <a href="{{ route('password.request') }}" class="text-brand hover:underline">
                            Lupa password?
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-brand py-3 text-sm font-medium text-white shadow-sm hover:shadow-md transition-all active:scale-[0.98]"
                    >
                        Masuk
                    </button>

                    <p class="text-center text-sm text-content-sub">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-brand font-medium hover:underline">
                            Daftar
                        </a>
                    </p>

                </form>
            </div>
        </div>
    </section>
</x-auth-layout>