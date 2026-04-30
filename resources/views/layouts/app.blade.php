<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIHUM UNSRI')</title>
    <style>
        :root {
            --bg: #f8fafc;
            --panel: #ffffff;
            --line: #dce5f0;
            --text: #1f2937;
            --subtext: #475569;
            --brand: #0f766e;
            --brand-soft: #ccfbf1;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background: var(--bg);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 1.25rem;
        }

        .site-header {
            background: var(--panel);
            border-bottom: 1px solid var(--line);
        }

        .header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .logo {
            font-weight: 700;
            color: var(--brand);
            text-decoration: none;
        }

        .nav-list {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .nav-list a {
            text-decoration: none;
            color: var(--subtext);
            padding: 0.35rem 0.65rem;
            border-radius: 999px;
        }

        .nav-list a:hover {
            background: var(--brand-soft);
            color: var(--brand);
        }

        .page-head {
            margin: 1.1rem 0;
            padding: 1rem;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--panel);
        }

        .page-head h1 {
            margin: 0;
            font-size: 1.4rem;
        }

        .page-head p {
            margin: 0.5rem 0 0;
            color: var(--subtext);
        }

        .placeholder-card {
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--panel);
            padding: 1rem;
        }

        .placeholder-card h2 {
            margin: 0;
            font-size: 1.08rem;
        }

        .placeholder-card p {
            margin: 0.5rem 0 0;
            color: var(--subtext);
        }

        .site-footer {
            border-top: 1px solid var(--line);
            margin-top: 1.3rem;
            background: var(--panel);
        }

        .site-footer p {
            margin: 0;
            color: var(--subtext);
            font-size: 0.9rem;
            padding: 1rem 0;
        }
    </style>

    @stack('head')

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    @include('components.site-header')

    <main class="container">
        <section class="page-head">
            <h1>@yield('heading', 'SIHUM UNSRI')</h1>
            <p>@yield('subheading', 'Ayok Mondok di UNSRI.')</p>
        </section>

        @yield('content')
    </main>

    @include('components.site-footer')
</body>
</html>