<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('tutorProfile');
        return view('perfil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'telefono' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        if ($user->isTutor()) {
            $request->validate([
                'biografia' => 'nullable|string|max:1000',
                'formacion_academica' => 'nullable|string|max:500',
                'tarifa_por_hora' => 'nullable|numeric|min:0|max:99999',
            ]);

            $user->tutorProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'biografia' => $request->biografia,
                    'formacion_academica' => $request->formacion_academica,
                    'tarifa_por_hora' => $request->tarifa_por_hora ?? 0,
                ]
            );
        }

        if ($request->hasFile('foto_perfil')) {
            $request->validate([
                'foto_perfil' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            if ($user->foto_perfil) {
                Storage::disk('public')->delete($user->foto_perfil);
            }

            $path = $request->file('foto_perfil')->store('fotos_perfil', 'public');
            $user->update(['foto_perfil' => $path]);
        }

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&._-]).+$/',
        ], [
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.',
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('perfil')->with('success', 'Contraseña actualizada correctamente.');
    }
}
