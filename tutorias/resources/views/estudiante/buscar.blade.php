@extends('layouts.app')

@section('title', 'Buscar Tutores')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
        <i class="fas fa-search mr-2 text-green-600"></i>Buscar Tutores
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Encuentra al tutor ideal para tus necesidades académicas</p>
</div>

<div class="card-hover glass-card rounded-xl shadow-md mb-6">
    <div class="p-4">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-400 font-medium mb-1">Buscar por nombre</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre del tutor..."
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all">
            </div>
            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-400 font-medium mb-1">Materia</label>
                <select name="subject_id" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all">
                    <option value="">Todas las materias</option>
                    @foreach($materias as $materia)
                        <option value="{{ $materia->id }}" {{ request('subject_id') == $materia->id ? 'selected' : '' }}>{{ $materia->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-400 font-medium mb-1">Día</label>
                <select name="dia" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all">
                    <option value="">Cualquier día</option>
                    @foreach($dias as $dia)
                        <option value="{{ $dia }}" {{ request('dia') === $dia ? 'selected' : '' }}>{{ $dia }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-ripple w-full px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all shadow-md">
                    <i class="fas fa-search mr-1"></i> Buscar
                </button>
            </div>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($tutores as $i => $tutor)
        <div class="glass-card rounded-2xl shadow-lg overflow-hidden card-hover animate-slide-up stagger-{{ min($i + 1, 10) }}">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-4">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-full overflow-hidden ring-2 ring-white/40 flex-shrink-0 profile-photo">
                        @if($tutor->foto_perfil)
                            <img src="{{ $tutor->foto_url }}" alt="Foto" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-white/20 flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-xl text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="text-white min-w-0">
                        <h3 class="font-semibold text-lg truncate">{{ $tutor->name }}</h3>
                        @if($tutor->tutorProfile)
                            <p class="text-white/90 text-sm">
                                @for($star = 1; $star <= 5; $star++)
                                    <i class="fas fa-star {{ $star <= round($tutor->tutorProfile->calificacion_promedio) ? 'text-yellow-300' : 'text-white/30' }}"></i>
                                @endfor
                                <span class="ml-1">({{ number_format($tutor->tutorProfile->calificacion_promedio, 1) }})</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-5">
                @if($tutor->tutorProfile && $tutor->tutorProfile->biografia)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">{{ $tutor->tutorProfile->biografia }}</p>
                @endif

                <div class="mb-3">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-1.5">Materias:</p>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($tutor->subjects as $subject)
                            <span class="px-2.5 py-1 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 rounded-full text-xs font-medium">{{ $subject->nombre }}</span>
                        @endforeach
                    </div>
                </div>

                @if($tutor->tutorProfile)
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-4 p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                        <span><i class="fas fa-session text-green-500 mr-1"></i> {{ $tutor->tutorProfile->total_sesiones }} sesiones</span>
                        @if($tutor->tutorProfile->tarifa_por_hora > 0)
                            <span class="font-semibold text-green-600">${{ number_format($tutor->tutorProfile->tarifa_por_hora, 2) }}/hr</span>
                        @endif
                    </div>
                @endif

                <div class="flex gap-2">
<a href="{{ route('estudiante.tutor.show', $tutor) }}"
    class="flex-1 text-center px-4 py-2.5 border border-green-600 text-green-600 rounded-xl hover:bg-green-50 dark:hover:bg-green-900/30 transition-all text-sm font-medium">
                        <i class="fas fa-user mr-1"></i> Ver Perfil
                    </a>
                    <button onclick="agendarCita({{ $tutor->id }}, '{{ $tutor->name }}')"
                        class="flex-1 px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all shadow-md hover:shadow-lg text-sm">
                        <i class="fas fa-calendar-plus mr-1"></i> Agendar
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if($tutores->isEmpty())
    <div class="text-center py-16">
        <i class="fas fa-search text-6xl text-gray-300 dark:text-gray-500 mb-4"></i>
        <p class="text-gray-500 dark:text-gray-400 text-xl">No se encontraron tutores</p>
        <p class="text-gray-400 dark:text-gray-500">Intenta ajustar los filtros de búsqueda</p>
    </div>
@endif

<div class="mt-6">{{ $tutores->links() }}</div>

<div id="appointmentModal" class="fixed inset-0 modal-overlay hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full mx-4 max-h-screen overflow-y-auto modal-content shadow-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200" id="modalTitle">Agendar Tutoría</h3>
            <button onclick="hideModal()" title="Cerrar" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-lg transition-all"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST" action="{{ route('estudiante.citas.store') }}">
            @csrf
            <input type="hidden" name="tutor_id" id="tutorId">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Materia *</label>
                <select name="subject_id" id="subjectSelect" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all">
                    <option value="">Selecciona una materia</option>
                    @foreach($materias as $materia)
                        <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha *</label>
                <input type="date" name="fecha" id="fechaInput" required min="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora Inicio *</label>
                    <input type="time" name="hora_inicio" id="horaInicio" required
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora Fin *</label>
                    <input type="time" name="hora_fin" id="horaFin" required
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Modalidad *</label>
                <select name="modalidad" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all">
                    <option value="presencial">Presencial</option>
                    <option value="en_linea">En Línea</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ubicación / Link</label>
                <input type="text" name="ubicacion"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notas</label>
                <textarea name="notas" rows="2"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all"></textarea>
            </div>

            <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-900/50">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="repeat_weekly" value="1" id="repeatCheck"
                        class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        <i class="fas fa-repeat mr-1 text-blue-500"></i>Repetir semanalmente
                    </span>
                </label>
                <div id="repeatUntilWrapper" class="hidden mt-3 ml-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hasta *</label>
                    <input type="date" name="repeat_until" id="repeatUntilInput" min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-green-500 transition-all">
                </div>
            </div>

            <div id="disponibilidadTutor" class="mb-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-100 dark:border-green-900/50">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                    <i class="fas fa-clock mr-2 text-green-500"></i>Disponibilidad del tutor:
                </p>
                <div id="disponibilidadContent" class="text-sm text-gray-500 dark:text-gray-400">Cargando...</div>
            </div>

            <button type="submit" class="btn-ripple w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-2.5 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all shadow-md">
                <i class="fas fa-paper-plane mr-1"></i> Solicitar Tutoría
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function agendarCita(tutorId, tutorName) {
    document.getElementById('tutorId').value = tutorId;
    document.getElementById('modalTitle').textContent = 'Agendar con ' + tutorName;
    document.getElementById('appointmentModal').classList.remove('hidden');
    document.getElementById('appointmentModal').classList.add('flex');

    fetch('/estudiante/tutores/' + tutorId + '/disponibilidad')
        .then(r => r.json())
        .then(data => {
            const container = document.getElementById('disponibilidadContent');
            if (data.horarios && Object.keys(data.horarios).length > 0) {
                let html = '<div class="grid grid-cols-2 gap-2">';
                for (const [dia, horarios] of Object.entries(data.horarios)) {
                    html += '<div class="border border-green-200 dark:border-green-800/50 rounded-lg p-2.5 bg-white dark:bg-gray-800">';
                    html += '<p class="font-medium text-xs text-green-700 mb-1">' + dia + '</p>';
                    horarios.forEach(h => {
                        html += '<p class="text-xs text-gray-600 dark:text-gray-400"><i class="far fa-clock mr-1"></i>' + h.hora_inicio.substring(0,5) + ' - ' + h.hora_fin.substring(0,5) + '</p>';
                    });
                    html += '</div>';
                }
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = '<p class="text-yellow-600 flex items-center"><i class="fas fa-exclamation-triangle mr-1"></i>Este tutor no tiene horarios disponibles registrados.</p>';
            }
        })
        .catch(() => {
            document.getElementById('disponibilidadContent').innerHTML = '<p class="text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>Error al cargar disponibilidad</p>';
        });
}

document.getElementById('repeatCheck').addEventListener('change', function() {
    document.getElementById('repeatUntilWrapper').classList.toggle('hidden', !this.checked);
});

function hideModal() {
    document.getElementById('appointmentModal').classList.add('hidden');
    document.getElementById('appointmentModal').classList.remove('flex');
    document.getElementById('repeatCheck').checked = false;
    document.getElementById('repeatUntilWrapper').classList.add('hidden');
}
</script>
@endpush
