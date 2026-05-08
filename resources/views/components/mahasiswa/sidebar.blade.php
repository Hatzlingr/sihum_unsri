@props(['active' => 'dashboard'])

@php
    $routeUrl = static fn(string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
    $logoutAction = \Illuminate\Support\Facades\Route::has('logout') ? route('logout') : url('/logout');

    $groups = [
        'Utama' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'mahasiswa.dashboard', 'fallback' => '/mahasiswa/dashboard'],
            ['key' => 'hunian', 'label' => 'Hunian', 'icon' => 'bi-buildings', 'route' => 'mahasiswa.hunian', 'fallback' => '/mahasiswa/hunian'],
            ['key' => 'pengajuan', 'label' => 'Pengajuan Hunian', 'icon' => 'bi-file-earmark-plus', 'route' => 'mahasiswa.pengajuan', 'fallback' => '/mahasiswa/pengajuan'],
            ['key' => 'pembayaran', 'label' => 'Pembayaran', 'icon' => 'bi-credit-card', 'route' => 'mahasiswa.pembayaran', 'fallback' => '/mahasiswa/pembayaran'],
        ],
        'Layanan' => [
            ['key' => 'pindah-kamar', 'label' => 'Pindah Kamar', 'icon' => 'bi-arrow-left-right', 'route' => 'mahasiswa.pindah-kamar', 'fallback' => '/mahasiswa/pindah-kamar'],
            ['key' => 'pemberhentian', 'label' => 'Ajukan Pemberhentian', 'icon' => 'bi-box-arrow-right', 'route' => 'mahasiswa.pemberhentian', 'fallback' => '/mahasiswa/pemberhentian'],
        ],
        'Akun' => [
            ['key' => 'biodata', 'label' => 'Biodata', 'icon' => 'bi-person-lines-fill', 'route' => 'mahasiswa.biodata', 'fallback' => '/mahasiswa/biodata'],
            ['key' => 'pengaturan', 'label' => 'Pengaturan', 'icon' => 'bi-gear', 'route' => 'mahasiswa.pengaturan', 'fallback' => '/mahasiswa/pengaturan'],
        ],
    ];
@endphp

<aside
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-border-soft bg-bg-base transition-transform duration-300 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
    <!-- Bagian Header Sidebar -->
    <div class="flex h-24 items-center gap-4 border-b border-border-soft px-6">
        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-brand-soft text-brand">
            <i class="bi bi-mortarboard text-2xl"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xs font-medium uppercase tracking-wider text-content-sub">Welcome</p>
            <p class="truncate text-lg font-bold leading-tight text-content-main">
                Mahasiswa
            </p>
        </div>
        <button type="button"
            class="ml-auto inline-flex h-9 w-9 items-center justify-center rounded-xl text-content-sub hover:bg-brand-light hover:text-brand lg:hidden"
            @click="sidebarOpen = false">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <!-- Bagian Navigasi -->
    <nav class="flex-1 space-y-7 overflow-y-auto px-4 py-6">
        @foreach ($groups as $groupLabel => $items)
            <div>
                <p class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-content-sub/60">
                    {{ $groupLabel }}
                </p>
                <div class="space-y-1">
                    @foreach ($items as $item)
                        <!-- Tetapkan logika isActive Anda di sini -->
                        @php
                            $fallbackPattern = ltrim($item['fallback'], '/') . '*';
                            $isActive = $active === $item['key'] || request()->is($fallbackPattern);
                        @endphp

                        <!-- Pastikan nama komponen nav-link sesuai (x-admin, x-mahasiswa, atau x-pengelola) -->
                        <x-admin.nav-link :href="$routeUrl($item['route'], $item['fallback'])" :icon="$item['icon']"
                            :active="$isActive" @click="sidebarOpen = false">
                            {{ $item['label'] }}
                        </x-admin.nav-link>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <!-- Bagian Footer Logout -->
    <div class="border-t border-border-soft p-5">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit"
                class="group flex w-full items-center gap-3 rounded-xl border border-red-500 bg-red-500 px-4 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-white hover:text-red-600">
                <i class="bi bi-box-arrow-right text-lg transition-colors group-hover:text-red-500"></i>
                <span class="tracking-wide">Keluar Sistem</span>
                <i class="bi bi-chevron-right ml-auto text-[10px] transition-all group-hover:translate-x-1"></i>
            </button>
        </form>
    </div>
</aside>