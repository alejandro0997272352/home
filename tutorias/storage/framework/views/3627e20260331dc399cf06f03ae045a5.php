<?php $__env->startSection('title', 'Iniciar Sesión'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center py-12 px-4 relative overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center opacity-15 dark:opacity-10 blur-sm scale-110"
         style="background-image: url('<?php echo e(asset('images/logo.png')); ?>')"></div>
    <div class="glass-card rounded-2xl shadow-2xl p-8 w-full max-w-md relative animate-scale-in">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full mb-4 shadow-lg">
                <i class="fas fa-graduation-cap text-2xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Tutorías Académicas</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2 animate-fade-in">Inicia sesión para continuar</p>
        </div>

        <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>

            <div class="animate-slide-up stagger-1 input-group">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-200">
                    <i class="fas fa-envelope mr-1 text-indigo-500"></i> Correo Electrónico
                </label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="animate-slide-up stagger-2 input-group">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors duration-200">
                    <i class="fas fa-lock mr-1 text-indigo-500"></i> Contraseña
                </label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-2.5 pr-12 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-2 ring-red-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-indigo-600 transition-colors">
                        <i id="passwordToggleIcon" class="fas fa-eye"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-red-500 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex items-center justify-between animate-slide-up stagger-3">
                <label class="flex items-center cursor-pointer group">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 transition-colors group-hover:border-indigo-400" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 dark:text-gray-200 transition-colors">Recordarme</span>
                </label>
                <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium hover:underline transition-all">¿Olvidaste tu contraseña?</a>
            </div>

            <div class="animate-slide-up stagger-4">
                <button type="submit" class="btn-ripple w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2.5 px-4 rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 hover:shadow-xl hover:-translate-y-0.5">
                    <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                </button>
            </div>
        </form>

        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6 animate-fade-in">
            ¿No tienes cuenta?
            <a href="<?php echo e(route('register')); ?>" class="text-indigo-600 hover:text-indigo-800 font-medium hover:underline transition-all">Regístrate</a>
        </p>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('passwordToggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alejandro/home/tutorias/resources/views/auth/login.blade.php ENDPATH**/ ?>