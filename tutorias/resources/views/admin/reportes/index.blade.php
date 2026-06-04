@extends('layouts.app')

@section('title', 'Reportes')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-file-alt mr-2 text-indigo-600"></i>Reportes
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Estadísticas y reportes del sistema</p>
</div>

<div class="card-hover glass-card rounded-xl shadow-md p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" value="{{ $startDate }}"
                class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha Fin</label>
            <input type="date" name="fecha_fin" value="{{ $endDate }}"
                class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
        </div>
        <button type="submit" class="btn-ripple px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md">
            <i class="fas fa-filter mr-1"></i> Filtrar
        </button>
        <a href="{{ route('admin.reportes.pdf', ['fecha_inicio' => $startDate, 'fecha_fin' => $endDate]) }}" class="btn-ripple px-4 py-2.5 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-xl hover:from-red-700 hover:to-rose-700 transition-all shadow-md">
            <i class="fas fa-file-pdf mr-1"></i> PDF
        </a>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    @php
        $stats = [
            ['label' => 'Total', 'value' => $resumen['total'], 'color' => 'gray', 'icon' => 'fa-calendar'],
            ['label' => 'Pendientes', 'value' => $resumen['pendientes'], 'color' => 'yellow', 'icon' => 'fa-clock'],
            ['label' => 'Confirmadas', 'value' => $resumen['confirmadas'], 'color' => 'blue', 'icon' => 'fa-check'],
            ['label' => 'Completadas', 'value' => $resumen['completadas'], 'color' => 'green', 'icon' => 'fa-check-double'],
            ['label' => 'Canceladas', 'value' => $resumen['canceladas'], 'color' => 'red', 'icon' => 'fa-times'],
        ];
    @endphp
    @foreach($stats as $i => $s)
        <div class="card-hover glass-card rounded-xl shadow-md p-4 text-center">
            <p class="text-2xl font-bold text-{{ $s['color'] }}-600 count-up" data-target="{{ $s['value'] }}">0</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $s['label'] }}</p>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="card-hover glass-card rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-chalkboard-teacher mr-2 text-indigo-600"></i>Citas por Tutor
        </h2>
        <div class="space-y-2">
            @foreach($citasPorTutor as $item)
                <div class="flex justify-between items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 dark:bg-gray-800/50 rounded-xl transition-all">
                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $item->tutor->name ?? 'N/A' }}</span>
                    <span class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium">{{ $item->total }} citas</span>
                </div>
            @endforeach
            @if($citasPorTutor->isEmpty())
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Sin datos</p>
            @endif
        </div>
    </div>
    <div class="card-hover glass-card rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-book mr-2 text-indigo-600"></i>Citas por Materia
        </h2>
        <div class="space-y-2">
            @foreach($citasPorMateria as $item)
                <div class="flex justify-between items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 dark:bg-gray-800/50 rounded-xl transition-all">
                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $item->subject->nombre ?? 'N/A' }}</span>
                    <span class="bg-purple-100 dark:bg-purple-900/50 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">{{ $item->total }} citas</span>
                </div>
            @endforeach
            @if($citasPorMateria->isEmpty())
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Sin datos</p>
            @endif
        </div>
    </div>
</div>

<div class="card-hover glass-card rounded-xl shadow-md overflow-hidden">
    <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 dark:from-gray-800/50 to-indigo-50 dark:to-indigo-900/20">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
            <i class="fas fa-list mr-2 text-indigo-600"></i>Detalle de Citas
        </h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800/50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Fecha</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Tutor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Estudiante</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Materia</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Estado</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Motivo</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($citas as $cita)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 dark:bg-gray-800/50 transition-colors duration-150 table-row-glow animate-fade-in stagger-{{ min($loop->index + 1, 10) }}">
                        <td class="px-4 py-3 text-sm">{{ $cita->fecha->format('d/m/Y') }} {{ substr($cita->hora_inicio, 0, 5) }}</td>
                        <td class="px-4 py-3 text-sm font-medium">{{ $cita->tutor->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $cita->student->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $cita->subject->nombre }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium
                                @if($cita->estado === 'pendiente') bg-yellow-100 text-yellow-800 badge-pulse
                                @elseif($cita->estado === 'confirmada') bg-blue-100 text-blue-800
                                @elseif($cita->estado === 'completada') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                            @if($cita->estado === 'cancelada' && $cita->motivo_cancelacion)
                                <span class="text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <i class="fas fa-comment text-xs"></i>
                                    {{ $cita->motivo_cancelacion }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($citas->isEmpty())
        <div class="text-center py-8 text-gray-500 dark:text-gray-400">No hay citas en este período</div>
    @endif
</div>
@endsection
