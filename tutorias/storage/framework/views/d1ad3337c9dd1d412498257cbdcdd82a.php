<?php $__env->startSection('title', 'Detalle del Usuario'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            <i class="fas fa-user mr-2 text-indigo-600"></i><?php echo e($user->name); ?>

        </h1>
    </div>
    <div class="flex gap-3">
        <a href="<?php echo e(route('admin.usuarios.edit', $user)); ?>" class="btn-ripple px-4 py-2 bg-gradient-to-r from-yellow-500 to-amber-500 text-white rounded-xl hover:from-yellow-600 hover:to-amber-600 transition-all shadow-md text-sm">
            <i class="fas fa-edit mr-1"></i> Editar
        </a>
        <a href="<?php echo e(route('admin.usuarios.index')); ?>" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-info-circle mr-2 text-indigo-600"></i>Información General
        </h2>
        <div class="flex justify-center mb-6">
            <?php if($user->foto_perfil): ?>
                <img src="<?php echo e($user->foto_url); ?>" alt="Foto" class="w-24 h-24 rounded-full object-cover ring-4 ring-indigo-100 dark:ring-indigo-900/50 shadow-md">
            <?php else: ?>
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 flex items-center justify-center ring-4 ring-indigo-100 dark:ring-indigo-900/50 shadow-md">
                    <i class="fas fa-user text-3xl text-indigo-500 dark:text-indigo-400"></i>
                </div>
            <?php endif; ?>
        </div>
        <dl class="space-y-4">
            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                <dt class="text-sm text-gray-600 dark:text-gray-400 font-medium">Nombre:</dt>
                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100"><?php echo e($user->name); ?></dd>
            </div>
            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                <dt class="text-sm text-gray-600 dark:text-gray-400 font-medium">Email:</dt>
                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100"><?php echo e($user->email); ?></dd>
            </div>
            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                <dt class="text-sm text-gray-600 dark:text-gray-400 font-medium">Teléfono:</dt>
                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100"><?php echo e($user->telefono ?? 'No registrado'); ?></dd>
            </div>
            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                <dt class="text-sm text-gray-600 dark:text-gray-400 font-medium">Rol:</dt>
                <dd>
                    <span class="px-2.5 py-1 text-xs rounded-full font-medium
                        <?php if($user->role === 'admin'): ?> bg-red-100 text-red-800
                        <?php elseif($user->role === 'tutor'): ?> bg-blue-100 text-blue-800
                        <?php else: ?> bg-green-100 text-green-800 <?php endif; ?>">
                        <?php echo e(ucfirst($user->role)); ?>

                    </span>
                </dd>
            </div>
            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                <dt class="text-sm text-gray-600 dark:text-gray-400 font-medium">Estado:</dt>
                <dd>
                    <?php if($user->activo): ?>
                        <span class="text-green-600 flex items-center"><i class="fas fa-check-circle mr-1.5"></i> Activo</span>
                    <?php else: ?>
                        <span class="text-red-600 flex items-center"><i class="fas fa-times-circle mr-1.5"></i> Inactivo</span>
                    <?php endif; ?>
                </dd>
            </div>
            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                <dt class="text-sm text-gray-600 dark:text-gray-400 font-medium">Registrado:</dt>
                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100"><?php echo e($user->created_at->format('d/m/Y H:i')); ?></dd>
            </div>
        </dl>
    </div>

    <?php if($user->isTutor()): ?>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                <i class="fas fa-chalkboard-teacher mr-2 text-blue-600"></i>Perfil de Tutor
            </h2>
            <?php if($user->tutorProfile): ?>
                <dl class="space-y-4">
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                        <dt class="text-sm text-gray-600 dark:text-gray-400 font-medium mb-1">Biografía:</dt>
                        <dd class="text-sm text-gray-800 dark:text-gray-200"><?php echo e($user->tutorProfile->biografia ?? 'Sin biografía'); ?></dd>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                        <dt class="text-sm text-gray-600 dark:text-gray-400 font-medium">Formación:</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100"><?php echo e($user->tutorProfile->formacion_academica ?? 'No especificada'); ?></dd>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                        <dt class="text-sm text-gray-600 dark:text-gray-400 font-medium">Calificación:</dt>
                        <dd class="text-sm font-semibold text-yellow-600">⭐ <?php echo e(number_format($user->tutorProfile->calificacion_promedio, 1)); ?> / 5.0</dd>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                        <dt class="text-sm text-gray-600 dark:text-gray-400 font-medium">Sesiones:</dt>
                        <dd class="text-sm font-semibold text-blue-600"><?php echo e($user->tutorProfile->total_sesiones); ?></dd>
                    </div>
                </dl>
            <?php else: ?>
                <p class="text-gray-500 dark:text-gray-400 text-center py-8">Perfil no completado</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php if($user->isTutor()): ?>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 mt-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-book mr-2 text-indigo-600"></i>Materias que Imparte
        </h2>
        <?php if($user->subjects->isNotEmpty()): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <?php $__currentLoopData = $user->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-indigo-100 dark:border-indigo-900/50 rounded-xl p-4 bg-gradient-to-br from-indigo-50 dark:from-indigo-900/20 to-white hover:shadow-md transition-all duration-200">
                        <p class="font-medium text-gray-800 dark:text-gray-200"><?php echo e($subject->nombre); ?></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($subject->codigo ?? 'Sin código'); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 dark:text-gray-400 text-center py-6">No tiene materias asignadas</p>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alejandro/home/tutorias/resources/views/admin/usuarios/show.blade.php ENDPATH**/ ?>