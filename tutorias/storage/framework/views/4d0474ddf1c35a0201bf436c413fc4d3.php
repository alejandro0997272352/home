<?php $__env->startSection('title', 'Crear Usuario'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-user-plus mr-2 text-indigo-600"></i>Crear Usuario
    </h1>
</div>

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 max-w-lg">
    <form method="POST" action="<?php echo e(route('admin.usuarios.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="<?php echo e(old('telefono')); ?>"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rol</label>
                <select name="role" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="estudiante" <?php echo e(old('role') === 'estudiante' ? 'selected' : ''); ?>>Estudiante</option>
                    <option value="tutor" <?php echo e(old('role') === 'tutor' ? 'selected' : ''); ?>>Tutor</option>
                    <option value="admin" <?php echo e(old('role') === 'admin' ? 'selected' : ''); ?>>Administrador</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div id="passwordRequirements" class="mt-3 space-y-1.5 text-sm">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">La contraseña debe contener:</p>
                    <div class="password-check invalid flex items-center" data-req="min"><i class="fas fa-circle mr-2 text-[8px]"></i> <span>Al menos 8 caracteres</span></div>
                    <div class="password-check invalid flex items-center" data-req="upper"><i class="fas fa-circle mr-2 text-[8px]"></i> <span>Una mayúscula (A-Z)</span></div>
                    <div class="password-check invalid flex items-center" data-req="lower"><i class="fas fa-circle mr-2 text-[8px]"></i> <span>Una minúscula (a-z)</span></div>
                    <div class="password-check invalid flex items-center" data-req="number"><i class="fas fa-circle mr-2 text-[8px]"></i> <span>Un número (0-9)</span></div>
                    <div class="password-check invalid flex items-center" data-req="special"><i class="fas fa-circle mr-2 text-[8px]"></i> <span>Un carácter especial (@$!%*#?&._-)</span></div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password-confirm" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                <div id="matchIndicator" class="mt-1 text-sm hidden"></div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t dark:border-t-gray-700">
            <a href="<?php echo e(route('admin.usuarios.index')); ?>" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">Cancelar</a>
            <button type="submit" class="btn-ripple px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md">
                <i class="fas fa-save mr-1"></i> Guardar
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const password = document.getElementById('password');
    const confirm = document.getElementById('password-confirm');
    const matchIndicator = document.getElementById('matchIndicator');

    function checkPasswordStrength() {
        const val = password.value;
        const checks = { min: val.length >= 8, upper: /[A-Z]/.test(val), lower: /[a-z]/.test(val), number: /[\d]/.test(val), special: /[@$!%*#?&._-]/.test(val) };
        document.querySelectorAll('.password-check').forEach(el => {
            const isValid = checks[el.dataset.req];
            el.className = `password-check flex items-center text-sm transition-all duration-300 ${isValid ? 'valid' : 'invalid'}`;
            el.innerHTML = isValid
                ? '<i class="fas fa-check-circle mr-2 text-green-500"></i> <span>' + el.querySelector('span').textContent + '</span>'
                : '<i class="fas fa-circle mr-2 text-[8px]"></i> <span>' + el.querySelector('span').textContent + '</span>';
        });
    }
    function checkMatch() {
        if (confirm.value.length === 0) { matchIndicator.className = 'mt-1 text-sm hidden'; return; }
        matchIndicator.className = 'mt-1 text-sm flex items-center';
        matchIndicator.innerHTML = password.value === confirm.value
            ? '<i class="fas fa-check-circle mr-1 text-green-500"></i> <span class="text-green-600">Coinciden</span>'
            : '<i class="fas fa-times-circle mr-1 text-red-500"></i> <span class="text-red-600">No coinciden</span>';
    }
    password.addEventListener('input', function () { checkPasswordStrength(); checkMatch(); });
    confirm.addEventListener('input', checkMatch);
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alejandro/home/tutorias/resources/views/admin/usuarios/create.blade.php ENDPATH**/ ?>