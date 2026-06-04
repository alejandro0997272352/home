@extends('layouts.app')

@section('title', 'Verificar Email')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 w-full max-w-md text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-full mb-6 shadow-lg">
            <i class="fas fa-envelope text-3xl text-white"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">Verifica tu correo electrónico</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Hemos enviado un enlace de verificación a <strong>{{ auth()->user()->email }}</strong>.
            Revisa tu bandeja de entrada y haz clic en el enlace para activar tu cuenta.
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
            @csrf
            <button type="submit" class="btn-ripple px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md">
                <i class="fas fa-paper-plane mr-2"></i> Reenviar enlace
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-ripple text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 underline transition-colors">
                Cerrar sesión
            </button>
        </form>
    </div>
</div>
@endsection
