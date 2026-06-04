<?php $__env->startSection('title', 'Mi Perfil'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-user-circle mr-2 text-indigo-600"></i>Mi Perfil
    </h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <div class="text-center">
                <div class="relative inline-block">
                    <?php if($user->foto_perfil): ?>
                        <img src="<?php echo e(asset('storage/' . $user->foto_perfil)); ?>" alt="Foto" class="w-28 h-28 rounded-full object-cover mx-auto border-4 border-indigo-100 dark:border-indigo-900/50 shadow-md">
                    <?php else: ?>
                        <div class="w-28 h-28 rounded-full mx-auto bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 flex items-center justify-center border-4 border-indigo-100 dark:border-indigo-900/50 shadow-md">
                            <i class="fas fa-user text-4xl text-indigo-500 dark:text-indigo-400"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mt-4"><?php echo e($user->name); ?></h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm"><?php echo e($user->email); ?></p>
                <span class="inline-block mt-2 px-3 py-1 text-xs rounded-full font-medium
                    <?php if($user->role === 'admin'): ?> bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300
                    <?php elseif($user->role === 'tutor'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300
                    <?php else: ?> bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 <?php endif; ?>">
                    <?php echo e(ucfirst($user->role)); ?>

                </span>
                <?php if($user->telefono): ?>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-3"><i class="fas fa-phone mr-1"></i><?php echo e($user->telefono); ?></p>
                <?php endif; ?>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Miembro desde <?php echo e($user->created_at->format('M Y')); ?></p>
            </div>

            <?php if($user->isTutor() && $user->tutorProfile): ?>
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                        <i class="fas fa-chart-simple mr-2 text-blue-500"></i>Estadísticas
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-3 text-center">
                            <p class="text-2xl font-bold text-blue-600"><?php echo e($user->tutorProfile->total_sesiones); ?></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Sesiones</p>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-3 text-center">
                            <p class="text-2xl font-bold text-yellow-600"><?php echo e(number_format($user->tutorProfile->calificacion_promedio, 1)); ?></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Calificación</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                <i class="fas fa-lock mr-2 text-red-500"></i>Cambiar Contraseña
            </h3>
            <form method="POST" action="<?php echo e(route('perfil.password')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña Actual *</label>
                    <input type="password" name="current_password" required
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 transition-all">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nueva Contraseña *</label>
                    <input type="password" name="password" id="pw" required
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 transition-all">
                    <div id="pwReqs" class="mt-2 space-y-1 text-sm hidden">
                        <p class="text-xs text-gray-500 dark:text-gray-400">La contraseña debe contener:</p>
                        <div class="password-check invalid flex items-center text-xs" data-req="min"><i class="fas fa-circle mr-1.5 text-[6px]"></i> 8+ caracteres</div>
                        <div class="password-check invalid flex items-center text-xs" data-req="upper"><i class="fas fa-circle mr-1.5 text-[6px]"></i> Mayúscula</div>
                        <div class="password-check invalid flex items-center text-xs" data-req="lower"><i class="fas fa-circle mr-1.5 text-[6px]"></i> Minúscula</div>
                        <div class="password-check invalid flex items-center text-xs" data-req="number"><i class="fas fa-circle mr-1.5 text-[6px]"></i> Número</div>
                        <div class="password-check invalid flex items-center text-xs" data-req="special"><i class="fas fa-circle mr-1.5 text-[6px]"></i> Carácter especial</div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Contraseña *</label>
                    <input type="password" name="password_confirmation" id="pwConfirm" required
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 transition-all">
                    <div id="pwMatch" class="mt-1 text-sm hidden"></div>
                </div>
                <button type="submit" class="btn-ripple w-full bg-gradient-to-r from-red-600 to-rose-600 text-white py-2.5 rounded-xl hover:from-red-700 hover:to-rose-700 transition-all shadow-md">
                    <i class="fas fa-save mr-1"></i> Actualizar Contraseña
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                <i class="fas fa-edit mr-2 text-indigo-500"></i>Editar Información
            </h2>
            <form method="POST" action="<?php echo e(route('perfil')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre *</label>
                        <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                        <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono</label>
                        <input type="text" name="telefono" value="<?php echo e(old('telefono', $user->telefono)); ?>"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto de Perfil</label>
                        <input type="file" name="foto_perfil" accept="image/*"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100">
                        <?php $__errorArgs = ['foto_perfil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <?php if($user->isTutor()): ?>
                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                            <i class="fas fa-chalkboard-teacher mr-2 text-blue-500"></i>Perfil de Tutor
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Biografía</label>
                                <textarea name="biografia" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all"><?php echo e(old('biografia', $user->tutorProfile->biografia ?? '')); ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Formación Académica</label>
                                <input type="text" name="formacion_academica" value="<?php echo e(old('formacion_academica', $user->tutorProfile->formacion_academica ?? '')); ?>"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tarifa por Hora ($)</label>
                                <input type="number" name="tarifa_por_hora" step="0.01" min="0" value="<?php echo e(old('tarifa_por_hora', $user->tutorProfile->tarifa_por_hora ?? 0)); ?>"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="flex justify-end mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <button type="submit" class="btn-ripple px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md">
                        <i class="fas fa-save mr-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        <?php if($user->isTutor() && $user->subjects->isNotEmpty()): ?>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 mt-6">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                    <i class="fas fa-book mr-2 text-indigo-500"></i>Mis Materias
                </h3>
                <div class="flex flex-wrap gap-2">
                    <?php $__currentLoopData = $user->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="px-3 py-1.5 bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 text-indigo-800 dark:text-indigo-200 rounded-full text-sm font-medium"><?php echo e($subject->nombre); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pw = document.getElementById('pw');
    const conf = document.getElementById('pwConfirm');
    const reqs = document.getElementById('pwReqs');
    const match = document.getElementById('pwMatch');

    function check() {
        const v = pw.value;
        reqs.classList.toggle('hidden', v.length === 0);
        const checks = { min: v.length >= 8, upper: /[A-Z]/.test(v), lower: /[a-z]/.test(v), number: /\d/.test(v), special: /[@$!%*#?&._-]/.test(v) };
        document.querySelectorAll('.password-check').forEach(el => {
            const ok = checks[el.dataset.req];
            el.className = `password-check flex items-center text-xs transition-all duration-300 ${ok ? 'valid' : 'invalid'}`;
            el.innerHTML = ok
                ? '<i class="fas fa-check-circle mr-1.5 text-green-500"></i> ' + el.textContent.trim().replace(/^.*?\s/, '')
                : '<i class="fas fa-circle mr-1.5 text-[6px]"></i> ' + el.textContent.trim().replace(/^.*?\s/, '');
        });
        if (conf.value.length === 0) { match.className = 'mt-1 text-sm hidden'; return; }
        match.className = 'mt-1 text-sm flex items-center';
        match.innerHTML = pw.value === conf.value
            ? '<i class="fas fa-check-circle mr-1 text-green-500"></i> <span class="text-green-600">Coinciden</span>'
            : '<i class="fas fa-times-circle mr-1 text-red-500"></i> <span class="text-red-600">No coinciden</span>';
    }
    pw.addEventListener('input', check);
    conf.addEventListener('input', check);
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alejandro/home/tutorias/resources/views/perfil/index.blade.php ENDPATH**/ ?>