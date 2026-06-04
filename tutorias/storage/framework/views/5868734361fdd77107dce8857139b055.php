<?php $__env->startSection('title', 'Panel del Tutor'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
        <i class="fas fa-chalkboard-teacher mr-2 text-blue-600"></i>Panel del Tutor
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Bienvenido, <?php echo e(auth()->user()->name); ?></p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <?php
        $cards = [
            ['label' => 'Total Citas', 'value' => $totalCitas, 'color' => 'blue', 'icon' => 'fa-calendar'],
            ['label' => 'Completadas', 'value' => $citasCompletadas, 'color' => 'green', 'icon' => 'fa-check-circle'],
            ['label' => 'Pendientes', 'value' => $citasPendientes, 'color' => 'orange', 'icon' => 'fa-clock'],
            ['label' => 'Hoy', 'value' => $citasHoy, 'color' => 'indigo', 'icon' => 'fa-calendar-day'],
        ];
    ?>
    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-<?php echo e(min($i + 1, 6)); ?>">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 font-medium"><?php echo e($card['label']); ?></p>
                    <p class="text-3xl font-bold text-<?php echo e($card['color']); ?>-600">
                        <span class="count-up" data-target="<?php echo e($card['value']); ?>">0</span>
                    </p>
                </div>
                <div class="bg-gradient-to-br from-<?php echo e($card['color']); ?>-100 to-<?php echo e($card['color']); ?>-200 p-3 rounded-xl">
                    <i class="fas <?php echo e($card['icon']); ?> text-2xl text-<?php echo e($card['color']); ?>-600"></i>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-5">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-clock mr-2 text-blue-600"></i>Próximas Citas
        </h2>
        <?php if($proximasCitas->isNotEmpty()): ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $proximasCitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-100 dark:border-gray-700 rounded-xl p-4 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 transition-all duration-200 hover:shadow-sm">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($cita->student->name); ?></p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5"><?php echo e($cita->subject->nombre); ?></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="far fa-calendar mr-1"></i><?php echo e($cita->fecha->format('d/m/Y')); ?>

                                    <i class="far fa-clock ml-3 mr-1"></i><?php echo e(substr($cita->hora_inicio, 0, 5)); ?> - <?php echo e(substr($cita->hora_fin, 0, 5)); ?>

                                </p>
                            </div>
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium
                                <?php if($cita->estado === 'pendiente'): ?> bg-yellow-100 text-yellow-800 badge-pulse
                                <?php else: ?> bg-blue-100 text-blue-800 <?php endif; ?>">
                                <?php echo e(ucfirst($cita->estado)); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-8 text-gray-500 dark:text-gray-400"><i class="fas fa-calendar-check text-4xl text-gray-300 dark:text-gray-500 mb-3"></i><p>No tienes citas próximas</p></div>
        <?php endif; ?>
    </div>

    <div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-book mr-2 text-blue-600"></i>Mis Materias
        </h2>
        <?php if($materias->isNotEmpty()): ?>
            <div class="flex flex-wrap gap-2">
                <?php $__currentLoopData = $materias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $materia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="px-3 py-1.5 bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 rounded-full text-sm font-medium"><?php echo e($materia->nombre); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 dark:text-gray-400 text-center py-8">No tienes materias asignadas</p>
        <?php endif; ?>
        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Citas del Mes</h3>
            <div class="space-y-2">
                <?php $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']; ?>
                <?php $__currentLoopData = $citasPorMes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between text-sm p-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-all">
                        <span class="text-gray-700 dark:text-gray-300"><?php echo e($meses[$item->mes - 1]); ?></span>
                        <span class="font-semibold text-blue-600"><?php echo e($item->total); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($citasPorMes->isEmpty()): ?>
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Sin datos</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alejandro/home/tutorias/resources/views/tutor/dashboard.blade.php ENDPATH**/ ?>