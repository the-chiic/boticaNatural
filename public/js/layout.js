document.addEventListener('DOMContentLoaded', function () {
    const botonUsuario = document.getElementById('botonUsuario');
    const menuUsuario = document.getElementById('menuUsuario');

    if (!botonUsuario || !menuUsuario) {
        return;
    }

    const cerrarMenu = () => {
        menuUsuario.classList.remove('activo');
        botonUsuario.setAttribute('aria-expanded', 'false');
    };

    const abrirMenu = () => {
        menuUsuario.classList.add('activo');
        botonUsuario.setAttribute('aria-expanded', 'true');
    };

    botonUsuario.addEventListener('click', function (e) {
        e.stopPropagation();
        if (menuUsuario.classList.contains('activo')) {
            cerrarMenu();
        } else {
            abrirMenu();
        }
    });

    document.addEventListener('click', function (e) {
        if (!menuUsuario.contains(e.target) && !botonUsuario.contains(e.target)) {
            cerrarMenu();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            cerrarMenu();
        }
    });
});
