@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('estudiante.buscar') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 mb-6 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Volver a resultados
    </a>

    <div class="glass-card rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10 text-white">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-full flex items-center justify-center overflow-hidden ring-4 ring-white/30 shadow-lg">
                    @if($user->foto_perfil)
                        <img src="{{ $user->foto_url }}" alt="Foto" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-white/20 flex items-center justify-center text-4xl">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                    <p class="text-indigo-200 mt-1">
                        <i class="fas fa-chalkboard-teacher mr-1"></i> Tutor
                        @if($stats['calificacion_promedio'] > 0)
                            <span class="ml-3"><i class="fas fa-star text-yellow-300 mr-1"></i> {{ number_format($stats['calificacion_promedio'], 1) }}</span>
                        @endif
                        <span class="ml-3"><i class="fas fa-session mr-1"></i> {{ $stats['total_sesiones'] }} sesiones</span>
                    </p>
                </div>
                <form method="POST" action="{{ route('chat.start', $user) }}">
                    @csrf
                    <button type="submit" class="btn-ripple px-4 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-xl transition-all backdrop-blur-sm border border-white/20 flex items-center gap-2">
                        <i class="fas fa-comment"></i>
                        <span class="hidden sm:inline">Mensaje</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="p-8 animate-slide-up stagger-1">
            @if($user->tutorProfile?->biografia)
                <div class="mb-8 card-hover glass-card rounded-xl p-6 animate-scale-in stagger-2">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-indigo-600"></i>Acerca de
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $user->tutorProfile->biografia }}</p>
                </div>
            @endif

            @if($user->tutorProfile?->formacion_academica)
                <div class="mb-8 card-hover glass-card rounded-xl p-6 animate-scale-in stagger-3">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center">
                        <i class="fas fa-graduation-cap mr-2 text-indigo-600"></i>Formación Académica
                    </h2>
                    <div class="bg-indigo-50 dark:bg-indigo-900/30 rounded-xl p-4">
                        <p class="text-gray-700 dark:text-gray-300">{{ $user->tutorProfile->formacion_academica }}</p>
                    </div>
                </div>
            @endif

            <div class="grid md:grid-cols-2 gap-8 mb-8 animate-slide-up stagger-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center">
                        <i class="fas fa-book mr-2 text-indigo-600"></i>Materias
                    </h2>
                    @if($user->subjects->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->subjects as $subject)
                                <span class="px-3 py-1.5 bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 rounded-full text-sm font-medium">
                                    {{ $subject->nombre }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Sin materias asignadas</p>
                    @endif
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center">
                        <i class="fas fa-clock mr-2 text-indigo-600"></i>Disponibilidad
                    </h2>
                    @if($user->availability->isNotEmpty())
                        <div class="space-y-2">
                            @foreach($user->availability as $slot)
                                <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700/50 rounded-lg px-4 py-2 text-sm">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $slot->dia_semana }}</span>
                                    <span class="text-gray-600 dark:text-gray-400">{{ substr($slot->hora_inicio, 0, 5) }} - {{ substr($slot->hora_fin, 0, 5) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Sin disponibilidad registrada</p>
                    @endif
                </div>
            </div>

            <div class="animate-slide-up stagger-5">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <i class="fas fa-star mr-2 text-yellow-500"></i>Reseñas
                    @if($stats['total_reviews'] > 0)
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">({{ $stats['total_reviews'] }})</span>
                    @endif
                </h2>
                @if($reviews->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($reviews as $i => $review)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 card-hover animate-fade-in stagger-{{ min($i + 1, 10) }}">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-xs text-indigo-600"></i>
                                        </div>
                                        <span class="font-medium text-gray-800 dark:text-gray-200 text-sm">{{ $review->user->name }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-xs {{ $i <= $review->calificacion ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                @if($review->comentario)
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $review->comentario }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="far fa-star text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                        <p>Este tutor aún no tiene reseñas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
