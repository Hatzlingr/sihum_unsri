<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SIHUM UNSRI')</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-bg-surface text-content-main antialiased">

    {{-- Sidebar + Main layout --}}
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 shrink-0 bg-white border-r border-border-soft flex flex-col">
            {{-- Brand --}}
            <div class="flex items-center gap-3 px-6 py-5 border-b border-border-soft">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand text-white">
                    <i class="bi bi-buildings text-lg"></i>
                </div>
                <span class="font-semibold text-sm">SIHUM UNSRI</span>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-4 py-4 space-y-1 text-sm">
                @yield('sidebar-nav')
            </nav>

            {{-- User info + Logout --}}
            <div class="px-4 py-4 border-t border-border-soft">
                <div class="mb-3 px-2">
                    <p class="text-xs text-content-sub">Login sebagai</p>
                    <p class="font-medium text-sm truncate">{{ Auth::user()->username }}</p>
                    <span class="inline-block mt-1 text-xs bg-brand-soft text-brand px-2 py-0.5 rounded-full">
                        {{ Auth::user()->role }}
                    </span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-sm text-red-500 hover:bg-red-50 transition">
                        <i class="bi bi-box-arrow-right"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Top bar --}}
            <header class="bg-white border-b border-border-soft px-8 py-4">
                <h1 class="text-lg font-semibold">@yield('heading', 'Dashboard')</h1>
                @hasSection('subheading')
                    <p class="text-sm text-content-sub mt-0.5">@yield('subheading')</p>
                @endif
            </header>

            {{-- Page content --}}
            <main class="flex-1 p-8">
                @yield('content')
            </main>
        </div>

    </div>

</body>
</html>
