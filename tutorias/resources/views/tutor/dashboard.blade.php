@extends('layouts.app')

@section('title', 'Panel del Tutor')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
        <i class="fas fa-chalkboard-teacher mr-2 text-blue-600"></i>Panel del Tutor
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Bienvenido, {{ auth()->user()->name }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
    @php
        $cards = [
            ['label' => 'Total Citas', 'value' => $totalCitas, 'color' => 'blue', 'icon' => 'fa-calendar'],
            ['label' => 'Completadas', 'value' => $citasCompletadas, 'color' => 'green', 'icon' => 'fa-check-circle'],
            ['label' => 'Pendientes', 'value' => $citasPendientes, 'color' => 'orange', 'icon' => 'fa-clock'],
            ['label' => 'Hoy', 'value' => $citasHoy, 'color' => 'indigo', 'icon' => 'fa-calendar-day'],
            ['label' => 'Horas Impartidas', 'value' => number_format($horasTotales, 1), 'color' => 'purple', 'icon' => 'fa-clock'],
        ];
    @endphp
    @foreach($cards as $i => $card)
        <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-{{ min($i + 1, 6) }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">{{ $card['label'] }}</p>
                    <p class="text-3xl font-bold text-{{ $card['color'] }}-600">
                        <span class="count-up" data-target="{{ $card['value'] }}">0</span>
                    </p>
                </div>
                <div class="bg-gradient-to-br from-{{ $card['color'] }}-100 to-{{ $card['color'] }}-200 p-3 rounded-xl">
                    <i class="fas {{ $card['icon'] }} text-2xl text-{{ $card['color'] }}-600 icon-anim"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-5">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-chart-bar mr-2 text-blue-600 icon-anim"></i>Citas por Mes
        </h2>
        <canvas id="chartMes" height="180"></canvas>
    </div>
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-chart-pie mr-2 text-blue-600 icon-anim"></i>Por Estado
        </h2>
        <canvas id="chartEstado" height="180"></canvas>
    </div>
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-7">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-clock mr-2 text-blue-600 icon-anim"></i>Próximas Citas
        </h2>
        @if($proximasCitas->isNotEmpty())
            <div class="space-y-2">
                @foreach($proximasCitas as $cita)
                    <div class="border border-gray-100 dark:border-gray-700 rounded-xl p-3 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 transition-all duration-200">
                        <div class="flex justify-between items-start">
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 dark:text-gray-100 text-sm truncate">{{ $cita->student->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    <i class="far fa-calendar mr-1"></i>{{ $cita->fecha->format('d/m/Y') }}
                                    <i class="far fa-clock ml-2 mr-1"></i>{{ substr($cita->hora_inicio, 0, 5) }}
                                </p>
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full font-medium flex-shrink-0
                                @if($cita->estado === 'pendiente') bg-yellow-100 text-yellow-800 badge-pulse
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500 dark:text-gray-400 text-sm">Sin citas próximas</div>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-8">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-book mr-2 text-blue-600 icon-anim"></i>Mis Materias
        </h2>
        @if($materias->isNotEmpty())
            <div class="flex flex-wrap gap-2">
                @foreach($materias as $materia)
                    <span class="px-3 py-1.5 bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 rounded-full text-sm font-medium">{{ $materia->nombre }}</span>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400 text-center py-6">No tienes materias asignadas</p>
        @endif
    </div>
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-9">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-chart-line mr-2 text-blue-600 icon-anim"></i>Resumen
        </h2>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ $citasCompletadas }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400">Completadas</p>
            </div>
            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ $citasPendientes }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400">Pendientes</p>
            </div>
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $citasConfirmadas }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400">Confirmadas</p>
            </div>
            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-red-600">{{ $citasCanceladas }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400">Canceladas</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('chartMes'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($citasPorMes->map(fn($i) => \Carbon\Carbon::create()->month($i->mes)->translatedFormat('M'))) !!},
            datasets: [{
                label: 'Citas',
                data: {!! json_encode($citasPorMes->pluck('total')) !!},
                backgroundColor: 'rgba(59,130,246,0.5)',
                borderColor: '#3b82f6',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('chartEstado'), {
        type: 'doughnut',
        data: {
            labels: ['Pendientes', 'Confirmadas', 'Completadas', 'Canceladas'],
            datasets: [{
                data: [
                    {{ $estados['pendiente'] ?? 0 }},
                    {{ $estados['confirmada'] ?? 0 }},
                    {{ $estados['completada'] ?? 0 }},
                    {{ $estados['cancelada'] ?? 0 }}
                ],
                backgroundColor: ['#eab308', '#3b82f6', '#22c55e', '#ef4444'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 12, usePointStyle: true, pointStyle: 'circle' }
                }
            }
        }
    });
});
</script>
@endpush
