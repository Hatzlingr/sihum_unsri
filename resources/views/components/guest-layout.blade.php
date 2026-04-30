<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SIHUM UNSRI' }}</title>

    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    @stack('head')

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-bg-base font-sans text-content-main antialiased selection:bg-brand-soft selection:text-brand">
    <x-site-header />

    <main class="mx-auto px-4 lg:px-8">
        {{ $slot }}
    </main>

    <x-site-footer />
</body>
</html>
