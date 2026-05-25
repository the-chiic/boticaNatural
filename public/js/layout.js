document.addEventListener('DOMContentLoaded', function () {
    const botonUsuario = document.getElementById('botonUsuario');
    const menuUsuario = document.getElementById('menuUsuario');

    if (botonUsuario && menuUsuario) {
        botonUsuario.addEventListener('click', function (e) {
            e.stopPropagation();
            menuUsuario.classList.toggle('activo');
        });

        document.addEventListener('click', function (e) {
            if (!menuUsuario.contains(e.target) && !botonUsuario.contains(e.target)) {
                menuUsuario.classList.remove('activo');
            }
        });
    }
});
