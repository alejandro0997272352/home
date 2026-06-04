@extends('layouts.app')

@section('title', 'Mis Citas')

@php
    $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $diasSemana = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    $now = now();
    $month = request('cal_mes', $now->month);
    $year = request('cal_anio', $now->year);
    $primerDia = \Carbon\Carbon::create($year, $month, 1);
    $ultimoDia = $primerDia->copy()->endOfMonth();
    $inicioSemana = $primerDia->dayOfWeek;
    $diasEnMes = $ultimoDia->day;
    $citasPorFecha = $citas->groupBy(fn($c) => $c->fecha->format('Y-m-d'));
@endphp

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
            <i class="fas fa-calendar-check mr-2 text-green-600"></i>Mis Citas
        </h1>
    </div>
    <a href="{{ route('estudiante.buscar') }}" class="btn-ripple inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
        <i class="fas fa-plus mr-1"></i> Nueva Cita
    </a>
</div>

<div class="card-hover glass-card rounded-xl shadow-md mb-6">
    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
        <form method="GET" class="flex flex-wrap gap-4">
            <div>
                <select name="estado" class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                    <option value="confirmada" {{ request('estado') === 'confirmada' ? 'selected' : '' }}>Confirmadas</option>
                    <option value="completada" {{ request('estado') === 'completada' ? 'selected' : '' }}>Completadas</option>
                    <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Canceladas</option>
                </select>
            </div>
<button type="submit" class="btn-ripple px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
    <i class="fas fa-filter mr-1"></i> Filtrar
</button>
<button type="button" onclick="toggleCalendar()" class="px-4 py-2.5 bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-xl hover:bg-green-100 dark:hover:bg-green-900/50 transition-all">
                <i class="fas fa-calendar-alt mr-1"></i> <span id="calToggleText">Ver Calendario</span>
            </button>
        </form>
    </div>
</div>

<div id="calendarView" class="hidden card-hover glass-card rounded-xl shadow-md mb-6">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                <i class="fas fa-calendar mr-2 text-green-600"></i>{{ $meses[$month] }} {{ $year }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ request()->fullUrlWithQuery(['cal_mes' => $month == 1 ? 12 : $month - 1, 'cal_anio' => $month == 1 ? $year - 1 : $year]) }}" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                    <i class="fas fa-chevron-left text-sm"></i>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['cal_mes' => $month == 12 ? 1 : $month + 1, 'cal_anio' => $month == 12 ? $year + 1 : $year]) }}" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                    <i class="fas fa-chevron-right text-sm"></i>
                </a>
            </div>
        </div>
        <div class="grid grid-cols-7 gap-1">
            @foreach($diasSemana as $dia)
                <div class="text-center text-xs font-semibold text-gray-500 dark:text-gray-400 py-2">{{ $dia }}</div>
            @endforeach
            @for($i = 0; $i < $inicioSemana; $i++)
                <div></div>
            @endfor
            @for($d = 1; $d <= $diasEnMes; $d++)
                @php
                    $fecha = sprintf('%04d-%02d-%02d', $year, $month, $d);
                    $citasDelDia = $citasPorFecha[$fecha] ?? collect();
                    $tieneCitas = $citasDelDia->isNotEmpty();
                    $esHoy = $fecha === now()->format('Y-m-d');
                @endphp
                <a href="{{ request()->fullUrlWithQuery(['fecha' => $fecha]) }}"
                    class="relative p-2 text-sm rounded-xl transition-all duration-200 text-center
                        {{ $esHoy ? 'bg-green-100 dark:bg-green-900/50 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50' }}
                        {{ $tieneCitas ? 'bg-green-50 dark:bg-green-900/20' : '' }}">
                    <span class="{{ $esHoy ? 'text-green-700 dark:text-green-300' : 'text-gray-700 dark:text-gray-300' }}">{{ $d }}</span>
                    @if($tieneCitas)
                        <div class="flex justify-center gap-0.5 mt-1">
                            @foreach($citasDelDia->take(3) as $cita)
                                <span class="w-1.5 h-1.5 rounded-full
                                    @if($cita->estado === 'pendiente') bg-yellow-400
                                    @elseif($cita->estado === 'confirmada') bg-blue-400
                                    @elseif($cita->estado === 'completada') bg-green-400
                                    @else bg-red-400 @endif">
                                </span>
                            @endforeach
                            @if($citasDelDia->count() > 3)
                                <span class="text-[8px] text-gray-400">+{{ $citasDelDia->count() - 3 }}</span>
                            @endif
                        </div>
                    @endif
                </a>
            @endfor
        </div>
        <div class="flex gap-4 mt-4 text-xs text-gray-500 dark:text-gray-400">
            <span><span class="inline-block w-2.5 h-2.5 rounded-full bg-yellow-400 mr-1"></span> Pendiente</span>
            <span><span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-400 mr-1"></span> Confirmada</span>
            <span><span class="inline-block w-2.5 h-2.5 rounded-full bg-green-400 mr-1"></span> Completada</span>
            <span><span class="inline-block w-2.5 h-2.5 rounded-full bg-red-400 mr-1"></span> Cancelada</span>
        </div>
    </div>
