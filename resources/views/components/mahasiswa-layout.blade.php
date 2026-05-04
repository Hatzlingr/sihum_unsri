@props([
    'title' => 'Mahasiswa SIHUM UNSRI',
    'pageTitle' => null,
    'active' => 'dashboard',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - SIHUM UNSRI</title>

    @stack('head')

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen bg-bg-base font-sans text-content-main antialiased selection:bg-brand-soft selection:text-brand">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-bg-base">
        <div
            x-cloak
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 z-40 bg-content-main/40 lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        <x-mahasiswa.sidebar :active="$active" />

        <div class="min-h-screen lg:pl-72">
            <header class="sticky top-0 z-30 border-b border-border-soft bg-bg-base/95 backdrop-blur">
                <div class="flex h-16 items-center gap-4 px-4 sm:px-6 lg:px-8">
                    <button
                        type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-border-soft text-content-main transition hover:bg-brand-light lg:hidden"
                        @click="sidebarOpen = true"
                        aria-label="Buka menu mahasiswa"
                    >
                        <i class="bi bi-list text-2xl"></i>
                    </button>

                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-content-sub sm:hidden">Mahasiswa</p>
                        <h1 class="truncate text-lg font-semibold text-content-main sm:text-2xl">
                            {{ $pageTitle ?? $title }}
                        </h1>
                    </div>

                    <div class="hidden items-center gap-3 rounded-2xl border border-border-soft bg-bg-surface px-3 py-2 sm:flex">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-soft text-brand">
                            <i class="bi bi-mortarboard"></i>
                        </span>
                        <div class="leading-tight">
                            <p class="text-sm font-semibold">{{ auth()->user()->name ?? 'Mahasiswa' }}</p>
                            <p class="text-xs text-content-sub">SIHUM UNSRI</p>
                        </div>
                    </div>
                </div>
            </header>

            <main class="mx-auto w-full max-w-[1440px] px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
