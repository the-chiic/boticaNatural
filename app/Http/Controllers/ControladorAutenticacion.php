<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\RecuperarContrasenaMail;
use App\Mail\VerificarEmailMail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ControladorAutenticacion extends Controller
{
    // Mostrar formulario de Login (Iniciar Sesión)
    public function mostrarFormularioLogin()
    {
        return view('auth.login');
    }

    // Procesar el inicio de sesión
    public function iniciarSesion(Request $solicitud)
    {
        // Validar que los campos no estén vacíos y tengan formato correcto
        $credenciales = $solicitud->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // (Verificación por correo desactivada temporalmente)

        // Intentar autenticar. Laravel usa 'password' del array y lo mapea internamente a 'pw' por el modelo User.
        if (Auth::attempt(['email' => $solicitud->email, 'password' => $solicitud->password])) {
            $solicitud->session()->regenerate();
            session(['logged_in' => true]);

            // Redirigir al home (/) tras un login exitoso
            return redirect()->intended('/');
        }

        // Si falla, volver al login con error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // Mostrar formulario de Registro (Crear Cuenta)
    public function mostrarFormularioRegistro()
    {
        return view('auth.register');
    }

    // Procesar el Registro de un nuevo usuario
    public function registrar(Request $solicitud)
    {
        // Validar datos ingresados
        $solicitud->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // requiere campo password_confirmation en el HTML
        ], [
            'name.required' => 'El nombre completo es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Generar un token único de verificación por correo
        $token = Str::random(60);

        // Crear usuario en base de datos encriptando la contraseña
        $usuario = User::create([
            'name' => $solicitud->name,
            'email' => $solicitud->email,
            'pw' => Hash::make($solicitud->password), // Contraseña Hasheada segura
            'verification_token' => $token,
        ]);

        // Iniciar sesión automáticamente tras el registro (correo de activación desactivado temporalmente)
        Auth::login($usuario);
        session(['logged_in' => true]);

        return redirect('/');
    }

    // Procesar el cierre de sesión (Cerrar Sesión)
    public function cerrarSesion(Request $solicitud)
    {
        Auth::logout();

        $solicitud->session()->invalidate();
        $solicitud->session()->regenerateToken();
        session()->forget('logged_in');

        return redirect('/');
    }

    // --- Autenticación con Google --- //

    // Redirigir al proveedor de Google
    public function redireccionarAGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    // Manejar el callback de respuesta desde Google
    public function manejarCallbackGoogle()
    {
        try {
            // Creamos el driver de Socialite
            $proveedor = Socialite::driver('google')->stateless();

            // --- EVITAR EL ERROR DE CERTIFICADO SSL cURL 60 EN XAMPP (WINDOWS) ---
            // Si estamos en entorno local, desactivamos la verificación SSL de Guzzle de forma temporal.
            if (app()->environment('local')) {
                $proveedor->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
            }

            $usuarioGoogle = $proveedor->user();
            
            // Buscar si ya existe el usuario por email
            $usuario = User::where('email', $usuarioGoogle->getEmail())->first();

            if ($usuario) {
                // Si existe el usuario, actualizamos su ID de Google si no lo tenía vinculado
                if (!$usuario->google_auth) {
                    $usuario->update(['google_auth' => $usuarioGoogle->getId()]);
                }
                Auth::login($usuario);
            } else {
                // Si no existe, creamos el usuario con contraseña aleatoria segura
                $usuario = User::create([
                    'name' => $usuarioGoogle->getName(),
                    'email' => $usuarioGoogle->getEmail(),
                    'google_auth' => $usuarioGoogle->getId(),
                    'pw' => Hash::make(Str::random(24)),
                ]);
                Auth::login($usuario);
            }

            session(['logged_in' => true]);
            
            // Redirigimos al Home (/) tras el inicio de sesión exitoso con Google
            return redirect('/');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Auth Error: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            // En caso de error, volver al login mostrando el mensaje real del error para diagnosticarlo
            $mensaje = $e->getMessage() ?: get_class($e);
            return redirect('/iniciar-sesion')->withErrors(['email' => 'Error Google: ' . $mensaje]);
        }
    }

    // --- Recuperación de Contraseña (Forgot Password) --- //

    // Mostrar el formulario de solicitud de recuperación
    public function mostrarFormularioRecuperar()
    {
        return view('auth.forgot-password');
    }

    // Enviar el correo con el enlace de recuperación
    public function enviarEnlaceRecuperacion(Request $solicitud)
    {
        $solicitud->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
        ]);

        $usuario = User::where('email', $solicitud->email)->first();

        if ($usuario) {
            // Generar un token encriptado que contiene el correo, el hash actual de la contraseña y la expiración
            $payload = [
                'email' => $usuario->email,
                'password_hash' => $usuario->pw,
                'expires_at' => now()->addMinutes(60)->timestamp,
            ];
            $token = Crypt::encrypt($payload);

            // Enviar el correo
            try {
                $enlace = route('password.reset', ['token' => $token]) . '?email=' . urlencode($usuario->email);
                Mail::to($usuario->email)->send(new RecuperarContrasenaMail($usuario->name, $enlace));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error al enviar correo de recuperación de contraseña: ' . $e->getMessage());
                return back()->withErrors(['email' => 'Error de conexión de correo: no se pudo enviar el email.']);
            }
        }

        // Por seguridad, siempre mostramos el mensaje de que fue enviado para evitar pesca de correos (User Enumeration)
        return back()->with('status', '¡Te hemos enviado un correo con instrucciones para restablecer tu contraseña!');
    }

    // Mostrar formulario para escribir la nueva contraseña
    public function mostrarFormularioRestablecer($token, Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        try {
            $payload = Crypt::decrypt($token);
        } catch (DecryptException $e) {
            return redirect()->route('password.request')->withErrors(['email' => 'El enlace de recuperación es inválido o ha sido alterado.']);
        }

        // Verificar expiración
        if (now()->timestamp > $payload['expires_at']) {
            return redirect()->route('password.request')->withErrors(['email' => 'El enlace de recuperación ha caducado.']);
        }

        // Verificar coincidencia de correo
        if ($payload['email'] !== $request->email) {
            return redirect()->route('password.request')->withErrors(['email' => 'El enlace no corresponde a este correo electrónico.']);
        }

        // Buscar el usuario y comprobar que su contraseña no haya cambiado (seguridad de un solo uso)
        $usuario = User::where('email', $request->email)->first();
        if (!$usuario || $usuario->pw !== $payload['password_hash']) {
            return redirect()->route('password.request')->withErrors(['email' => 'Este enlace de recuperación ya ha sido utilizado.']);
        }

        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // Actualizar la contraseña
    public function actualizarContrasena(Request $solicitud)
    {
        $solicitud->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'token.required' => 'El token de recuperación es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        try {
            $payload = Crypt::decrypt($solicitud->token);
        } catch (DecryptException $e) {
            return back()->withErrors(['email' => 'El token de recuperación es inválido o ha sido alterado.']);
        }

        // Verificar expiración
        if (now()->timestamp > $payload['expires_at']) {
            return redirect()->route('password.request')->withErrors(['email' => 'El enlace de recuperación ha caducado.']);
        }

        // Verificar coincidencia de correo
        if ($payload['email'] !== $solicitud->email) {
            return back()->withErrors(['email' => 'El token de recuperación no corresponde a este correo electrónico.']);
        }

        // Buscar el usuario y comprobar que su contraseña no haya cambiado (seguridad de un solo uso)
        $usuario = User::where('email', $solicitud->email)->first();
        if (!$usuario || $usuario->pw !== $payload['password_hash']) {
            return redirect()->route('password.request')->withErrors(['email' => 'Este enlace de recuperación ya ha sido utilizado.']);
        }

        // Actualizar la contraseña (campo pw)
        $usuario->update([
            'pw' => Hash::make($solicitud->password)
        ]);

        return redirect()->route('login')->with('status', '¡Tu contraseña ha sido restablecida con éxito! Ya puedes iniciar sesión.');
    }

    // --- Verificación de Email (Account Activation) --- //

    // Mostrar la pantalla de aviso de verificación
    public function mostrarAvisoVerificacion()
    {
        if (!session('verify_email')) {
            return redirect()->route('login');
        }
        return view('auth.verify-email-notice');
    }

    // Reenviar el correo de activación
    public function reenviarVerificacion(Request $solicitud)
    {
        $email = $solicitud->email ?: session('verify_email');

        if (!$email) {
            return redirect()->route('login');
        }

        $usuario = User::where('email', $email)->first();

        if (!$usuario) {
            return redirect()->route('login');
        }

        if ($usuario->email_verified_at) {
            return redirect()->route('login')->with('status', 'Tu cuenta ya está activa. Inicia sesión.');
        }

        // Generar un nuevo token
        $token = Str::random(60);
        $usuario->update([
            'verification_token' => $token
        ]);

        // Enviar el correo
        try {
            $enlace = route('verification.verify', ['token' => $token]);
            Mail::to($usuario->email)->send(new VerificarEmailMail($usuario->name, $enlace));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al reenviar correo de verificación: ' . $e->getMessage());
            return back()->withErrors(['email' => 'No se pudo enviar el correo de activación.']);
        }

        return back()->with('status', '¡Hemos reenviado el correo de activación con éxito!');
    }

    // Procesar la verificación al hacer clic en el botón del correo
    public function verificarEmail($token)
    {
        $usuario = User::where('verification_token', $token)->first();

        if (!$usuario) {
            return redirect()->route('login')->withErrors(['email' => 'El enlace de activación es inválido o ya ha sido utilizado.']);
        }

        // Activar la cuenta
        $usuario->update([
            'email_verified_at' => now(),
            'verification_token' => null
        ]);

        // Iniciar sesión del usuario automáticamente
        Auth::login($usuario);
        session(['logged_in' => true]);

        return redirect('/')->with('status', '¡Tu cuenta ha sido activada con éxito! Bienvenido a La Botica Natural.');
    }
}
