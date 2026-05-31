@extends('landingPage')

@push('meta')
    <meta name="description" content="Aviso Legal de La Botica Natural. Información legal, responsabilidad, propiedad intelectual y condiciones de uso del sitio web.">
@endpush

@section('main_content')
<div style="background: var(--brand-cream); min-height: 80vh; padding: 5rem 1.5rem 6rem;">
    <div class="container" style="max-width: 820px; margin: 0 auto;">

        <!-- Hero cabecera legal -->
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <span style="display: inline-block; font-family: var(--fuente-sans); font-size: 0.7rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--brand-accent); background: rgba(139,111,74,0.08); border: 1px solid rgba(139,111,74,0.2); border-radius: 9999px; padding: 0.35rem 1rem; margin-bottom: 1.25rem;">
                <i class="fa-solid fa-scale-balanced" style="margin-right: 0.4rem;"></i> Información Legal
            </span>
            <h1 style="font-family: var(--fuente-serif); font-size: 2.6rem; font-weight: 500; color: var(--brand-green); margin-bottom: 0.75rem; line-height: 1.2;">Aviso Legal</h1>
            <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.6); max-width: 480px; margin: 0 auto;">Última actualización: {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}</p>
            <div style="width: 60px; height: 2px; background: var(--brand-accent); margin: 1.5rem auto 0; border-radius: 9999px;"></div>
        </div>

        <!-- Tarjeta de contenido -->
        <div style="background: #ffffff; border-radius: 1.5rem; border: 1px solid rgba(27,48,34,0.06); box-shadow: 0 8px 30px rgba(27,48,34,0.04); padding: 3rem 3.5rem; line-height: 1.8; color: var(--brand-green);">

            @php
                $shopName = \Illuminate\Support\Facades\Cache::get('shop_name', 'La Botica Natural');
                $shopAddress = \Illuminate\Support\Facades\Cache::get('shop_address', 'Calle de la Naturaleza, 42, 28014 Madrid');
                $shopEmail = \Illuminate\Support\Facades\Cache::get('shop_email', 'contacto@laboticanatural.com');
            @endphp

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">1. Datos Identificativos</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    En cumplimiento del artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y del Comercio Electrónico (LSSI-CE), se informa que el titular de este sitio web es:
                </p>
                <ul style="list-style: none; margin-top: 1rem; padding: 0; font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    <li style="padding: 0.4rem 0; display: flex; gap: 0.75rem;"><strong style="color: var(--brand-green); min-width: 140px;">Denominación:</strong> {{ $shopName }}</li>
                    <li style="padding: 0.4rem 0; display: flex; gap: 0.75rem;"><strong style="color: var(--brand-green); min-width: 140px;">Domicilio:</strong> {{ $shopAddress }}</li>
                    <li style="padding: 0.4rem 0; display: flex; gap: 0.75rem;"><strong style="color: var(--brand-green); min-width: 140px;">Correo electrónico:</strong> {{ $shopEmail }}</li>
                    <li style="padding: 0.4rem 0; display: flex; gap: 0.75rem;"><strong style="color: var(--brand-green); min-width: 140px;">Actividad:</strong> Comercio minorista de productos herbolarios y botánicos</li>
                </ul>
            </section>

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">2. Objeto y Aceptación</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    El presente Aviso Legal regula el acceso y la utilización del sitio web de {{ $shopName }}. El acceso al sitio web implica la aceptación plena y sin reservas de todas las disposiciones incluidas en este Aviso Legal.
                </p>
            </section>

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">3. Propiedad Intelectual e Industrial</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    Todos los contenidos del sitio web —incluyendo textos, imágenes, logotipos, diseño gráfico, código fuente y demás elementos— son titularidad de {{ $shopName }} o de terceros que han autorizado su uso, y están protegidos por la legislación española e internacional sobre propiedad intelectual e industrial. Queda prohibida su reproducción total o parcial sin consentimiento expreso y por escrito del titular.
                </p>
            </section>

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">4. Responsabilidad y Limitaciones</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    {{ $shopName }} no se responsabiliza de los daños producidos por el uso del sitio web o de la información contenida en él, de los fallos o interrupciones técnicas, ni de los errores derivados de la navegación o de terceros.
                </p>
            </section>

            <section>
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">5. Legislación Aplicable y Jurisdicción</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    Este Aviso Legal se rige por la legislación española. Para la resolución de cualquier controversia derivada del acceso o uso del sitio web, las partes se someten a la jurisdicción de los Juzgados y Tribunales del domicilio del titular, con renuncia expresa a cualquier otro fuero que pudiera corresponderles.
                </p>
            </section>
        </div>

        <!-- Volver -->
        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; font-family: var(--fuente-sans); font-size: 0.85rem; font-weight: 600; color: var(--brand-green); text-decoration: none; border: 1px solid rgba(27,48,34,0.2); border-radius: 9999px; padding: 0.65rem 1.5rem; transition: all 0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Volver al Inicio
            </a>
        </div>
    </div>
</div>
@endsection
