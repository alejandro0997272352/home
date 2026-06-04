@extends('layouts.app')

@section('title', 'Moderar Reviews')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            <i class="fas fa-star mr-2 text-indigo-600"></i>Moderar Reviews
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Aprueba o elimina reseñas de estudiantes</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.reviews.index', ['filtro' => 'pendientes']) }}"
            class="btn-ripple px-4 py-2 rounded-xl text-sm font-medium transition-all
                {{ request('filtro') === 'pendientes' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
            <i class="fas fa-clock mr-1"></i> Pendientes
        </a>
        <a href="{{ route('admin.reviews.index', ['filtro' => 'aprobadas']) }}"
            class="btn-ripple px-4 py-2 rounded-xl text-sm font-medium transition-all
                {{ request('filtro') === 'aprobadas' ? 'bg-green-100 text-green-800' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
            <i class="fas fa-check mr-1"></i> Aprobadas
        </a>
        <a href="{{ route('admin.reviews.index') }}"
            class="btn-ripple px-4 py-2 rounded-xl text-sm font-medium transition-all
                {{ !request('filtro') ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
            <i class="fas fa-list mr-1"></i> Todas
        </a>
    </div>
</div>

<div class="card-hover glass-card rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-gray-50 dark:from-gray-800/50 to-indigo-50 dark:to-indigo-900/20">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Estudiante</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Tutor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Materia</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Calificación</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Comentario</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Estado</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($reviews as $review)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 table-row-glow animate-fade-in stagger-{{ min($loop->index + 1, 10) }}">
                        <td class="px-4 py-3 text-sm font-medium">{{ $review->user->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $review->appointment?->tutor?->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $review->appointment?->subject?->nombre ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center space-x-0.5">
                                @for($s = 1; $s <= 5; $s++)
                                    <i class="fas fa-star {{ $s <= $review->calificacion ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }} text-xs"></i>
                                @endfor
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate">{{ $review->comentario ?: '—' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($review->aprobado)
                                <span class="px-2.5 py-1 text-xs rounded-full font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-0.5"></i> Aprobada
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs rounded-full font-medium bg-yellow-100 text-yellow-800 badge-pulse">
                                    <i class="fas fa-clock mr-0.5"></i> Pendiente
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if(!$review->aprobado)
                                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-ripple text-green-600 hover:text-green-900 mx-1 hover:scale-110 inline-block transition-transform" title="Aprobar">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="inline"
                                onsubmit="return confirm('¿Eliminar esta review?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 mx-1 hover:scale-110 inline-block transition-transform" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($reviews->isEmpty())
        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
            <i class="fas fa-star text-4xl text-gray-300 dark:text-gray-500 mb-3"></i>
            <p>No hay reviews</p>
        </div>
    @endif
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30">
        {{ $reviews->links() }}
    </div>
</div>
@endsection
