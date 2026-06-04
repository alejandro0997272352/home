@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-user-edit mr-2 text-indigo-600"></i>Editar Usuario: {{ $user->name }}
    </h1>
</div>

<form method="POST" action="{{ route('admin.usuarios.update', $user) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <i class="fas fa-user-circle mr-2 text-indigo-500"></i>Información Básica
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $user->telefono) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto de Perfil</label>
                        <input type="file" name="foto_perfil" accept="image/*"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-300">
                        @if($user->foto_perfil)
                            <p class="text-xs text-gray-500 mt-1">
                                <img src="{{ $user->foto_url }}" class="w-10 h-10 rounded-full object-cover inline mr-1">
                                {{ basename($user->foto_perfil) }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rol</label>
                        <select name="role" required
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                            <option value="estudiante" {{ old('role', $user->role) === 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                            <option value="tutor" {{ old('role', $user->role) === 'tutor' ? 'selected' : '' }}>Tutor</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>
                    <div>
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="activo" value="1" {{ old('activo', $user->activo) ? 'checked' : '' }}
                                class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 transition-colors">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Usuario activo</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <i class="fas fa-lock mr-2 text-red-500"></i>Cambiar Contraseña
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Dejar vacío para mantener la actual</p>
                <div class="space-y-4">
                    <div>
                        <input type="password" name="password" id="password" placeholder="Nueva contraseña"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                        <div id="passwordRequirements" class="mt-3 space-y-1.5 text-sm hidden">
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Debe contener:</p>
                            <div class="password-check invalid flex items-center" data-req="min"><i class="fas fa-circle mr-2 text-[8px]"></i> <span>8+ caracteres</span></div>
                            <div class="password-check invalid flex items-center" data-req="upper"><i class="fas fa-circle mr-2 text-[8px]"></i> <span>Mayúscula</span></div>
                            <div class="password-check invalid flex items-center" data-req="lower"><i class="fas fa-circle mr-2 text-[8px]"></i> <span>Minúscula</span></div>
                            <div class="password-check invalid flex items-center" data-req="number"><i class="fas fa-circle mr-2 text-[8px]"></i> <span>Número</span></div>
                            <div class="password-check invalid flex items-center" data-req="special"><i class="fas fa-circle mr-2 text-[8px]"></i> <span>Carácter especial (@$!%*#?&._-)</span></div>
                        </div>
                    </div>
                    <div>
                        <input type="password" name="password_confirmation" id="password-confirm" placeholder="Confirmar contraseña"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                        <div id="matchIndicator" class="mt-1 text-sm hidden"></div>
                    </div>
                </div>
            </div>
        </div>

        @if($user->isTutor())
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                        <i class="fas fa-chalkboard-teacher mr-2 text-blue-500"></i>Perfil de Tutor
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Biografía</label>
                            <textarea name="biografia" rows="3"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">{{ old('biografia', $user->tutorProfile->biografia ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Formación Académica</label>
                            <input type="text" name="formacion_academica" value="{{ old('formacion_academica', $user->tutorProfile->formacion_academica ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tarifa por Hora ($)</label>
                            <input type="number" name="tarifa_por_hora" step="0.01" min="0" value="{{ old('tarifa_por_hora', $user->tutorProfile->tarifa_por_hora ?? 0) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                        <i class="fas fa-book mr-2 text-purple-500"></i>Materias que Imparte
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($materias as $materia)
                            <label class="flex items-center gap-2 p-3 border border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-indigo-50 dark:hover:bg-indigo-900/30 transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900/30">
                                <input type="checkbox" name="subjects[]" value="{{ $materia->id }}"
                                    {{ in_array($materia->id, $user->subjects->pluck('id')->toArray()) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $materia->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                        <i class="fas fa-clock mr-2 text-green-500"></i>Disponibilidad
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Define los horarios disponibles del tutor.</p>
                    <div id="availabilityContainer" class="space-y-3">
                        @forelse($user->availability->where('activo', true) as $slot)
                            <div class="availability-row flex flex-wrap items-end gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <input type="hidden" name="availability[{{ $loop->index }}][id]" value="{{ $slot->id }}">
                                <div class="flex-1 min-w-[120px]">
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Día</label>
                                    <select name="availability[{{ $loop->index }}][dia_semana]"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 transition-all text-sm">
                                        @foreach(['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'] as $dia)
                                            <option value="{{ $dia }}" {{ $slot->dia_semana === $dia ? 'selected' : '' }}>{{ $dia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Inicio</label>
                                    <input type="time" name="availability[{{ $loop->index }}][hora_inicio]" value="{{ substr($slot->hora_inicio, 0, 5) }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 transition-all text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Fin</label>
                                    <input type="time" name="availability[{{ $loop->index }}][hora_fin]" value="{{ substr($slot->hora_fin, 0, 5) }}"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 transition-all text-sm">
                                </div>
                                <button type="button" onclick="this.closest('.availability-row').remove()" title="Eliminar"
                                    class="px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @empty
                            <p class="text-gray-400 dark:text-gray-500 text-sm text-center py-4" id="noAvailability">Sin horarios registrados</p>
                        @endforelse
                    </div>
                    <button type="button" onclick="addAvailability()"
                        class="mt-3 px-4 py-2 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-xl hover:bg-green-100 dark:hover:bg-green-900/50 transition-all text-sm font-medium">
                        <i class="fas fa-plus mr-1"></i> Agregar Horario
                    </button>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                        <i class="fas fa-star mr-2 text-yellow-500"></i>Estadísticas
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $user->tutorProfile->total_sesiones ?? 0 }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Sesiones</p>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900/30 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-yellow-600">{{ number_format($user->tutorProfile->calificacion_promedio ?? 0, 1) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Calificación</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/30 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-purple-600">{{ $user->subjects->count() }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Materias</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/30 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $user->availability->where('activo', true)->count() }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Horarios</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                        <i class="fas fa-info-circle mr-1"></i>
                        Las opciones de perfil de tutor, materias y horarios se mostrarán cuando el rol sea <strong>Tutor</strong>.
                    </p>
                </div>
            </div>
        @endif
    </div>

    <div class="flex justify-end space-x-3 mt-6">
        <a href="{{ route('admin.usuarios.index') }}" class="px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">Cancelar</a>
        <button type="submit" class="btn-ripple px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md">
            <i class="fas fa-save mr-1"></i> Guardar Cambios
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
let availIndex = {{ $user->availability->where('activo', true)->count() }};

function addAvailability() {
    const container = document.getElementById('availabilityContainer');
    const noMsg = document.getElementById('noAvailability');
    if (noMsg) noMsg.remove();

    const idx = availIndex++;
    const dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];
    const html = `
        <div class="availability-row flex flex-wrap items-end gap-3 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
            <div class="flex-1 min-w-[120px]">
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Día</label>
                <select name="availability[${idx}][dia_semana]"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 transition-all text-sm">
                    ${dias.map(d => `<option value="${d}">${d}</option>`).join('')}
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Inicio</label>
                <input type="time" name="availability[${idx}][hora_inicio]"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 transition-all text-sm">
            </div>
            <div>
                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Fin</label>
                <input type="time" name="availability[${idx}][hora_fin]"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 transition-all text-sm">
            </div>
            <button type="button" onclick="this.closest('.availability-row').remove()" title="Eliminar"
                class="px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-all">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}

document.addEventListener('DOMContentLoaded', function () {
    const password = document.getElementById('password');
    const confirm = document.getElementById('password-confirm');
    const matchIndicator = document.getElementById('matchIndicator');
    const requirements = document.getElementById('passwordRequirements');

    function checkPasswordStrength() {
        const val = password.value;
        const show = val.length > 0;
        requirements.classList.toggle('hidden', !show);
        const checks = { min: val.length >= 8, upper: /[A-Z]/.test(val), lower: /[a-z]/.test(val), number: /[\d]/.test(val), special: /[@$!%*#?&._-]/.test(val) };
        document.querySelectorAll('.password-check').forEach(el => {
            const isValid = checks[el.dataset.req];
            el.className = `password-check flex items-center text-sm transition-all duration-300 ${isValid ? 'valid' : 'invalid'}`;
            el.innerHTML = isValid
                ? '<i class="fas fa-check-circle mr-2 text-green-500"></i> <span>' + el.querySelector('span').textContent + '</span>'
                : '<i class="fas fa-circle mr-2 text-[8px]"></i> <span>' + el.querySelector('span').textContent + '</span>';
        });
    }
    function checkMatch() {
        if (confirm.value.length === 0) { matchIndicator.className = 'mt-1 text-sm hidden'; return; }
        matchIndicator.className = 'mt-1 text-sm flex items-center';
        matchIndicator.innerHTML = password.value === confirm.value
            ? '<i class="fas fa-check-circle mr-1 text-green-500"></i> <span class="text-green-600">Coinciden</span>'
            : '<i class="fas fa-times-circle mr-1 text-red-500"></i> <span class="text-red-600">No coinciden</span>';
    }
    password.addEventListener('input', function () { checkPasswordStrength(); checkMatch(); });
    confirm.addEventListener('input', checkMatch);
});
</script>
@endpush