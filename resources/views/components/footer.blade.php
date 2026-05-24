<footer class="piePagina">
    <div class="pieSuperior">
        <div class="columnaPie columnaMarca">
            <div class="marca">
                <i class="fa-solid fa-leaf iconoMarca"></i>
                {{ \Illuminate\Support\Facades\Cache::get('shop_name', 'LA BOTICA NATURAL') }}
            </div>
            <p>Bienestar diario inspirado en la naturaleza. Ofrecemos los mejores productos botánicos artesanales para cuidar tu cuerpo y mente de forma sostenible.</p>
            <div class="redesSociales">
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>

        <div class="columnaPie">
            <h3>TIENDA</h3>
            <ul>
                <li><a href="{{ route('catalog.index') }}">Todos los Productos</a></li>
                <li><a href="{{ url('/#categorias') }}">Categorías</a></li>
                <li><a href="{{ url('/#novedades') }}">Novedades</a></li>
                <li><a href="{{ url('/#sobre-nosotros') }}">Sobre Nosotros</a></li>
            </ul>
        </div>

        <div class="columnaPie">
            <h3>CONTACTO</h3>
            <ul class="listaContacto">
                <li><i class="fa-solid fa-location-dot"></i> {{ \Illuminate\Support\Facades\Cache::get('shop_address', 'Calle de la Naturaleza, 42, 28014 Madrid') }}</li>
                <li><i class="fa-solid fa-phone"></i> {{ \Illuminate\Support\Facades\Cache::get('shop_phone', '+34 900 123 456') }}</li>
                <li><i class="fa-regular fa-envelope"></i> {{ \Illuminate\Support\Facades\Cache::get('shop_email', 'contacto@laboticanatural.com') }}</li>
            </ul>
        </div>

        <div class="columnaPie columnaNewsletter">
            <h3>NEWSLETTER</h3>
            <p>Suscríbete para recibir consejos sobre bienestar natural y ofertas exclusivas.</p>
            <form class="formularioNewsletter" action="#">
                <input type="email" placeholder="Tu email" class="inputNewsletter" required>
                <button type="submit" class="boton botonPrincipal">SUSCRIBIRME</button>
            </form>
        </div>
    </div>

    <div class="pieInferior">
        <div class="derechos">
            &copy; 2026 {{ \Illuminate\Support\Facades\Cache::get('shop_name', 'La Botica Natural') }}. Todos los derechos reservados.
        </div>
        <div class="enlacesLegales">
            <a href="#">Aviso Legal</a>
            <a href="#">Privacidad</a>
            <a href="#">Cookies</a>
        </div>
        <div class="metodosPago">
            <span class="iconoPago">VISA</span>
            <span class="iconoPago">MC</span>
            <span class="iconoPago">PP</span>
        </div>
    </div>
</footer>
