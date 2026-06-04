<?php $__env->startSection('title', 'Usuarios'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            <i class="fas fa-users mr-2 text-indigo-600"></i>Usuarios
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Gestión de usuarios del sistema</p>
    </div>
    <a href="<?php echo e(route('admin.usuarios.create')); ?>" class="btn-ripple inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
        <i class="fas fa-plus mr-2"></i>Nuevo Usuario
    </a>
</div>

<div class="card-hover glass-card rounded-xl shadow-md mb-6">
    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
        <form method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Buscar por nombre o email..."
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            </div>
            <div>
                <select name="role" class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">Todos los roles</option>
                    <option value="admin" <?php echo e(request('role') === 'admin' ? 'selected' : ''); ?>>Admin</option>
                    <option value="tutor" <?php echo e(request('role') === 'tutor' ? 'selected' : ''); ?>>Tutor</option>
                    <option value="estudiante" <?php echo e(request('role') === 'estudiante' ? 'selected' : ''); ?>>Estudiante</option>
                </select>
            </div>
<button type="submit" class="btn-ripple px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
    <i class="fas fa-search mr-1"></i>Filtrar
</button>
        </form>
    </div>
</div>

<div class="card-hover glass-card rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-gray-50 dark:from-gray-800/50 to-indigo-50 dark:to-indigo-900/20">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider"></th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Registro</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition-colors duration-150 table-row-glow animate-fade-in stagger-<?php echo e(min($loop->index + 1, 10)); ?>">
                        <td class="px-6 py-4">
                            <?php if($usuario->foto_perfil): ?>
                                <img src="<?php echo e($usuario->foto_url); ?>" alt="" class="w-8 h-8 rounded-full object-cover ring-2 ring-indigo-100 dark:ring-indigo-900/50">
                            <?php else: ?>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 flex items-center justify-center">
                                    <i class="fas fa-user text-xs text-indigo-500 dark:text-indigo-400"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4"><div class="font-medium text-gray-900 dark:text-gray-100"><?php echo e($usuario->name); ?></div></td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400"><?php echo e($usuario->email); ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium
                                <?php if($usuario->role === 'admin'): ?> bg-red-100 text-red-800
                                <?php elseif($usuario->role === 'tutor'): ?> bg-blue-100 text-blue-800
                                <?php else: ?> bg-green-100 text-green-800 <?php endif; ?>">
                                <?php echo e(ucfirst($usuario->role)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?php if($usuario->activo): ?>
                                <span class="text-green-600 flex items-center"><i class="fas fa-check-circle mr-1.5"></i> Activo</span>
                            <?php else: ?>
                                <span class="text-red-600 flex items-center"><i class="fas fa-times-circle mr-1.5"></i> Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400"><?php echo e($usuario->created_at->format('d/m/Y')); ?></td>
                        <td class="px-6 py-4 text-right">
                            <a href="<?php echo e(route('admin.usuarios.show', $usuario)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3 hover:scale-110 inline-block transition-transform" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('admin.usuarios.edit', $usuario)); ?>" class="text-yellow-600 hover:text-yellow-900 mr-3 hover:scale-110 inline-block transition-transform" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if($usuario->id !== auth()->id()): ?>
                                <form method="POST" action="<?php echo e(route('admin.usuarios.destroy', $usuario)); ?>" class="inline" onsubmit="return confirm('¿Eliminar este usuario?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-ripple text-red-600 hover:text-red-900 hover:scale-110 inline-block transition-transform" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php if($usuarios->isEmpty()): ?>
        <div class="text-center py-12 text-gray-500 dark:text-gray-400"><i class="fas fa-users text-4xl text-gray-300 dark:text-gray-500 mb-3"></i><p>No se encontraron usuarios</p></div>
    <?php endif; ?>
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30">
        <?php echo e($usuarios->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alejandro/home/tutorias/resources/views/admin/usuarios/index.blade.php ENDPATH**/ ?>