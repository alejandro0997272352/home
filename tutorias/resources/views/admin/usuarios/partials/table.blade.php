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
            @foreach($usuarios as $usuario)
                <tr class="hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition-colors duration-150 table-row-glow animate-fade-in stagger-{{ min($loop->index + 1, 10) }}">
                    <td class="px-6 py-4">
                        @if($usuario->foto_perfil)
                            <img src="{{ $usuario->foto_url }}" alt="" class="w-8 h-8 rounded-full object-cover ring-2 ring-indigo-100 dark:ring-indigo-900/50">
                        @else
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 flex items-center justify-center">
                                <i class="fas fa-user text-xs text-indigo-500 dark:text-indigo-400"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4"><div class="font-medium text-gray-900 dark:text-gray-100">{{ $usuario->name }}</div></td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $usuario->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs rounded-full font-medium
                            @if($usuario->role === 'admin') bg-red-100 text-red-800
                            @elseif($usuario->role === 'tutor') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($usuario->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($usuario->activo)
                            <span class="text-green-600 flex items-center"><i class="fas fa-check-circle mr-1.5"></i> Activo</span>
                        @else
                            <span class="text-red-600 flex items-center"><i class="fas fa-times-circle mr-1.5"></i> Inactivo</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $usuario->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.usuarios.show', $usuario) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 hover:scale-110 inline-block transition-transform" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="text-yellow-600 hover:text-yellow-900 mr-3 hover:scale-110 inline-block transition-transform" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($usuario->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.usuarios.destroy', $usuario) }}" class="inline" onsubmit="return confirm('¿Eliminar este usuario?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-ripple text-red-600 hover:text-red-900 hover:scale-110 inline-block transition-transform" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if($usuarios->isEmpty())
    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
        <i class="fas fa-users text-4xl text-gray-300 dark:text-gray-500 mb-3"></i>
        <p>No se encontraron usuarios</p>
    </div>
@endif
<div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30">
    {{ $usuarios->links() }}
</div>
