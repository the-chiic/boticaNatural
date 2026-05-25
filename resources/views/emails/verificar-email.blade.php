<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activa tu cuenta - La Botica Natural</title>
    <style>
        body {
            font-family: 'Inter', Helvetica, Arial, sans-serif;
            background-color: #f5f5f1;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #eaeaea;
        }
        .header {
            background-color: #1a3c34;
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 10px 0 0 0;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .body {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.6;
        }
        .body h2 {
            font-size: 20px;
            color: #1a3c34;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .body p {
            margin-bottom: 25px;
            font-size: 15px;
        }
        .button-container {
            text-align: center;
            margin: 35px 0;
        }
        .btn-primary {
            display: inline-block;
            background-color: #a87b51;
            color: #ffffff !important;
            padding: 14px 30px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 4px 6px rgba(168, 123, 81, 0.2);
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #936841;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 25px 30px;
            text-align: center;
            font-size: 12px;
            color: #888888;
            border-top: 1px solid #eaeaea;
        }
        .footer a {
            color: #1a3c34;
            text-decoration: none;
            font-weight: bold;
        }
        .link-alternative {
            word-break: break-all;
            font-size: 12px;
            color: #888888;
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 6px;
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span style="font-size: 30px;">🌱</span>
            <h1>La Botica Natural</h1>
        </div>
        <div class="body">
            <h2>¡Te damos la bienvenida!</h2>
            <p>Hola, <strong>{{ $nombre }}</strong>,</p>
            <p>Muchas gracias por registrarte en La Botica Natural. Estamos muy felices de que comiences tu viaje hacia una vida más saludable, natural y consciente.</p>
            <p>Para activar tu cuenta y empezar a navegar, por favor confirma tu dirección de correo electrónico haciendo clic en el botón de abajo:</p>
            
            <div class="button-container">
                <a href="{{ $enlace }}" class="btn-primary" target="_blank">Activar Cuenta</a>
            </div>
            
            <p>Si no te registraste en nuestra plataforma, puedes ignorar este correo y la cuenta se desactivará automáticamente.</p>
            
            <div class="link-alternative">
                Si tienes problemas para hacer clic en el botón, copia y pega este enlace en tu navegador:<br>
                <a href="{{ $enlace }}">{{ $enlace }}</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} La Botica Natural. Todos los derechos reservados.<br>
            Tu camino hacia el bienestar natural. <a href="{{ url('/') }}">Visita nuestra tienda</a>
        </div>
    </div>
</body>
</html>
