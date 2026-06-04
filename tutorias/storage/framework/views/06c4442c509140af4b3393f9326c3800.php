<?php $__env->startSection('title', 'Explorar Base de Datos'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-database mr-2 text-indigo-600"></i>Base de Datos
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Tablas con registros</p>
</div>

<div x-data="{ tabla: null }">
    <div class="flex flex-wrap gap-2 mb-6">
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tableName => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button @click="tabla = tabla === '<?php echo e($tableName); ?>' ? null : '<?php echo e($tableName); ?>'"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-all"
                :class="tabla === '<?php echo e($tableName); ?>' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 shadow-sm'">
                <i class="fas fa-table mr-1"></i><?php echo e($tableName); ?>

                <span class="ml-1 text-xs opacity-60">(<?php echo e($rows->count()); ?>)</span>
            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tableName => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div x-show="tabla === '<?php echo e($tableName); ?>'" x-transition:enter.duration.300ms class="mb-6">
            <div class="card-hover bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 text-left text-gray-500 dark:text-gray-400">
                                <?php $__currentLoopData = (array) $rows->first(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="px-4 py-3 font-medium whitespace-nowrap"><?php echo e($col); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-t border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <?php $__currentLoopData = (array) $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200 max-w-xs truncate" title="<?php echo e($val); ?>">
                                            <?php if(is_null($val)): ?>
                                                <span class="text-gray-400 italic">NULL</span>
                                            <?php else: ?>
                                                <?php echo e($val); ?>

                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alejandro/home/tutorias/resources/views/db-viewer.blade.php ENDPATH**/ ?>