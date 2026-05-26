<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volvemos pronto | {{ \Illuminate\Support\Facades\Cache::get('shop_name', 'La Botica Natural') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --brand-green: #1E3A2E;
            --brand-cream: #FAF9F6;
            --brand-accent: #6B7F5A;
            --brand-dark: #111612;
            --text-olive: #6B7F5A;
            --font-serif: 'Playfair Display', Georgia, serif;
            --font-sans: 'Instrument Sans', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--brand-cream);
            color: var(--brand-green);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
            padding: 20px;
        }

        /* Animated natural background elements */
        .bg-leaves {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 1;
        }

        .leaf-svg {
            position: absolute;
            fill: rgba(45, 90, 39, 0.05);
            animation: float 20s infinite ease-in-out;
        }

        .leaf-1 {
            width: 300px;
            height: 300px;
            top: -50px;
            right: -50px;
            transform: rotate(45deg);
            animation-duration: 25s;
        }

        .leaf-2 {
            width: 250px;
            height: 250px;
            bottom: -50px;
            left: -50px;
            transform: rotate(-135deg);
            animation-duration: 22s;
            animation-delay: -5s;
        }

        .leaf-3 {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 15%;
            transform: rotate(15deg);
            animation-duration: 18s;
            animation-delay: -8s;
            fill: rgba(45, 90, 39, 0.03);
        }

        /* Glassmorphism main container */
        .maintenance-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 24px;
            padding: 50px 40px;
            width: 100%;
            max-width: 650px;
            text-align: center;
            box-shadow: 0 30px 60px rgba(27, 48, 34, 0.08);
            position: relative;
            z-index: 10;
            animation: fadeIn 1.2s ease-out;
        }

        .badge-container {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(45, 90, 39, 0.1);
            color: var(--brand-accent);
            padding: 8px 18px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            background-color: var(--brand-accent);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--brand-accent);
            animation: pulse 1.8s infinite;
        }

        .icon-container {
            font-size: 48px;
            color: var(--brand-accent);
            margin-bottom: 25px;
            animation: sway 6s infinite ease-in-out;
            display: inline-block;
        }

        h1 {
            font-family: var(--font-serif);
            font-size: 42px;
            color: var(--brand-green);
            margin-bottom: 20px;
            font-weight: 600;
            line-height: 1.2;
        }

        h2.shop-title {
            font-family: var(--font-sans);
            font-size: 16px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--text-olive);
            margin-bottom: 30px;
            font-weight: 600;
        }

        .message {
            font-size: 16px;
            line-height: 1.7;
            color: rgba(27, 48, 34, 0.75);
            margin-bottom: 40px;
            font-weight: 400;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: radial-gradient(circle, rgba(27, 48, 34, 0.15) 0%, rgba(27, 48, 34, 0) 100%);
            margin: 35px 0;
            width: 100%;
        }

        /* Contact Details Section */
        .contact-section h3 {
            font-size: 14px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--brand-green);
            margin-bottom: 20px;
            font-weight: 700;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        @media (min-width: 576px) {
            .contact-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .contact-item-full {
                grid-column: span 2;
            }
        }

        .contact-card {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(27, 48, 34, 0.05);
            border-radius: 16px;
            padding: 18px 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.85);
            border-color: rgba(45, 90, 39, 0.2);
            box-shadow: 0 15px 30px rgba(27, 48, 34, 0.04);
        }

        .contact-card i {
            font-size: 20px;
            color: var(--brand-accent);
        }

        .contact-card span.label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.6;
            font-weight: 600;
        }

        .contact-card span.value {
            font-size: 14px;
            font-weight: 600;
            word-break: break-all;
        }

        .footer-note {
            font-size: 12px;
            color: rgba(27, 48, 34, 0.5);
            margin-top: 40px;
            letter-spacing: 0.5px;
        }

        /* Animations */
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg) scale(1);
            }
            50% {
                transform: translateY(-20px) rotate(15deg) scale(1.05);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(0.9);
                opacity: 1;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.4;
            }
            100% {
                transform: scale(0.9);
                opacity: 1;
            }
        }

        @keyframes sway {
            0%, 100% {
                transform: rotate(-8deg);
            }
            50% {
                transform: rotate(8deg);
            }
        }

        @media (max-width: 576px) {
            .maintenance-card {
                padding: 35px 20px;
            }
            h1 {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>

    <!-- Dynamic animated backgrounds -->
    <div class="bg-leaves">
        <!-- SVG Leaf 1 -->
        <svg class="leaf-svg leaf-1" viewBox="0 0 100 100">
            <path d="M50,0 C65,25 70,45 50,100 C30,45 35,25 50,0 Z"></path>
        </svg>
        <!-- SVG Leaf 2 -->
        <svg class="leaf-svg leaf-2" viewBox="0 0 100 100">
            <path d="M50,0 C65,25 70,45 50,100 C30,45 35,25 50,0 Z"></path>
        </svg>
        <!-- SVG Leaf 3 -->
        <svg class="leaf-svg leaf-3" viewBox="0 0 100 100">
            <path d="M50,0 C65,25 70,45 50,100 C30,45 35,25 50,0 Z"></path>
        </svg>
    </div>

    <!-- Main Card -->
    <div class="maintenance-card">
        
        <div class="badge-container">
            <div class="badge-dot"></div>
            Modo Mantenimiento Activo
        </div>

        <div class="icon-container">
            <i class="fa-solid fa-leaf"></i>
        </div>

        <h2 class="shop-title">{{ \Illuminate\Support\Facades\Cache::get('shop_name', 'La Botica Natural') }}</h2>
        <h1>Volvemos pronto</h1>
        
        <p class="message">
            Estamos cultivando nuevas ideas y renovando nuestra tienda online para ofrecerte una experiencia natural aún más pura, rápida y reconfortante. Disculpa las molestias, nuestro espacio estará listo de nuevo en muy poco tiempo.
        </p>

        <div class="divider"></div>

        <!-- Contact Section -->
        <div class="contact-section">
            <h3>¿Necesitas algo con urgencia?</h3>
            <div class="contact-grid">
                
                <!-- Email -->
                <div class="contact-card">
                    <i class="fa-regular fa-envelope"></i>
                    <span class="label">Correo electrónico</span>
                    <span class="value">{{ \Illuminate\Support\Facades\Cache::get('shop_email', 'contacto@laboticanatural.com') }}</span>
                </div>

                <!-- Phone -->
                <div class="contact-card">
                    <i class="fa-solid fa-phone"></i>
                    <span class="label">Teléfono de atención</span>
                    <span class="value">{{ \Illuminate\Support\Facades\Cache::get('shop_phone', '+34 900 123 456') }}</span>
                </div>

                <!-- Address -->
                <div class="contact-card contact-item-full">
                    <i class="fa-solid fa-location-dot"></i>
                    <span class="label">Dirección física comercial</span>
                    <span class="value" style="white-space: pre-line;">{{ \Illuminate\Support\Facades\Cache::get('shop_address', "Calle de la Naturaleza, 42\nMadrid, 28014") }}</span>
                </div>

            </div>
        </div>

        <p class="footer-note">
            &copy; 2026 {{ \Illuminate\Support\Facades\Cache::get('shop_name', 'La Botica Natural') }}. Gracias por tu paciencia.
        </p>

    </div>

</body>
</html>
