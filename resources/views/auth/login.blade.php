<x-auth-layout>
    <x-slot:title>Masuk | SIHUM UNSRI</x-slot:title>

    <section class="flex min-h-screen items-center px-4 py-12">
        <div class="mx-auto w-full items-center justify-center gap-10">
            {{-- Form --}}
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

                <form method="POST" action="#" class="mt-6 space-y-5">
                    @csrf

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
                            placeholder="Masukkan password"
                        >
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 text-content-sub">
                            <input type="checkbox" class="rounded">
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