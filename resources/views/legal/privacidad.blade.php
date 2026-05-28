@extends('landingPage')

@push('meta')
    <meta name="description" content="Política de Privacidad de La Botica Natural. Información sobre tratamiento de datos personales, derechos de los usuarios y uso de la información.">
@endpush

@section('main_content')
<div style="background: var(--brand-cream); min-height: 80vh; padding: 5rem 1.5rem 6rem;">
    <div class="container" style="max-width: 820px; margin: 0 auto;">

        <!-- Hero cabecera legal -->
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <span style="display: inline-block; font-family: var(--fuente-sans); font-size: 0.7rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--brand-accent); background: rgba(139,111,74,0.08); border: 1px solid rgba(139,111,74,0.2); border-radius: 9999px; padding: 0.35rem 1rem; margin-bottom: 1.25rem;">
                <i class="fa-solid fa-shield-halved" style="margin-right: 0.4rem;"></i> Protección de Datos
            </span>
            <h1 style="font-family: var(--fuente-serif); font-size: 2.6rem; font-weight: 500; color: var(--brand-green); margin-bottom: 0.75rem; line-height: 1.2;">Política de Privacidad</h1>
            <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.6); max-width: 480px; margin: 0 auto;">Última actualización: {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}</p>
            <div style="width: 60px; height: 2px; background: var(--brand-accent); margin: 1.5rem auto 0; border-radius: 9999px;"></div>
        </div>

        <!-- Tarjeta de contenido -->
        <div style="background: #ffffff; border-radius: 1.5rem; border: 1px solid rgba(27,48,34,0.06); box-shadow: 0 8px 30px rgba(27,48,34,0.04); padding: 3rem 3.5rem; line-height: 1.8; color: var(--brand-green);">

            @php
                $shopName = \Illuminate\Support\Facades\Cache::get('shop_name', 'La Botica Natural');
                $shopEmail = \Illuminate\Support\Facades\Cache::get('shop_email', 'contacto@laboticanatural.com');
                $shopAddress = \Illuminate\Support\Facades\Cache::get('shop_address', 'Calle de la Naturaleza, 42, 28014 Madrid');
            @endphp

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">1. Responsable del Tratamiento</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    De conformidad con el RGPD (UE) 2016/679 y la LOPDGDD, el responsable del tratamiento de los datos personales recabados es <strong>{{ $shopName }}</strong>, con domicilio en {{ $shopAddress }} y correo de contacto <strong>{{ $shopEmail }}</strong>.
                </p>
            </section>

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">2. Finalidad del Tratamiento</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75); margin-bottom: 0.75rem;">Los datos personales facilitados se tratan con las siguientes finalidades:</p>
                <ul style="padding-left: 1.5rem; font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    <li style="margin-bottom: 0.4rem;">Gestión del registro y acceso a la cuenta de usuario.</li>
                    <li style="margin-bottom: 0.4rem;">Tramitación de pedidos, pagos y envíos.</li>
                    <li style="margin-bottom: 0.4rem;">Comunicaciones relacionadas con el servicio contratado.</li>
                    <li style="margin-bottom: 0.4rem;">Envío de comunicaciones comerciales, previa aceptación.</li>
                    <li>Cumplimiento de obligaciones legales y fiscales.</li>
                </ul>
            </section>

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">3. Base Jurídica</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    El tratamiento se basa en la ejecución del contrato (Art. 6.1.b RGPD), el cumplimiento de obligaciones legales (Art. 6.1.c) y, en su caso, el consentimiento expreso del interesado (Art. 6.1.a).
                </p>
            </section>

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">4. Derechos del Interesado</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75); margin-bottom: 0.75rem;">Puede ejercer los siguientes derechos dirigiéndose a <strong>{{ $shopEmail }}</strong>:</p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; font-family: var(--fuente-sans); font-size: 0.88rem; color: rgba(27,48,34,0.75);">
                    <div style="background: rgba(27,48,34,0.02); border-radius: 0.75rem; padding: 0.75rem 1rem; border: 1px solid rgba(27,48,34,0.05); display: flex; gap: 0.5rem; align-items: center;">
                        <i class="fa-solid fa-circle-check" style="color: var(--brand-accent);"></i> Acceso
                    </div>
                    <div style="background: rgba(27,48,34,0.02); border-radius: 0.75rem; padding: 0.75rem 1rem; border: 1px solid rgba(27,48,34,0.05); display: flex; gap: 0.5rem; align-items: center;">
                        <i class="fa-solid fa-circle-check" style="color: var(--brand-accent);"></i> Rectificación
                    </div>
                    <div style="background: rgba(27,48,34,0.02); border-radius: 0.75rem; padding: 0.75rem 1rem; border: 1px solid rgba(27,48,34,0.05); display: flex; gap: 0.5rem; align-items: center;">
                        <i class="fa-solid fa-circle-check" style="color: var(--brand-accent);"></i> Supresión
                    </div>
                    <div style="background: rgba(27,48,34,0.02); border-radius: 0.75rem; padding: 0.75rem 1rem; border: 1px solid rgba(27,48,34,0.05); display: flex; gap: 0.5rem; align-items: center;">
                        <i class="fa-solid fa-circle-check" style="color: var(--brand-accent);"></i> Portabilidad
                    </div>
                    <div style="background: rgba(27,48,34,0.02); border-radius: 0.75rem; padding: 0.75rem 1rem; border: 1px solid rgba(27,48,34,0.05); display: flex; gap: 0.5rem; align-items: center;">
                        <i class="fa-solid fa-circle-check" style="color: var(--brand-accent);"></i> Oposición
                    </div>
                    <div style="background: rgba(27,48,34,0.02); border-radius: 0.75rem; padding: 0.75rem 1rem; border: 1px solid rgba(27,48,34,0.05); display: flex; gap: 0.5rem; align-items: center;">
                        <i class="fa-solid fa-circle-check" style="color: var(--brand-accent);"></i> Limitación del tratamiento
                    </div>
                </div>
            </section>

            <section style="margin-bottom: 2.5rem;">
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">5. Conservación de Datos</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    Los datos se conservarán mientras sea necesario para la relación contractual y durante los plazos legales de prescripción y conservación obligatoria que resulten de aplicación.
                </p>
            </section>

            <section>
                <h2 style="font-family: var(--fuente-serif); font-size: 1.3rem; font-weight: 500; color: var(--brand-green); margin-bottom: 1rem; padding-bottom: 0.65rem; border-bottom: 1px solid rgba(27,48,34,0.07);">6. Reclamación ante la AEPD</h2>
                <p style="font-family: var(--fuente-sans); font-size: 0.9rem; color: rgba(27,48,34,0.75);">
                    Si considera que el tratamiento de sus datos no se ajusta a la normativa vigente, tiene derecho a presentar una reclamación ante la Agencia Española de Protección de Datos (<a href="https://www.aepd.es" target="_blank" rel="noopener" style="color: var(--brand-accent); text-decoration: underline;">www.aepd.es</a>).
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
