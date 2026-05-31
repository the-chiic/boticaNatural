<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordResetToken;
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
    public function mostrarFormularioLogin()
    {
        return view('auth.login');
    }

    public function iniciarSesion(Request $solicitud)
    {
        $credenciales = $solicitud->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt(['email' => $solicitud->email, 'password' => $solicitud->password])) {
            $solicitud->session()->regenerate();
            session(['logged_in' => true]);

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function mostrarFormularioRegistro()
    {
        return view('auth.register');
    }

    public function registrar(Request $solicitud)
    {
        $solicitud->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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

        $token = Str::random(60);

        $usuario = User::create([
            'name' => $solicitud->name,
            'email' => $solicitud->email,
            'pw' => Hash::make($solicitud->password),
            'verification_token' => $token,
        ]);

        Auth::login($usuario);
        session(['logged_in' => true]);

        return redirect('/');
    }

    public function cerrarSesion(Request $solicitud)
    {
        Auth::logout();

        $solicitud->session()->invalidate();
        $solicitud->session()->regenerateToken();
        session()->forget('logged_in');

        return redirect('/');
    }

    public function redireccionarAGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function manejarCallbackGoogle()
    {
        try {
            $proveedor = Socialite::driver('google')->stateless();

            if (app()->environment('local')) {
                $proveedor->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
            }

            $usuarioGoogle = $proveedor->user();

            $usuario = User::where('email', $usuarioGoogle->getEmail())->first();

            if ($usuario) {
                if (!$usuario->google_auth) {
                    $usuario->update(['google_auth' => $usuarioGoogle->getId()]);
                }
                Auth::login($usuario);
            } else {
                $usuario = User::create([
                    'name' => $usuarioGoogle->getName(),
                    'email' => $usuarioGoogle->getEmail(),
                    'google_auth' => $usuarioGoogle->getId(),
                    'pw' => Hash::make(Str::random(24)),
                ]);
                Auth::login($usuario);
            }

            session(['logged_in' => true]);

            return redirect('/');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Auth Error: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            $mensaje = $e->getMessage() ?: get_class($e);
            return redirect('/iniciar-sesion')->withErrors(['email' => 'Error Google: ' . $mensaje]);
        }
    }

    public function mostrarFormularioRecuperar()
    {
        return view('auth.forgot-password');
    }

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
            if ($usuario->google_auth) {
                return back()->withErrors(['email' => 'Esta cuenta está registrada a través de Google. Por favor, inicia sesión usando Google.']);
            }

            $token = Str::random(60);

            PasswordResetToken::updateOrCreate(
                ['user_id' => $usuario->id],
                [
                    'token' => $token,
                    'expires_at' => now()->addMinutes(60),
                ]
            );

            try {
                $enlace = route('password.reset', ['token' => $token]) . '?email=' . urlencode($usuario->email);
                Mail::to($usuario->email)->send(new RecuperarContrasenaMail($usuario->name, $enlace));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error al enviar correo de recuperación de contraseña: ' . $e->getMessage());
                return back()->withErrors(['email' => 'Error de conexión de correo: no se pudo enviar el email.']);
            }
        }

        return back()->with('status', '¡Te hemos enviado un correo con instrucciones para restablecer tu contraseña!');
    }

    public function mostrarFormularioRestablecer($token, Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $usuario = User::where('email', $request->email)->first();

        if (!$usuario) {
            return redirect()->route('password.request')->withErrors(['email' => 'El enlace de recuperación es inválido o ya ha sido utilizado.']);
        }

        $resetToken = PasswordResetToken::where('user_id', $usuario->id)
                                         ->where('token', $token)
                                         ->first();

        if (!$resetToken) {
            return redirect()->route('password.request')->withErrors(['email' => 'El enlace de recuperación es inválido o ya ha sido utilizado.']);
        }

        if (now()->gt($resetToken->expires_at)) {
            $resetToken->delete();
            return redirect()->route('password.request')->withErrors(['email' => 'El enlace de recuperación ha caducado.']);
        }

        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

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

        $usuario = User::where('email', $solicitud->email)->first();

        if (!$usuario) {
            return redirect()->route('password.request')->withErrors(['email' => 'El token de recuperación es inválido o ya ha sido utilizado.']);
        }

        $resetToken = PasswordResetToken::where('user_id', $usuario->id)
                                         ->where('token', $solicitud->token)
                                         ->first();

        if (!$resetToken) {
            return redirect()->route('password.request')->withErrors(['email' => 'El token de recuperación es inválido o ya ha sido utilizado.']);
        }

        if (now()->gt($resetToken->expires_at)) {
            $resetToken->delete();
            return redirect()->route('password.request')->withErrors(['email' => 'El enlace de recuperación ha caducado.']);
        }

        $usuario->update([
            'pw' => Hash::make($solicitud->password),
        ]);

        $resetToken->delete();

        return redirect()->route('login')->with('status', '¡Tu contraseña ha sido restablecida con éxito! Ya puedes iniciar sesión.');
    }

    public function mostrarAvisoVerificacion()
    {
        if (!session('verify_email')) {
            return redirect()->route('login');
        }
        return view('auth.verify-email-notice');
    }

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

        $token = Str::random(60);
        $usuario->update([
            'verification_token' => $token
        ]);

        try {
            $enlace = route('verification.verify', ['token' => $token]);
            Mail::to($usuario->email)->send(new VerificarEmailMail($usuario->name, $enlace));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error al reenviar correo de verificación: ' . $e->getMessage());
            return back()->withErrors(['email' => 'No se pudo enviar el correo de activación.']);
        }

        return back()->with('status', '¡Hemos reenviado el correo de activación con éxito!');
    }

    public function verificarEmail($token)
    {
        $usuario = User::where('verification_token', $token)->first();

        if (!$usuario) {
            return redirect()->route('login')->withErrors(['email' => 'El enlace de activación es inválido o ya ha sido utilizado.']);
        }

        $usuario->update([
            'email_verified_at' => now(),
            'verification_token' => null
        ]);

        Auth::login($usuario);
        session(['logged_in' => true]);

        return redirect('/')->with('status', '¡Tu cuenta ha sido activada con éxito! Bienvenido a La Botica Natural.');
    }
}
