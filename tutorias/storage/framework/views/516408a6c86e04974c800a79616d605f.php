<?php $__env->startSection('title', 'Mis Citas'); ?>

<?php
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
?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
        <i class="fas fa-calendar-check mr-2 text-blue-600"></i>Mis Citas
    </h1>
</div>

<div class="card-hover glass-card rounded-xl shadow-md mb-6">
    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
        <form method="GET" class="flex flex-wrap gap-4">
            <div>
                <select name="estado" class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" <?php echo e(request('estado') === 'pendiente' ? 'selected' : ''); ?>>Pendientes</option>
                    <option value="confirmada" <?php echo e(request('estado') === 'confirmada' ? 'selected' : ''); ?>>Confirmadas</option>
                    <option value="completada" <?php echo e(request('estado') === 'completada' ? 'selected' : ''); ?>>Completadas</option>
                    <option value="cancelada" <?php echo e(request('estado') === 'cancelada' ? 'selected' : ''); ?>>Canceladas</option>
                </select>
            </div>
            <div>
                <input type="date" name="fecha" value="<?php echo e(request('fecha')); ?>"
                    class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
<button type="submit" class="btn-ripple px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
    <i class="fas fa-filter mr-1"></i> Filtrar
</button>
<button type="button" onclick="toggleCalendar()" class="px-4 py-2.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all">
                <i class="fas fa-calendar-alt mr-1"></i> <span id="calToggleText">Ver Calendario</span>
            </button>
        </form>
    </div>
</div>

<div id="calendarView" class="hidden card-hover glass-card rounded-xl shadow-md mb-6">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                <i class="fas fa-calendar mr-2 text-blue-600"></i><?php echo e($meses[$month]); ?> <?php echo e($year); ?>

            </h2>
            <div class="flex gap-2">
                <a href="<?php echo e(request()->fullUrlWithQuery(['cal_mes' => $month == 1 ? 12 : $month - 1, 'cal_anio' => $month == 1 ? $year - 1 : $year])); ?>" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                    <i class="fas fa-chevron-left text-sm"></i>
                </a>
                <a href="<?php echo e(request()->fullUrlWithQuery(['cal_mes' => $month == 12 ? 1 : $month + 1, 'cal_anio' => $month == 12 ? $year + 1 : $year])); ?>" class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                    <i class="fas fa-chevron-right text-sm"></i>
                </a>
            </div>
        </div>
        <div class="grid grid-cols-7 gap-1">
            <?php $__currentLoopData = $diasSemana; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="text-center text-xs font-semibold text-gray-500 dark:text-gray-400 py-2"><?php echo e($dia); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php for($i = 0; $i < $inicioSemana; $i++): ?>
                <div></div>
            <?php endfor; ?>
            <?php for($d = 1; $d <= $diasEnMes; $d++): ?>
                <?php
                    $fecha = sprintf('%04d-%02d-%02d', $year, $month, $d);
                    $citasDelDia = $citasPorFecha[$fecha] ?? collect();
                    $tieneCitas = $citasDelDia->isNotEmpty();
                    $esHoy = $fecha === now()->format('Y-m-d');
                ?>
                <a href="<?php echo e(request()->fullUrlWithQuery(['fecha' => $fecha])); ?>"
                    class="relative p-2 text-sm rounded-xl transition-all duration-200 text-center
                        <?php echo e($esHoy ? 'bg-blue-100 dark:bg-blue-900/50 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-700/50'); ?>

                        <?php echo e($tieneCitas ? 'bg-blue-50 dark:bg-blue-900/20' : ''); ?>">
                    <span class="<?php echo e($esHoy ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300'); ?>"><?php echo e($d); ?></span>
                    <?php if($tieneCitas): ?>
                        <div class="flex justify-center gap-0.5 mt-1">
                            <?php $__currentLoopData = $citasDelDia->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="w-1.5 h-1.5 rounded-full
                                    <?php if($cita->estado === 'pendiente'): ?> bg-yellow-400
                                    <?php elseif($cita->estado === 'confirmada'): ?> bg-blue-400
                                    <?php elseif($cita->estado === 'completada'): ?> bg-green-400
                                    <?php else: ?> bg-red-400 <?php endif; ?>">
                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($citasDelDia->count() > 3): ?>
                                <span class="text-[8px] text-gray-400">+<?php echo e($citasDelDia->count() - 3); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </a>
            <?php endfor; ?>
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
            <thead class="bg-gradient-to-r from-gray-50 dark:from-gray-800/50 to-blue-50 dark:to-blue-900/20">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Estudiante</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Materia</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Horario</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Estado</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <?php $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/20 transition-colors duration-150 table-row-glow animate-fade-in stagger-<?php echo e(min($loop->index + 1, 10)); ?>">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900 dark:text-gray-100"><?php echo e($cita->student->name); ?></div>
                            <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($cita->student->email); ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400"><?php echo e($cita->subject->nombre); ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo e($cita->fecha->format('d/m/Y')); ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo e(substr($cita->hora_inicio, 0, 5)); ?> - <?php echo e(substr($cita->hora_fin, 0, 5)); ?></td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium
