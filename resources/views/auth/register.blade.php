{{-- resources/views/auth/register.blade.php --}}
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
                    <span class="text-sm font-semibold">
                        SIHUM UNSRI
                    </span>
                </div>

                <h2 class="text-xl font-semibold">
                    Buat akun mahasiswa
                </h2>

                <form method="POST" action="#" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label class="text-sm font-medium">
                            Nama Lengkap
                        </label>
                        <input
                            type="text"
                            name="name"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand"
                            placeholder="Nama lengkap"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            NIM
                        </label>
                        <input
                            type="text"
                            name="nim"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand"
                            placeholder="Nomor Induk Mahasiswa"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand"
                            placeholder="email@unsri.ac.id"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand"
                            placeholder="Minimal 8 karakter"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Konfirmasi Password
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="mt-2 w-full rounded-xl bg-bg-surface px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-brand"
                            placeholder="Ulangi password"
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