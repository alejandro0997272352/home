<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $usuarios = $query->orderBy('created_at', 'desc')->paginate(15);

        if ($request->wantsJson()) {
            $html = view('admin.usuarios.partials.table', compact('usuarios'))->render();
            return response()->json([
                'html' => $html,
                'total' => $usuarios->total(),
                'page' => $usuarios->currentPage(),
                'pages' => $usuarios->lastPage(),
            ]);
        }

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&._-]).+$/',
            ],
            'role' => 'required|in:admin,tutor,estudiante',
            'telefono' => 'nullable|string|max:20',
        ], [
            'password.regex' => 'La contraseña debe contener al menos: una mayúscula, una minúscula, un número y un carácter especial (@$!%*#?&._-).',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        if ($user->role === 'tutor') {
            $user->tutorProfile()->create([]);
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function show(User $user)
    {
        return view('admin.usuarios.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load('tutorProfile', 'subjects', 'availability');
        $materias = Subject::all();
        return view('admin.usuarios.edit', compact('user', 'materias'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,tutor,estudiante',
            'telefono' => 'nullable|string|max:20',
            'activo' => 'boolean',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&._-]).+$/',
            ],
        ], [
            'password.regex' => 'La contraseña debe contener al menos: una mayúscula, una minúscula, un número y un carácter especial (@$!%*#?&._-).',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        if ($request->hasFile('foto_perfil')) {
            $request->validate(['foto_perfil' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048']);
            if ($user->foto_perfil) Storage::disk('public')->delete($user->foto_perfil);
            $path = $request->file('foto_perfil')->store('fotos_perfil', 'public');
            $user->update(['foto_perfil' => $path]);
        }

        if ($user->isTutor()) {
            if ($request->has('biografia') || $request->has('formacion_academica') || $request->has('tarifa_por_hora')) {
                $user->tutorProfile()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'biografia' => $request->biografia ?? '',
                        'formacion_academica' => $request->formacion_academica ?? '',
                        'tarifa_por_hora' => $request->tarifa_por_hora ?? 0,
                    ]
                );
            }

            if ($request->has('subjects')) {
                $user->subjects()->sync($request->subjects);
            }

            if ($request->has('availability')) {
                $user->availability()->whereNotIn('id', collect($request->availability)->filter(fn($a) => !empty($a['id']))->pluck('id'))->delete();
                foreach ($request->availability as $slot) {
                    if (!empty($slot['dia_semana']) && !empty($slot['hora_inicio']) && !empty($slot['hora_fin'])) {
                        $user->availability()->updateOrCreate(
                            ['id' => $slot['id'] ?? null],
                            [
                                'dia_semana' => $slot['dia_semana'],
                                'hora_inicio' => $slot['hora_inicio'],
                                'hora_fin' => $slot['hora_fin'],
                                'activo' => true,
                            ]
                        );
                    }
                }
            }
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo.');
        }

        $user->delete();
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
