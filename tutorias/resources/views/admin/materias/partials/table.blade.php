<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gradient-to-r from-gray-50 dark:from-gray-800/50 to-indigo-50 dark:to-indigo-900/20">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Código</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Área</th>
                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Créditos</th>
                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Estado</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($materias as $i => $materia)
                <tr class="hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition-colors duration-150 table-row-glow animate-fade-in stagger-{{ min($loop->index + 1, 10) }}">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $materia->codigo ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $materia->nombre }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $materia->area ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm text-center">
                        <span class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 px-2.5 py-1 rounded-full text-xs font-medium">{{ $materia->creditos ?? '—' }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($materia->activo)
                            <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                        @else
                            <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.materias.edit', $materia) }}" class="text-yellow-600 hover:text-yellow-900 mr-3 hover:scale-110 inline-block transition-transform">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.materias.destroy', $materia) }}" class="inline" onsubmit="return confirm('¿Eliminar esta materia?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-ripple text-red-600 hover:text-red-900 hover:scale-110 inline-block transition-transform" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if($materias->isEmpty())
    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
        <i class="fas fa-book text-4xl text-gray-300 dark:text-gray-500 mb-3"></i>
        <p>No se encontraron materias</p>
    </div>
@endif
<div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30">
    {{ $materias->links() }}
</div>
