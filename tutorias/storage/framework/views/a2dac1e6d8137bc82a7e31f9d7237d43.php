<?php $__env->startSection('title', 'Crear Materia'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-book-plus mr-2 text-indigo-600"></i>Nueva Materia
    </h1>
</div>
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 max-w-lg">
    <form method="POST" action="<?php echo e(route('admin.materias.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre *</label>
                <input type="text" name="nombre" value="<?php echo e(old('nombre')); ?>" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código</label>
                <input type="text" name="codigo" value="<?php echo e(old('codigo')); ?>"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Área</label>
                <input type="text" name="area" value="<?php echo e(old('area')); ?>"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Créditos</label>
                <input type="number" name="creditos" value="<?php echo e(old('creditos')); ?>"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                <textarea name="descripcion" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all"><?php echo e(old('descripcion')); ?></textarea>
            </div>
        </div>
        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t dark:border-t-gray-700">
            <a href="<?php echo e(route('admin.materias.index')); ?>" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">Cancelar</a>
            <button type="submit" class="btn-ripple px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md">
                <i class="fas fa-save mr-1"></i> Guardar
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alejandro/home/tutorias/resources/views/admin/materias/create.blade.php ENDPATH**/ ?>