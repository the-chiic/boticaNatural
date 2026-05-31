<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Panel Admin - Herbolario' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @stack('styles')
</head>
<body>
    <x-admin.sidebar />

    <main class="main">
        <x-admin.header :title="$headerTitle ?? $title" :subtitle="$subtitle ?? ''" />

        {{ $slot }}
    </main>

    @stack('scripts')
</body>
</html>
