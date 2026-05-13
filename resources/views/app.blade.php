<!DOCTYPE html>
<html lang="es">
    <head>
        @include('head')
        @stack('style')
    </head>
    <body>
        @yield('navbar')

        <main>
            @yield('content')
        </main>

        @include('components.footer')

        @stack('scripts')
    </body>
</html>
