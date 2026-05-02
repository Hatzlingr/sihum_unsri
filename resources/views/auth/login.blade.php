{{-- resources/views/auth/login.blade.php --}}
<x-auth-layout>
    <x-slot:title>Masuk | SIHUM UNSRI</x-slot:title>

    <section class="flex min-h-screen items-center px-4 py-12">
        <div class="mx-auto w-full items-center justify-center gap-10">

            {{-- Tombol Back --}}
            <div class="mx-auto mb-4 w-full max-w-md">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-medium text-content-sub transition hover:text-brand">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Beranda
                </a>
            </div>
            <div class="mx-auto w-full max-w-md rounded-3xl bg-bg-base p-8 shadow-xl shadow-slate-200/70">

                {{-- Logo --}}
                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand text-white">
                        <i class="bi bi-buildings text-xl"></i>
                    </div>
                    <span class="text-sm font-semibold">
                        SIHUM UNSRI
                    </span>
                </div>

                <h2 class="text-xl font-semibold">
                    Masuk ke akun
                </h2>

                @if (session('success'))
                    <div class="mt-4 rounded-xl bg-brand-light px-4 py-3 text-sm text-brand font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label class="text-sm font-medium">NIM</label>
                        <input
                            type="text"
                            name="nim"
                            value="{{ old('nim') }}"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('nim') ring-2 ring-red-400 @enderror"
                            placeholder="Nomor Induk Mahasiswa"
                            autofocus
                        >
                        @error('nim')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('password') ring-2 ring-red-400 @enderror"
                            placeholder="Masukkan password"
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 text-content-sub">
                            <input type="checkbox" name="remember" class="rounded">
                            Ingat saya
                        </label>

                        <a href="#" class="text-brand hover:underline">
                            Lupa password?
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-brand py-3 text-sm font-medium text-white shadow-sm hover:shadow-md"
                    >
                        Masuk
                    </button>

                    <p class="text-center text-sm text-content-sub">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-brand font-medium">
                            Daftar
                        </a>
                    </p>

                </form>
            </div>

        </div>
    </section>
</x-auth-layout>