@extends('layouts.app')

@section('title', 'Recuperar Contraseña')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-red-500 to-rose-600 rounded-full mb-4 shadow-lg">
                <i class="fas fa-lock text-2xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-red-600 to-rose-600 bg-clip-text text-transparent">Recuperar Contraseña</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Ingresa tu correo y te enviaremos un enlace</p>
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    <i class="fas fa-envelope mr-1 text-red-500"></i> Correo Electrónico
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('email') border-red-500 ring-2 ring-red-200 @enderror">
                @error('email')
                    <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-ripple w-full bg-gradient-to-r from-red-600 to-rose-600 text-white py-2.5 px-4 rounded-xl hover:from-red-700 hover:to-rose-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-lg">
                <i class="fas fa-paper-plane mr-2"></i> Enviar Enlace
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium hover:underline transition-all">
                <i class="fas fa-arrow-left mr-1"></i> Volver al inicio de sesión
            </a>
        </p>
    </div>
</div>
@endsection
