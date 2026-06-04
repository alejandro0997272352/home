@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="glass-card rounded-2xl shadow-2xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full mb-4 shadow-lg">
                <i class="fas fa-user-plus text-2xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Crear Cuenta</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Regístrate en el sistema de tutorías</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="input-group">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-200">
                    <i class="fas fa-user mr-1 text-indigo-500"></i> Nombre Completo
                </label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('name') border-red-500 ring-2 ring-red-200 @enderror">
                @error('name') <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-200">
                    <i class="fas fa-envelope mr-1 text-indigo-500"></i> Correo Electrónico
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('email') border-red-500 ring-2 ring-red-200 @enderror">
                @error('email') <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <label for="telefono" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-200">
                    <i class="fas fa-phone mr-1 text-indigo-500"></i> Teléfono (opcional)
                </label>
                <input id="telefono" type="text" name="telefono" value="{{ old('telefono') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-user-tag mr-1 text-indigo-500"></i> Tipo de Usuario
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative border-2 dark:border-gray-500 rounded-xl p-3 cursor-pointer transition-all duration-200 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900/30 has-[:checked]:shadow-md hover:border-indigo-400">
                        <input type="radio" name="role" value="estudiante" {{ old('role', 'estudiante') === 'estudiante' ? 'checked' : '' }} class="sr-only peer">
                        <div class="text-center">
                            <i class="fas fa-user-graduate text-2xl text-green-600 peer-checked:scale-110 transition-transform"></i>
                            <p class="text-sm font-medium mt-1">Estudiante</p>
                        </div>
                    </label>
                    <label class="relative border-2 dark:border-gray-500 rounded-xl p-3 cursor-pointer transition-all duration-200 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50 dark:has-[:checked]:bg-indigo-900/30 has-[:checked]:shadow-md hover:border-indigo-400">
                        <input type="radio" name="role" value="tutor" {{ old('role') === 'tutor' ? 'checked' : '' }} class="sr-only peer">
                        <div class="text-center">
                            <i class="fas fa-chalkboard-teacher text-2xl text-blue-600 peer-checked:scale-110 transition-transform"></i>
                            <p class="text-sm font-medium mt-1">Tutor</p>
                        </div>
                    </label>
                </div>
                @error('role') <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    <i class="fas fa-lock mr-1 text-indigo-500"></i> Contraseña
                </label>
                <div class="relative">
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2.5 pr-12 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('password') border-red-500 ring-2 ring-red-200 @enderror">
                    <button type="button" onclick="togglePassword('password', 'toggleIcon1')"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-indigo-600 transition-colors">
                        <i id="toggleIcon1" class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password') <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
                <div id="passwordRequirements" class="mt-3 space-y-1.5 text-sm">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">La contraseña debe contener:</p>
                    <div class="password-check invalid flex items-center" data-req="min">
                        <i class="fas fa-circle mr-2 text-[8px]"></i> <span>Al menos 8 caracteres</span>
                    </div>
                    <div class="password-check invalid flex items-center" data-req="upper">
                        <i class="fas fa-circle mr-2 text-[8px]"></i> <span>Una mayúscula (A-Z)</span>
                    </div>
                    <div class="password-check invalid flex items-center" data-req="lower">
                        <i class="fas fa-circle mr-2 text-[8px]"></i> <span>Una minúscula (a-z)</span>
                    </div>
                    <div class="password-check invalid flex items-center" data-req="number">
                        <i class="fas fa-circle mr-2 text-[8px]"></i> <span>Un número (0-9)</span>
                    </div>
                    <div class="password-check invalid flex items-center" data-req="special">
                        <i class="fas fa-circle mr-2 text-[8px]"></i> <span>Un carácter especial (@$!%*#?&._-)</span>
                    </div>
                </div>
            </div>

            <div>
                <label for="password-confirm" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    <i class="fas fa-lock mr-1 text-indigo-500"></i> Confirmar Contraseña
                </label>
                <div class="relative">
                    <input id="password-confirm" type="password" name="password_confirmation" required
                        class="w-full px-4 py-2.5 pr-12 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                    <button type="button" onclick="togglePassword('password-confirm', 'toggleIcon2')"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-indigo-600 transition-colors">
                        <i id="toggleIcon2" class="fas fa-eye"></i>
                    </button>
                </div>
                <div id="matchIndicator" class="mt-1 text-sm hidden"></div>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-ripple w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2.5 px-4 rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 hover:shadow-xl hover:-translate-y-0.5">
                    <i class="fas fa-user-plus mr-2"></i> Crear Cuenta
                </button>
            </div>
        </form>

        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium hover:underline transition-all">Inicia Sesión</a>
        </p>

    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const password = document.getElementById('password');
    const confirm = document.getElementById('password-confirm');
    const matchIndicator = document.getElementById('matchIndicator');

    function checkPasswordStrength() {
        const val = password.value;
        const checks = {
            min: val.length >= 8,
            upper: /[A-Z]/.test(val),
            lower: /[a-z]/.test(val),
            number: /[0-9]/.test(val),
            special: /[@$!%*#?&._-]/.test(val),
        };

        document.querySelectorAll('.password-check').forEach(el => {
            const req = el.dataset.req;
            const isValid = checks[req];
            el.className = `password-check flex items-center text-sm transition-all duration-300 ${isValid ? 'valid' : 'invalid'}`;
            el.innerHTML = isValid
                ? '<i class="fas fa-check-circle mr-2 text-green-500"></i> <span>' + el.querySelector('span').textContent + '</span>'
                : '<i class="fas fa-circle mr-2 text-[8px]"></i> <span>' + el.querySelector('span').textContent + '</span>';
        });
    }

    function checkMatch() {
        if (confirm.value.length === 0) {
            matchIndicator.className = 'mt-1 text-sm hidden';
            return;
        }
        matchIndicator.className = 'mt-1 text-sm flex items-center';
        if (password.value === confirm.value) {
            matchIndicator.innerHTML = '<i class="fas fa-check-circle mr-1 text-green-500"></i> <span class="text-green-600">Las contraseñas coinciden</span>';
        } else {
            matchIndicator.innerHTML = '<i class="fas fa-times-circle mr-1 text-red-500"></i> <span class="text-red-600">Las contraseñas no coinciden</span>';
        }
    }

    password.addEventListener('input', function () {
        checkPasswordStrength();
        checkMatch();
    });
    confirm.addEventListener('input', checkMatch);
});
</script>
@endpush
