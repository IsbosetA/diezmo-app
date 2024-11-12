<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetLink;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//Models
use App\Models\Member;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        // Validar que el correo esté presente y sea válido
        $request->validate([
            'email' => 'required|email|exists:members,email', // Validar que el correo existe en la tabla de miembros
        ]);

        // Buscar el miembro por correo
        $member = Member::where('email', $request->input('email'))->first();

        // Verificar si se encontró el miembro y tiene un usuario asociado
        if (!$member || !$member->user) {
            return back()->withErrors(['email' => 'No se encontró un usuario asociado con este correo.']);
        }

        // Obtener al usuario asociado al miembro
        $user = $member->user;

        // Crear un token de restablecimiento personalizado
        $token = Str::random(60);  // Token aleatorio para la recuperación

        // Guardar el token en la tabla `password_resets` asociado al usuario
        PasswordReset::create([
            'user_id' => $user->id,  // Asocia el token al ID del usuario
            'token' => $token,
            'created_at' => now(),  // Establece la fecha de creación del token
            'updated_at' => now(),  // Establece la fecha de actualizacion  del token
        ]);

        // Crear el enlace para el restablecimiento de la contraseña
        $resetLink = route('password.reset', ['token' => $token]);

        Mail::to($member->email)->send(new PasswordResetLink($resetLink));

        // Aquí puedes enviarlo por correo, SMS, o cualquier otro medio
        // Para este ejemplo, lo retornamos directamente en el navegador
        return back()->with(['status' => 'El enlace de restablecimiento de contraseña ha sido enviado.']);
    }

    // Método para mostrar el formulario de restablecimiento
    public function showResetForm($token)
    {
        // Mostrar el formulario donde el usuario puede restablecer la contraseña
        return view('auth.reset-password', ['token' => $token]);
    }

    // Método para manejar el restablecimiento de la contraseña
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Buscar el token en la base de datos de `password_resets` y verificar que sea válido
        $passwordReset = DB::table('password_resets')->where('token', $request->input('token'))->first();

        if (!$passwordReset) {
            return back()->withErrors(['token' => 'Este enlace de restablecimiento es inválido o ha expirado.']);
        }

        // Buscar al usuario correspondiente por el correo asociado al token
        $user = User::findOrFail($passwordReset->user_id);

        // Verificar que el usuario exista
        if (!$user) {
            return back()->withErrors(['token' => 'Usuario no encontrado.']);
        }

        // Restablecer la contraseña
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Eliminar el token de la base de datos después de usarlo
        DB::table('password_resets')->where('token', $request->input('token'))->delete();

        // Redirigir con éxito
        return redirect()->route('login')->with('status', 'Contraseña restablecida con éxito.');
    }
}
