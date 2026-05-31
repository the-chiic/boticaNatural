@extends('landingPage')

@push('meta')
    <meta name="description" content="Política de Cookies de La Botica Natural. Información sobre el uso de cookies en el sitio web y cómo gestionarlas.">
@endpush

@section('main_content')
<div style="background: var(--brand-cream); min-height: 80vh; padding: 5rem 1.5rem 6rem;">
    <div class="container" style="max-width: 820px; margin: 0 auto;">

        <!-- Hero cabecera legal -->
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <span style="display: inline-block; font-family: var(--fuente-sans); font-size: 0.7rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--brand-accent); background: rgba(139,111,74,0.08); border: 1px solid rgba(139,111,74,0.2); border-radius: 9999px; padding: 0.35rem 1rem; margin-bottom: 1.25rem;">
                <i class="fa-solid fa-cookie-bite" style="margin-right: 0.4rem;"></i> Cookies
            </span>
            <h1 style="font-family: var(--fuente-serif); font-size: 2.6rem; font-weight: 500; color: var(--brand-green); margin-bottom: 0.75rem; line-height: 1.2;">Política de Cookies</h1>
            <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.6); max-width: 480px; margin: 0 auto;">Última actualización: {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}</p>
            <div style="width: 60px; height: 2px; background: var(--brand-accent); margin: 1.5rem auto 0; border-radius: 9999px;"></div>
        </div>

        <!-- Tarjeta de contenido -->
        <div style="background: #ffffff; border-radius: 1.5rem; border: 1px solid rgba(27,48,34,0.06); box-shadow: 0 8px 30px rgba(27,48,34,0.04); padding: 3rem 3.5rem; line-height: 1.8; color: var(--brand-green);">

            @php $shopName = \Illuminate\Support\Facades\Cache::get('shop_name', 'La Botica Natural'); @endphp

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">1. ¿Qué son las Cookies?</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    Las cookies son pequeños archivos de texto que se almacenan en el dispositivo del usuario al visitar un sitio web. Permiten que el sitio recuerde las preferencias del usuario, mejore su experiencia de navegación y recopile información estadística.
                </p>
            </section>

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">2. Tipos de Cookies que Utilizamos</h2>

                <!-- Tabla de tipos -->
                <div style="overflow-x: auto; margin-top: 1rem;">
                    <table style="width: 100%; border-collapse: collapse; font-family: var(--fuente-sans); font-size: 0.875rem; color: rgba(27,48,34,0.75);">
                        <thead>
                            <tr style="background: rgba(27,48,34,0.03); border-bottom: 2px solid rgba(27,48,34,0.08);">
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--brand-green);">Tipo</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--brand-green);">Finalidad</th>
                                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--brand-green);">Duración</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid rgba(27,48,34,0.05);">
                                <td style="padding: 0.8rem 1rem; font-weight: 600; color: var(--brand-green);">Técnicas / Esenciales</td>
                                <td style="padding: 0.8rem 1rem;">Permiten la navegación y el uso de funciones básicas (sesión de usuario, carrito de compra).</td>
                                <td style="padding: 0.8rem 1rem;">Sesión</td>
                            </tr>
                            <tr style="border-bottom: 1px solid rgba(27,48,34,0.05);">
                                <td style="padding: 0.8rem 1rem; font-weight: 600; color: var(--brand-green);">Preferencias</td>
                                <td style="padding: 0.8rem 1rem;">Recuerdan las preferencias del usuario (idioma, región, configuración del sitio).</td>
                                <td style="padding: 0.8rem 1rem;">1 año</td>
                            </tr>
                            <tr style="border-bottom: 1px solid rgba(27,48,34,0.05);">
                                <td style="padding: 0.8rem 1rem; font-weight: 600; color: var(--brand-green);">Analíticas</td>
                                <td style="padding: 0.8rem 1rem;">Nos permiten analizar el uso del sitio para mejorar su funcionamiento (ej. páginas más visitadas).</td>
                                <td style="padding: 0.8rem 1rem;">2 años</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.8rem 1rem; font-weight: 600; color: var(--brand-green);">Marketing</td>
                                <td style="padding: 0.8rem 1rem;">Utilizadas para mostrar anuncios relevantes al usuario. Solo se activan con consentimiento.</td>
                                <td style="padding: 0.8rem 1rem;">90 días</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">3. Cookies de Terceros</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    {{ $shopName }} puede usar servicios de terceros que instalen sus propias cookies, como Google Analytics, con fines estadísticos. Estos terceros disponen de sus propias políticas de privacidad.
                </p>
            </section>

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">4. Cómo Gestionar las Cookies</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75); margin-bottom: 0.75rem;">
                    Puede configurar su navegador para rechazar o eliminar las cookies. Tenga en cuenta que desactivar ciertas cookies puede afectar al correcto funcionamiento del sitio web.
                </p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-top: 1rem; font-family: var(--fuente-sans); font-size: 0.875rem;">
                    <a href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener" style="display:flex; align-items:center; gap:0.5rem; color: var(--brand-accent); text-decoration:none; padding: 0.65rem 1rem; background: rgba(139,111,74,0.04); border: 1px solid rgba(139,111,74,0.15); border-radius: 0.75rem; font-weight: 500;">
                        <i class="fa-brands fa-chrome"></i> Google Chrome
                    </a>
                    <a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias" target="_blank" rel="noopener" style="display:flex; align-items:center; gap:0.5rem; color: var(--brand-accent); text-decoration:none; padding: 0.65rem 1rem; background: rgba(139,111,74,0.04); border: 1px solid rgba(139,111,74,0.15); border-radius: 0.75rem; font-weight: 500;">
                        <i class="fa-brands fa-firefox"></i> Mozilla Firefox
                    </a>
                    <a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank" rel="noopener" style="display:flex; align-items:center; gap:0.5rem; color: var(--brand-accent); text-decoration:none; padding: 0.65rem 1rem; background: rgba(139,111,74,0.04); border: 1px solid rgba(139,111,74,0.15); border-radius: 0.75rem; font-weight: 500;">
                        <i class="fa-brands fa-safari"></i> Safari
                    </a>
                    <a href="https://support.microsoft.com/es-es/windows/eliminar-y-administrar-cookies-168dab11-0753-043d-7c16-ede5947fc64d" target="_blank" rel="noopener" style="display:flex; align-items:center; gap:0.5rem; color: var(--brand-accent); text-decoration:none; padding: 0.65rem 1rem; background: rgba(139,111,74,0.04); border: 1px solid rgba(139,111,74,0.15); border-radius: 0.75rem; font-weight: 500;">
                        <i class="fa-brands fa-edge"></i> Microsoft Edge
                    </a>
                </div>
            </section>

            <section>
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">5. Actualizaciones de esta Política</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    {{ $shopName }} se reserva el derecho a modificar esta Política de Cookies en cualquier momento. Se recomienda revisarla periódicamente. La fecha de la última actualización se indica en el encabezado de este documento.
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