<?php if($cita->estado === 'pendiente'): ?> bg-yellow-100 text-yellow-800 badge-pulse
                                                                 <?php elseif($cita->estado === 'confirmada'): ?> bg-blue-100 text-blue-800
                                                                 <?php elseif($cita->estado === 'completada'): ?> bg-green-100 text-green-800
                                                                 <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                                                <?php echo e(ucfirst($cita->estado)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if($cita->estado === 'pendiente'): ?>
                                <form method="POST" action="<?php echo e(route('tutor.citas.confirmar', $cita)); ?>" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="btn-ripple text-green-600 hover:text-green-900 mx-1 hover:scale-110 inline-block transition-transform" title="Confirmar">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <?php if($cita->estado === 'confirmada'): ?>
                                <form method="POST" action="<?php echo e(route('tutor.citas.completar', $cita)); ?>" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="btn-ripple text-blue-600 hover:text-blue-900 mx-1 hover:scale-110 inline-block transition-transform" title="Completar">
                                        <i class="fas fa-check-double"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <?php if(in_array($cita->estado, ['pendiente', 'confirmada'])): ?>
                                <button onclick="showCancelModal(<?php echo e($cita->id); ?>)" class="text-red-600 hover:text-red-900 mx-1 hover:scale-110 inline-block transition-transform" title="Cancelar">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php if($citas->isEmpty()): ?>
        <div class="text-center py-12 text-gray-500 dark:text-gray-400"><i class="fas fa-calendar text-4xl text-gray-300 dark:text-gray-500 mb-3"></i><p>No hay citas</p></div>
    <?php endif; ?>
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30"><?php echo e($citas->links()); ?></div>
</div>

<div id="cancelModal" class="fixed inset-0 modal-overlay hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full mx-4 modal-content shadow-2xl">
        <div class="flex items-center mb-4">
            <div class="bg-red-100 dark:bg-red-900/50 p-2 rounded-full mr-3"><i class="fas fa-times-circle text-red-600 text-xl"></i></div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Cancelar Cita</h3>
        </div>
        <form id="cancelForm" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motivo de cancelación *</label>
                <textarea name="motivo_cancelacion" required rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 transition-all"></textarea>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function showCancelModal(id) {
    document.getElementById('cancelForm').action = '<?php echo e(url("tutor/citas")); ?>/' + id + '/cancelar';
    document.getElementById('cancelModal').classList.remove('hidden');
    document.getElementById('cancelModal').classList.add('flex');
}
function hideCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    document.getElementById('cancelModal').classList.remove('flex');
}
function toggleCalendar() {
    const cal = document.getElementById('calendarView');
    const txt = document.getElementById('calToggleText');
    cal.classList.toggle('hidden');
    txt.textContent = cal.classList.contains('hidden') ? 'Ver Calendario' : 'Ocultar Calendario';
}
<?php if(request('fecha')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('calendarView').classList.remove('hidden');
        document.getElementById('calToggleText').textContent = 'Ocultar Calendario';
    });
<?php endif; ?>
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alejandro/home/tutorias/resources/views/tutor/citas.blade.php ENDPATH**/ ?>