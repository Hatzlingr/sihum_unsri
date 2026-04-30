<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIHUM UNSRI' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-surface text-content-main">

    <main class="min-h-screen">
        {{ $slot }}
    </main>

</body>
</html>