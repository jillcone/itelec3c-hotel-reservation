<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Aurum Hotel' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-900 antialiased">
    <div class="min-h-screen flex flex-col">
        <x-navbar />

        <main class="flex-1">
            {{ $slot }}
        </main>

        <x-footer />
    </div>
</body>
</html>
