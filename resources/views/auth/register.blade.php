<x-auth-layout>
    <x-slot:title>Daftar | SIHUM UNSRI</x-slot:title>

    <section class="flex min-h-screen items-center px-4 py-12">
        <div class="mx-auto w-full items-center justify-center">

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
                    Buat akun mahasiswa
                </h2>

                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="mt-4 rounded-xl bg-red-50 p-4">
                        <ul class="list-inside list-disc text-sm text-red-800">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="text-sm font-medium">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('nama') ring-2 ring-red-500 @enderror"
                            placeholder="Nama lengkap"
                            required
                            autofocus
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIM --}}
                    <div>
                        <label class="text-sm font-medium">
                            NIM <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nim"
                            value="{{ old('nim') }}"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('nim') ring-2 ring-red-500 @enderror"
                            placeholder="Nomor Induk Mahasiswa"
                            required
                        >
                        @error('nim')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="text-sm font-medium">
                            Program Studi <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="prodi"
                            value="{{ old('prodi') }}"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('prodi') ring-2 ring-red-500 @enderror"
                            placeholder="Contoh: Teknik Informatika"
                            required
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            No. HP
                        </label>
                        <input
                            type="text"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('no_hp') ring-2 ring-red-500 @enderror"
                            placeholder="08xxxxxxxxxx"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('username') ring-2 ring-red-500 @enderror"
                            placeholder="username"
                            required
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('password') ring-2 ring-red-500 @enderror"
                            placeholder="Minimal 8 karakter"
                            required
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label class="text-sm font-medium">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand @error('password_confirmation') ring-2 ring-red-500 @enderror"
                            placeholder="Ulangi password"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-brand py-3 text-sm font-medium text-white shadow-sm hover:shadow-md"
                    >
                        Daftar
                    </button>

                    <p class="text-center text-sm text-content-sub">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-brand font-medium">
                            Masuk
                        </a>
                    </p>

                </form>
            </div>

        </div>
    </section>
</x-auth-layout>