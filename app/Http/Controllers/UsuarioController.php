<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    public function mostrarRegistro()
    {
        return view('auth.registro');
    }

    public function registrar(Request $request)
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'edad' => ['required', 'integer', 'min:18', 'max:120'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        User::create([
            'name' => trim($datos['name']),
            'email' => mb_strtolower(trim($datos['email'])),
            'edad' => (int) $datos['edad'],
            'password' => Hash::make($datos['password']),
        ]);

        return response()->json([
            'ok' => true,
            'mensaje' => 'Usuario registrado correctamente. Ya podés iniciar sesión.',
        ], 201);
    }

    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credenciales['email'] = mb_strtolower(trim($credenciales['email']));

        if (!Auth::attempt($credenciales)) {
            throw ValidationException::withMessages([
                'email' => ['Email o contraseña incorrectos.'],
            ]);
        }

        $request->session()->regenerate();

        return response()->json([
            'ok' => true,
            'mensaje' => 'Inicio de sesión correcto.',
            'redirect' => route('perfil'),
        ]);
    }

    public function perfil()
    {
        return view('perfil', ['usuario' => request()->user()]);
    }

    public function actualizarPerfil(Request $request)
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'edad' => ['required', 'integer', 'min:18', 'max:120'],
        ]);

        $usuario = $request->user();
        $usuario->name = trim($datos['name']);
        $usuario->edad = (int) $datos['edad'];
        $usuario->save();

        return response()->json([
            'ok' => true,
            'mensaje' => 'Perfil actualizado correctamente.',
            'usuario' => [
                'name' => $usuario->name,
                'edad' => $usuario->edad,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
