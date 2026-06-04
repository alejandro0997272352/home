@extends('layouts.app')

@section('title', 'Notificaciones')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            <i class="fas fa-bell mr-2 text-indigo-600"></i>Notificaciones
        </h1>
    </div>
    @if($notificaciones->whereNull('read_at')->count() > 0)
        <form method="POST" action="{{ route('notificaciones.markAllRead') }}">
            @csrf
            <button type="submit" class="btn-ripple text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                <i class="fas fa-check-double mr-1"></i> Marcar todas como leídas
            </button>
        </form>
    @endif
</div>

<div class="space-y-3">
    @forelse($notificaciones as $notificacion)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 {{ is_null($notificacion->read_at) ? 'border-l-4 border-indigo-500 bg-indigo-50/50 dark:bg-indigo-900/10' : '' }}">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-3">
                    <div class="mt-0.5">
                        @if($notificacion->type === 'cita_nueva')
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar-plus text-blue-600"></i>
                            </div>
                        @elseif($notificacion->type === 'cita_confirmada')
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                        @elseif($notificacion->type === 'cita_cancelada')
                            <div class="w-10 h-10 bg-red-100 dark:bg-red-900/50 rounded-full flex items-center justify-center">
                                <i class="fas fa-times-circle text-red-600"></i>
                            </div>
                        @elseif($notificacion->type === 'cita_completada')
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/50 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-double text-purple-600"></i>
                            </div>
                        @elseif($notificacion->type === 'review')
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/50 rounded-full flex items-center justify-center">
                                <i class="fas fa-star text-yellow-600"></i>
                            </div>
                        @else
                            <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <i class="fas fa-bell text-gray-600"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $notificacion->title }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">{{ $notificacion->message }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $notificacion->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @if(is_null($notificacion->read_at))
                    <a href="{{ route('notificaciones.read', $notificacion) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium whitespace-nowrap ml-4 transition-colors">
                        <i class="fas fa-check mr-1"></i> Leer
                    </a>
                @endif
            </div>
            @if($notificacion->url)
                <a href="{{ $notificacion->url }}" class="mt-2 inline-block text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                    <i class="fas fa-arrow-right mr-1"></i> Ver detalles
                </a>
            @endif
        </div>
    @empty
        <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <i class="fas fa-bell text-5xl text-gray-300 dark:text-gray-500 mb-4"></i>
            <p class="text-gray-500 dark:text-gray-400 text-lg">No tienes notificaciones</p>
        </div>
    @endforelse
</div>

<div class="mt-6">{{ $notificaciones->links() }}</div>
@endsection