</div>

<div class="card-hover glass-card rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-gray-50 dark:from-gray-800/50 to-green-50 dark:to-green-900/20">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Tutor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Materia</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Horario</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Estado</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($citas as $i => $cita)
                    <tr class="hover:bg-green-50/50 dark:hover:bg-green-900/20 transition-colors duration-150 table-row-glow animate-fade-in stagger-{{ min($loop->index + 1, 10) }}">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $cita->tutor->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $cita->tutor->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $cita->subject->nombre }}</td>
                        <td class="px-6 py-4 text-sm">{{ $cita->fecha->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm">{{ substr($cita->hora_inicio, 0, 5) }} - {{ substr($cita->hora_fin, 0, 5) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium
                                @if($cita->estado === 'pendiente') bg-yellow-100 text-yellow-800 badge-pulse
                                @elseif($cita->estado === 'confirmada') bg-blue-100 text-blue-800
                                @elseif($cita->estado === 'completada') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if(in_array($cita->estado, ['pendiente', 'confirmada']))
                                <button onclick="showCancelModal({{ $cita->id }})" class="text-red-600 hover:text-red-900 hover:scale-110 inline-block transition-transform" title="Cancelar">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            @endif
                            @if($cita->estado === 'completada')
                                @if($cita->review)
                                    <div class="flex items-center justify-center space-x-0.5">
                                        @for($s = 1; $s <= 5; $s++)
                                            <i class="fas fa-star {{ $s <= $cita->review->calificacion ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }} text-xs"></i>
                                        @endfor
                                    </div>
                                @else
                                    <button onclick="showReviewModal({{ $cita->id }}, '{{ $cita->tutor->name }}')" class="text-yellow-600 hover:text-yellow-800 hover:scale-110 inline-block transition-transform" title="Calificar">
                                        <i class="fas fa-star"></i>
                                    </button>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($citas->isEmpty())
        <div class="text-center py-12 text-gray-500 dark:text-gray-400"><i class="fas fa-calendar text-4xl text-gray-300 dark:text-gray-500 mb-3"></i><p>No hay citas registradas</p></div>
    @endif
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30">{{ $citas->links() }}</div>
</div>

<div id="cancelModal" class="fixed inset-0 modal-overlay hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full mx-4 modal-content shadow-2xl">
        <div class="flex items-center mb-4">
            <div class="bg-red-100 dark:bg-red-900/50 p-2 rounded-full mr-3"><i class="fas fa-times-circle text-red-600 text-xl"></i></div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Cancelar Cita</h3>
        </div>
        <form id="cancelForm" method="POST">
            @csrf @method('PATCH')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motivo de cancelación</label>
                <textarea name="motivo_cancelacion" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all"></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideCancelModal()" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">Cerrar</button>
                <button type="submit" class="btn-ripple px-4 py-2.5 bg-gradient-to-r from-red-600 to-rose-600 text-white rounded-xl hover:from-red-700 hover:to-rose-700 transition-all shadow-md">
                    <i class="fas fa-times mr-1"></i> Cancelar Cita
                </button>
            </div>
        </form>
    </div>
</div>

<div id="reviewModal" class="fixed inset-0 modal-overlay hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full mx-4 modal-content shadow-2xl">
        <div class="text-center mb-4">
            <div class="bg-yellow-100 dark:bg-yellow-900/50 p-3 rounded-full inline-flex mb-3">
                <i class="fas fa-star text-yellow-500 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Calificar Tutoría</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" id="reviewTutorName"></p>
        </div>
        <form id="reviewForm" method="POST">
            @csrf
            <div class="text-center mb-4">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tu calificación</p>
                <div class="flex justify-center space-x-2 text-3xl" id="starContainer">
                    <button type="button" class="star-btn text-gray-300 dark:text-gray-600 hover:text-yellow-400 transition-colors" data-value="1"><i class="fas fa-star"></i></button>
                    <button type="button" class="star-btn text-gray-300 dark:text-gray-600 hover:text-yellow-400 transition-colors" data-value="2"><i class="fas fa-star"></i></button>
                    <button type="button" class="star-btn text-gray-300 dark:text-gray-600 hover:text-yellow-400 transition-colors" data-value="3"><i class="fas fa-star"></i></button>
                    <button type="button" class="star-btn text-gray-300 dark:text-gray-600 hover:text-yellow-400 transition-colors" data-value="4"><i class="fas fa-star"></i></button>
                    <button type="button" class="star-btn text-gray-300 dark:text-gray-600 hover:text-yellow-400 transition-colors" data-value="5"><i class="fas fa-star"></i></button>
                </div>
                <input type="hidden" name="calificacion" id="calificacionInput" value="0">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Comentario (opcional)</label>
                <textarea name="comentario" rows="3" placeholder="Comparte tu experiencia..."
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-yellow-500 transition-all"></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideReviewModal()" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">Cancelar</button>
                <button type="submit" class="btn-ripple px-4 py-2.5 bg-gradient-to-r from-yellow-500 to-amber-500 text-white rounded-xl hover:from-yellow-600 hover:to-amber-600 transition-all shadow-md">
                    <i class="fas fa-paper-plane mr-1"></i> Enviar Calificación
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showCancelModal(id) {
    document.getElementById('cancelForm').action = '{{ url("estudiante/citas") }}/' + id + '/cancelar';
    document.getElementById('cancelModal').classList.remove('hidden');
    document.getElementById('cancelModal').classList.add('flex');
}
function hideCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    document.getElementById('cancelModal').classList.remove('flex');
}
function showReviewModal(id, tutorName) {
    document.getElementById('reviewForm').action = '{{ url("estudiante/citas") }}/' + id + '/review';
    document.getElementById('reviewTutorName').textContent = 'Tutoría con ' + tutorName;
    document.getElementById('calificacionInput').value = 0;
    document.querySelectorAll('#starContainer .star-btn').forEach(b => {
        b.className = 'star-btn text-gray-300 dark:text-gray-600 hover:text-yellow-400 transition-colors';
    });
    document.getElementById('reviewModal').classList.remove('hidden');
    document.getElementById('reviewModal').classList.add('flex');
}
function hideReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
    document.getElementById('reviewModal').classList.remove('flex');
}
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#starContainer .star-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const val = parseInt(this.dataset.value);
            document.getElementById('calificacionInput').value = val;
            document.querySelectorAll('#starContainer .star-btn').forEach(b => {
                const bv = parseInt(b.dataset.value);
                b.className = 'star-btn transition-colors ' + (bv <= val ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600');
            });
        });
    });
});
function toggleCalendar() {
    const cal = document.getElementById('calendarView');
    const txt = document.getElementById('calToggleText');
    cal.classList.toggle('hidden');
    txt.textContent = cal.classList.contains('hidden') ? 'Ver Calendario' : 'Ocultar Calendario';
}
@if(request('fecha'))
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('calendarView').classList.remove('hidden');
        document.getElementById('calToggleText').textContent = 'Ocultar Calendario';
    });
@endif
</script>
@endpush
