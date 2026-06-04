<?php $__env->startSection('title', 'Panel del Estudiante'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
        <i class="fas fa-user-graduate mr-2 text-green-600"></i>Panel del Estudiante
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Bienvenido, <?php echo e(auth()->user()->name); ?></p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <?php
        $cards = [
            ['label' => 'Total Citas', 'value' => $totalCitas, 'color' => 'gray', 'icon' => 'fa-calendar'],
            ['label' => 'Completadas', 'value' => $citasCompletadas, 'color' => 'green', 'icon' => 'fa-check-circle'],
            ['label' => 'Pendientes', 'value' => $citasPendientes, 'color' => 'orange', 'icon' => 'fa-clock'],
            ['label' => 'Canceladas', 'value' => $citasCanceladas, 'color' => 'red', 'icon' => 'fa-times-circle'],
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

<div class="card-hover glass-card rounded-xl shadow-md p-6 animate-slide-up stagger-5">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
        <i class="fas fa-clock mr-2 text-green-600"></i>Próximas Citas
    </h2>
    <?php if($proximasCitas->isNotEmpty()): ?>
        <div class="space-y-3">
            <?php $__currentLoopData = $proximasCitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border border-gray-100 dark:border-gray-700 rounded-xl p-4 hover:bg-green-50/50 dark:hover:bg-green-900/20 transition-all duration-200 hover:shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($cita->tutor->name); ?></p>
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
        <div class="text-center py-12">
            <i class="fas fa-calendar-plus text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <p class="text-gray-500 dark:text-gray-400 text-lg">No tienes citas próximas</p>
            <a href="<?php echo e(route('estudiante.buscar')); ?>" class="btn-ripple inline-block mt-3 px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all shadow-md hover:shadow-lg">
                <i class="fas fa-search mr-1"></i> Buscar Tutores
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alejandro/home/tutorias/resources/views/estudiante/dashboard.blade.php ENDPATH**/ ?>