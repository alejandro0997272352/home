@extends('layouts.app')

@section('title', 'Mi Disponibilidad')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
        <i class="fas fa-clock mr-2 text-blue-600"></i>Mi Disponibilidad
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Gestiona tus horarios disponibles para tutorías</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-plus-circle mr-2 text-green-600"></i>Agregar Horario
        </h2>
        <form method="POST" action="{{ route('tutor.disponibilidad') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Día</label>
                <select name="dia_semana" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
                    @foreach($dias as $dia)
                        <option value="{{ $dia }}">{{ $dia }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora Inicio</label>
                <input type="time" name="hora_inicio" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora Fin</label>
                <input type="time" name="hora_fin" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            @error('error')
                <p class="text-red-500 text-sm mb-3 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
            @enderror
            <button type="submit" class="btn-ripple w-full bg-gradient-to-r from-blue-600 to-cyan-600 text-white py-2.5 rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-all shadow-md">
                <i class="fas fa-plus mr-1"></i> Agregar
            </button>
        </form>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                <i class="fas fa-list mr-2 text-blue-600"></i>Horarios Actuales
            </h2>
            @if($horarios->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($dias as $dia)
                        @php $diaHorarios = $agrupado->get($dia, collect()); @endphp
                        @if($diaHorarios->isNotEmpty())
                            <div class="border border-blue-100 dark:border-blue-900/50 rounded-xl p-4 bg-gradient-to-br from-blue-50 dark:from-blue-900/20 to-white">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center">
                                    <i class="fas fa-calendar-day mr-2 text-blue-500"></i>{{ $dia }}
                                </h3>
                                <div class="space-y-2">
                                    @foreach($diaHorarios as $h)
                                        <div class="flex justify-between items-center bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 p-2.5 rounded-lg hover:shadow-sm transition-all">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                <i class="far fa-clock mr-1 text-gray-400 dark:text-gray-500"></i>{{ substr($h->hora_inicio, 0, 5) }} - {{ substr($h->hora_fin, 0, 5) }}
                                            </span>
                                            <form method="POST" action="{{ route('tutor.disponibilidad.destroy', $h) }}" class="inline"
                                                  onsubmit="return confirm('¿Eliminar este horario?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-ripple text-red-500 hover:text-red-700 hover:bg-red-50 p-1.5 rounded-lg transition-all" title="Eliminar">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-calendar-plus text-5xl text-gray-300 dark:text-gray-500 mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No has agregado horarios disponibles</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500">Usa el formulario para agregar tu disponibilidad</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
