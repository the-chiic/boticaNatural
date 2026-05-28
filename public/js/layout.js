document.addEventListener('DOMContentLoaded', function () {
    // 1. Desktop User Dropdown Menu
    const botonUsuario = document.getElementById('botonUsuario');
    const menuUsuario = document.getElementById('menuUsuario');

    if (botonUsuario && menuUsuario) {
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
    }

    // 2. Mobile Hamburger Drawer Menu Toggle Lógica
    const btnHamburger = document.getElementById('btnHamburger');
    const btnCerrarDrawer = document.getElementById('btnCerrarDrawer');
    const menuMovilDrawer = document.getElementById('menuMovilDrawer');
    const menuMovilOverlay = document.getElementById('menuMovilOverlay');

    if (btnHamburger && menuMovilDrawer && menuMovilOverlay) {
        const abrirDrawer = () => {
            menuMovilDrawer.classList.add('activo');
            menuMovilOverlay.classList.add('activo');
            document.body.style.overflow = 'hidden'; // Evita el scroll del fondo
        };

        const cerrarDrawer = () => {
            menuMovilDrawer.classList.remove('activo');
            menuMovilOverlay.classList.remove('activo');
            document.body.style.overflow = ''; // Restaura el scroll
        };

        btnHamburger.addEventListener('click', abrirDrawer);
        if (btnCerrarDrawer) btnCerrarDrawer.addEventListener('click', cerrarDrawer);
        menuMovilOverlay.addEventListener('click', cerrarDrawer);
    }
});
