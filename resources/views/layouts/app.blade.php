<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Botica Natural</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Link -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Navbar Component -->
    @include('components.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Component -->
    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonUsuario = document.getElementById('botonUsuario');
            const menuUsuario = document.getElementById('menuUsuario');

            if (botonUsuario && menuUsuario) {
                botonUsuario.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menuUsuario.classList.toggle('activo');
                });

                document.addEventListener('click', function(e) {
                    if (!menuUsuario.contains(e.target) && !botonUsuario.contains(e.target)) {
                        menuUsuario.classList.remove('activo');
                    }
                });
            }
        });
    </script>
</body>
</html>
