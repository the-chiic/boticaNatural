<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

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
        ]);

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
        ]);

        // Crear usuario en base de datos encriptando la contraseña
        $usuario = User::create([
            'name' => $solicitud->name,
            'email' => $solicitud->email,
            'pw' => Hash::make($solicitud->password), // Contraseña Hasheada segura
        ]);

        // Redirigir al login con un mensaje verde de éxito
        return redirect()->route('login')->with('status', '¡Registro completado con éxito! Por favor, inicia sesión con tus nuevas credenciales.');
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
}
