@props(['active' => 'dashboard'])

@php
    $routeUrl = static fn(string $name, string $fallback) => \Illuminate\Support\Facades\Route::has($name) ? route($name) : url($fallback);
    $logoutAction = \Illuminate\Support\Facades\Route::has('logout') ? route('logout') : url('/logout');

    $groups = [
        'Utama' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'admin.dashboard', 'fallback' => '/admin/dashboard'],
            ['key' => 'mahasiswa', 'label' => 'Mahasiswa', 'icon' => 'bi-mortarboard', 'route' => 'admin.mahasiswa.index', 'fallback' => '/admin/mahasiswa'],
            ['key' => 'hunian', 'label' => 'Hunian', 'icon' => 'bi-buildings', 'route' => 'admin.hunian.index', 'fallback' => '/admin/hunian'],
            ['key' => 'kamar', 'label' => 'Kamar', 'icon' => 'bi-door-open', 'route' => 'admin.kamar.index', 'fallback' => '/admin/kamar'],
        ],
        'Proses' => [
            ['key' => 'pendaftaran', 'label' => 'Verifikasi Pendaftaran', 'icon' => 'bi-file-earmark-check', 'route' => 'admin.pendaftaran.index', 'fallback' => '/admin/pendaftaran'],
            ['key' => 'pembayaran', 'label' => 'Verifikasi Pembayaran', 'icon' => 'bi-credit-card', 'route' => 'admin.pembayaran.index', 'fallback' => '/admin/pembayaran'],
            ['key' => 'penempatan', 'label' => 'Penempatan', 'icon' => 'bi-pin-map', 'route' => 'admin.penempatan.index', 'fallback' => '/admin/penempatan'],
            ['key' => 'pindah-kamar', 'label' => 'Pindah Kamar', 'icon' => 'bi-arrow-left-right', 'route' => 'admin.pindah-kamar.index', 'fallback' => '/admin/pindah-kamar'],
        ],
        'Sistem' => [
            ['key' => 'laporan', 'label' => 'Laporan', 'icon' => 'bi-clipboard-data', 'route' => 'admin.laporan.index', 'fallback' => '/admin/laporan'],
            ['key' => 'akun', 'label' => 'Akun', 'icon' => 'bi-person-gear', 'route' => 'admin.pengelola.index', 'fallback' => '/admin/pengelola'],
            ['key' => 'activity-log', 'label' => 'Activity Log', 'icon' => 'bi-activity', 'route' => 'admin.activity-log.index', 'fallback' => '/admin/activity-log'],
        ],
    ];
@endphp

<aside
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-border-soft bg-bg-base transition-transform duration-300 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
    <div class="flex h-24 items-center gap-4 border-b border-border-soft px-6">
        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-brand-soft text-brand">
            <i class="bi bi-person-circle text-2xl"></i>
        </div>
        <div class="min-w-0">
            <p class="text-xl font-semibold leading-tight text-content-main">Welcome</p>
            <p class="text-xl font-semibold leading-tight text-content-main">Admin</p>
        </div>
        <button type="button"
            class="ml-auto inline-flex h-9 w-9 items-center justify-center rounded-xl text-content-sub hover:bg-brand-light hover:text-brand lg:hidden"
            @click="sidebarOpen = false" aria-label="Tutup menu admin">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <nav class="flex-1 space-y-7 overflow-y-auto px-4 py-6">
        @foreach ($groups as $groupLabel => $items)
            <div>
                <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-[0.22em] text-content-sub/80">{{ $groupLabel }}
                </p>
                <div class="space-y-1">
                    @foreach ($items as $item)
                        @php
                            $fallbackPattern = ltrim($item['fallback'], '/') . '*';
                            $isActive = $active === $item['key'] || request()->is($fallbackPattern);
                        @endphp
                        <x-admin.nav-link :href="$routeUrl($item['route'], $item['fallback'])" :icon="$item['icon']"
                            :active="$isActive" @click="sidebarOpen = false">
                            {{ $item['label'] }}
                        </x-admin.nav-link>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <div class="border-t border-border-soft p-4">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit"
                class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-red-600 transition-all hover:bg-red-50">
                <i class="bi bi-box-arrow-right text-lg"></i>
                <span>Keluar Sistem</span>
            </button>
        </form>
    </div>
</aside>