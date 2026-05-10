<!DOCTYPE html>
<html>
    <head>
        @include('head')
        @stack('style')
    </head>
    <body>
        @yield('navbar')

        <main>
            @yield('content')
        </main>

        @include('footer')

        @stack('scripts')
    </body>
</html>
