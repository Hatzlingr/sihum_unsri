@php
    $navItems = [
        ['label' => 'Beranda', 'route' => 'home', 'active' => request()->routeIs('home')],
        ['label' => 'Hunian', 'route' => 'hunian.index', 'active' => request()->routeIs('hunian.*')],
        ['label' => 'Panduan', 'route' => 'panduan', 'active' => request()->routeIs('panduan')],
        ['label' => 'FAQ', 'route' => 'faq', 'active' => request()->routeIs('faq')],
        ['label' => 'Kontak', 'route' => 'kontak', 'active' => request()->routeIs('kontak')],
    ];
@endphp

<div class="h-20"></div>

<header
    x-data="{
        mobileMenuOpen: false,
        isHidden: false,
        lastScroll: 0,
        handleScroll() {
            const currentScroll = window.scrollY;

            if (currentScroll <= 0) {
                this.isHidden = false;
            } else if (currentScroll > this.lastScroll && currentScroll > 96) {
                this.isHidden = true;
                this.mobileMenuOpen = false;
            } else {
                this.isHidden = false;
            }

            this.lastScroll = currentScroll;
        }
    }"
    @scroll.window="handleScroll"
    :class="{ '-translate-y-full': isHidden }"
    class="fixed inset-x-0 top-0 z-50 bg-bg-base/75 shadow-sm backdrop-blur-xl transition-transform duration-300 px-4 lg:px-8"
>
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-5 px-5 py-4">
        <a href="{{ route('home') }}" class="group inline-flex items-center gap-3 rounded-full text-brand transition">
            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand text-white shadow-md shadow-brand/20 transition duration-300 group-hover:-translate-y-0.5">
                <i class="bi bi-buildings text-xl"></i>
            </span>
            <span class="leading-tight">
                <span class="block text-lg font-black tracking-tight">SIHUM UNSRI</span>
                <span class="block text-xs font-semibold text-content-sub">Sistem Informasi Hunian Mahasiswa</span>
            </span>
        </a>

        <nav aria-label="Navigasi utama" class="hidden items-center gap-2 lg:flex">
            @foreach ($navItems as $item)
                <a
                    href="{{ route($item['route']) }}"
                    @class([
                        'rounded-full px-4 py-2 text-sm font-bold transition duration-300',
                        'bg-brand-soft text-brand shadow-sm' => $item['active'],
                        'text-content-sub hover:bg-brand-soft hover:text-brand' => ! $item['active'],
                    ])
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="hidden items-center gap-3 lg:flex">
            <a href="{{ route('login') }}" class="rounded-full px-4 py-2 text-sm font-bold text-content-sub transition hover:bg-bg-surface hover:text-brand">
                Login Su
            </a>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-full bg-brand px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-brand/20 transition duration-300 hover:-translate-y-0.5 hover:bg-brand/90 hover:shadow-xl hover:shadow-brand/20">
                Daftar
            </a>
        </div>

        <button
            type="button"
            class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-bg-surface text-content-main shadow-sm transition hover:bg-brand-soft hover:text-brand lg:hidden"
            @click="mobileMenuOpen = !mobileMenuOpen"
            :aria-expanded="mobileMenuOpen.toString()"
            aria-label="Buka menu navigasi"
        >
            <i class="bi text-2xl" :class="mobileMenuOpen ? 'bi-x' : 'bi-list'"></i>
        </button>
    </div>

    <div
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-3"
        class="lg:hidden"
       
    >
        <div class="mx-5 mb-5 rounded-4xl bg-bg-base p-3 shadow-xl shadow-slate-200/80">
            <div class="space-y-1">
                @foreach ($navItems as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        @class([
                            'flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-bold transition',
                            'bg-brand-soft text-brand' => $item['active'],
                            'text-content-sub hover:bg-bg-surface hover:text-brand' => ! $item['active'],
                        ])
                    >
                        <span>{{ $item['label'] }}</span>
                        @if ($item['active'])
                            <i class="bi bi-check2-circle"></i>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="mt-3 grid grid-cols-2 gap-3">
                <a href="{{ route('login') }}" class="rounded-2xl bg-bg-surface px-4 py-3 text-center text-sm font-bold text-content-main transition hover:bg-brand-soft hover:text-brand">
                    Login Su
                </a>
                <a href="{{ route('register') }}" class="rounded-2xl bg-brand px-4 py-3 text-center text-sm font-bold text-white shadow-md shadow-brand/20 transition hover:bg-brand/90">
                    Daftar
                </a>
            </div>
        </div>
    </div>
</header>
