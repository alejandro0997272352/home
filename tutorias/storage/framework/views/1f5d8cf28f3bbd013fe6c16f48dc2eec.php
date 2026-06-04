<?php $__env->startSection('title', 'Panel de Administración'); ?>

<?php $__env->startPush('styles'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-chart-pie mr-2 text-indigo-600"></i>Panel de Administración
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Bienvenido, <?php echo e(auth()->user()->name); ?></p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Total Usuarios</p>
                <p class="text-3xl font-bold text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text">
                    <span class="count-up" data-target="<?php echo e($totalUsuarios); ?>">0</span>
                </p>
            </div>
            <div class="bg-gradient-to-br from-indigo-100 to-indigo-200 p-3 rounded-xl">
                <i class="fas fa-users text-2xl text-indigo-600"></i>
            </div>
        </div>
        <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
            <span class="text-blue-600 font-medium"><?php echo e($totalTutores); ?> tutores</span>
            <span class="mx-1">·</span>
            <span class="text-green-600 font-medium"><?php echo e($totalEstudiantes); ?> estudiantes</span>
        </div>
    </div>
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-2">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Total Citas</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                    <span class="count-up" data-target="<?php echo e($totalCitas); ?>">0</span>
                </p>
            </div>
            <div class="bg-gradient-to-br from-yellow-100 to-amber-200 p-3 rounded-xl">
                <i class="fas fa-calendar text-2xl text-yellow-600"></i>
            </div>
        </div>
        <div class="mt-3 flex gap-3 text-xs text-gray-500 dark:text-gray-400">
            <span><span class="text-orange-600 font-medium"><?php echo e($citasPendientes); ?></span> pendientes</span>
            <span><span class="text-green-600 font-medium"><?php echo e($citasCompletadas); ?></span> completadas</span>
            <span><span class="text-red-600 font-medium"><?php echo e($citasCanceladas); ?></span> canceladas</span>
        </div>
    </div>
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-3">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Materias</p>
                <p class="text-3xl font-bold text-purple-600">
                    <span class="count-up" data-target="<?php echo e($totalMaterias); ?>">0</span>
                </p>
            </div>
            <div class="bg-gradient-to-br from-purple-100 to-purple-200 p-3 rounded-xl">
                <i class="fas fa-book text-2xl text-purple-600"></i>
            </div>
        </div>
        <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">Materias registradas en el sistema</div>
    </div>
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Citas Hoy</p>
                <p class="text-3xl font-bold text-pink-600">
                    <span class="count-up" data-target="<?php echo e($citasHoy ?? 0); ?>">0</span>
                </p>
            </div>
            <div class="bg-gradient-to-br from-pink-100 to-pink-200 p-3 rounded-xl">
                <i class="fas fa-calendar-day text-2xl text-pink-600"></i>
            </div>
        </div>
        <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">Citas programadas para hoy</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-5">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-users mr-2 text-indigo-600"></i>Usuarios por Rol
        </h2>
        <canvas id="usuariosChart" height="200"></canvas>
    </div>
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-chart-pie mr-2 text-yellow-500"></i>Estado de Citas
        </h2>
        <canvas id="citasChart" height="200"></canvas>
    </div>
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-7">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-trophy mr-2 text-yellow-500"></i>Top 5 Tutores
        </h2>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $tutoresTop; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tutor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between p-3 <?php echo e($index === 0 ? 'bg-gradient-to-r from-yellow-50 dark:from-yellow-900/30 to-amber-50 rounded-xl' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-xl'); ?> transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <?php if($index === 0): ?>
                            <div class="bg-yellow-100 p-1.5 rounded-full"><i class="fas fa-crown text-yellow-500 text-sm"></i></div>
                        <?php elseif($index === 1): ?>
                            <div class="bg-gray-100 dark:bg-gray-700 p-1.5 rounded-full"><i class="fas fa-medal text-gray-400 text-sm"></i></div>
                        <?php elseif($index === 2): ?>
                            <div class="bg-amber-100 p-1.5 rounded-full"><i class="fas fa-medal text-amber-600 text-sm"></i></div>
                        <?php endif; ?>
                        <span class="font-medium text-gray-800 dark:text-gray-200"><?php echo e($tutor->name); ?></span>
                    </div>
                    <span class="text-sm bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-medium"><?php echo e($tutor->citas_completadas); ?> sesiones</span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No hay tutores registrados</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-8">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-chart-line mr-2 text-indigo-600"></i>Citas por Mes (<?php echo e(now()->year); ?>)
        </h2>
        <canvas id="citasMesChart" height="220"></canvas>
    </div>
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-9">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-calendar-week mr-2 text-purple-600"></i>Citas Últimos 14 Días
        </h2>
        <canvas id="citasDiaChart" height="220"></canvas>
    </div>
</div>

<div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-10">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
        <i class="fas fa-clock mr-2 text-blue-600"></i>Citas Recientes
    </h2>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                    <th class="pb-3 font-medium">Estudiante</th>
                    <th class="pb-3 font-medium">Tutor</th>
                    <th class="pb-3 font-medium">Materia</th>
                    <th class="pb-3 font-medium">Fecha</th>
                    <th class="pb-3 font-medium">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $citasRecientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors table-row-glow animate-fade-in stagger-<?php echo e(min($loop->index + 1, 10)); ?>">
                        <td class="py-3 text-gray-800 dark:text-gray-200"><?php echo e($cita->student->name ?? 'N/A'); ?></td>
                        <td class="py-3 text-gray-800 dark:text-gray-200"><?php echo e($cita->tutor->name ?? 'N/A'); ?></td>
                        <td class="py-3 text-gray-600 dark:text-gray-400"><?php echo e($cita->subject->nombre ?? 'N/A'); ?></td>
                        <td class="py-3 text-gray-600 dark:text-gray-400"><?php echo e($cita->fecha->format('d/m/Y')); ?></td>
                        <td class="py-3">
                            <span class="px-2 py-0.5 text-xs rounded-full font-medium
                                <?php if($cita->estado === 'pendiente'): ?> bg-yellow-100 text-yellow-800 badge-pulse
                                <?php elseif($cita->estado === 'confirmada'): ?> bg-blue-100 text-blue-800
                                <?php elseif($cita->estado === 'completada'): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                <?php echo e(ucfirst($cita->estado)); ?>

                            </span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">No hay citas registradas</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#cbd5e1' : '#64748b';
    const gridColor = isDark ? '#334155' : '#e2e8f0';

    new Chart(document.getElementById('usuariosChart'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode(array_column($usuariosPorRol, 'label')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($usuariosPorRol, 'value')); ?>,
                backgroundColor: <?php echo json_encode(array_column($usuariosPorRol, 'color')); ?>,
                borderWidth: 0,
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { color: textColor } } } }
    });

    new Chart(document.getElementById('citasChart'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode(array_column($estadosCitas, 'label')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($estadosCitas, 'value')); ?>,
                backgroundColor: <?php echo json_encode(array_column($estadosCitas, 'color')); ?>,
                borderWidth: 0,
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { color: textColor } } } }
    });

    new Chart(document.getElementById('citasMesChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($citasPorMes->map(fn($i) => $meses[$i->mes - 1])); ?>,
            datasets: [{
                label: 'Citas',
                data: <?php echo json_encode($citasPorMes->pluck('total')); ?>,
                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                borderColor: '#6366f1',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { color: textColor } }, x: { ticks: { color: textColor } } } }
    });

    new Chart(document.getElementById('citasDiaChart'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($citasPorDia->pluck('dia')); ?>,
            datasets: [{
                label: 'Citas',
                data: <?php echo json_encode($citasPorDia->pluck('total')); ?>,
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#8b5cf6',
                pointRadius: 4,
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { color: textColor } }, x: { ticks: { color: textColor } } } }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alejandro/home/tutorias/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>