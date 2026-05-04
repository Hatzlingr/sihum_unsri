<x-auth-layout>
    <x-slot:title>Lupa Password | SIHUM UNSRI</x-slot:title>

    <section class="flex min-h-screen items-center px-4 py-12">
        <div class="mx-auto w-full items-center justify-center">
            <div class="mx-auto w-full max-w-md rounded-3xl bg-bg-base p-8 shadow-xl shadow-slate-200/70 text-center">

                {{-- Logo SIHUM --}}
                <div class="mb-8 flex flex-col items-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-orange-100 text-orange-600 mb-4">
                        <i class="bi bi-shield-lock text-3xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">Lupa Password?</h2>
                </div>

                <div class="bg-bg-surface rounded-2xl p-6 mb-8">
                    <p class="text-sm text-content-sub leading-relaxed">
                        Demi keamanan data di <span class="font-semibold">SIHUM UNSRI</span>, reset password dilakukan secara manual oleh Admin. 
                        Silakan hubungi kami melalui WhatsApp untuk verifikasi identitas.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-8 space-y-4">
                    <a href="https://wa.me/6285266769371?text=Halo%20Admin%20SIHUM,%20saya%20lupa%20password%20akun%20mahasiswa.%20Mohon%20bantuannya%20untuk%20reset%20password." 
                    target="_blank"
                    class="flex w-full items-center justify-center gap-3 rounded-xl bg-brand py-3 text-sm font-semibold text-white shadow-sm hover:opacity-90 transition-all">
                        <i class="bi bi-whatsapp text-lg"></i>
                        Hubungi Admin via WhatsApp
                    </a>
                    
                    <a href="{{ route('login') }}" class="block text-sm font-medium text-brand hover:underline">
                        Kembali ke Halaman Login
                    </a>
                </div>

                {{-- Jam Operasional --}}
                <div class="mt-10 border-t border-slate-300 pt-6">
                    <div class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-4 py-1.5 text-[10px] font-medium text-slate-500 uppercase tracking-wider">
                        <i class="bi bi-clock"></i>
                        Jam Kerja: Senin - Jumat (08.00 - 16.00)
                    </div>
                </div>
                
            </div>
        </div>
    </section>
</x-auth-layout>