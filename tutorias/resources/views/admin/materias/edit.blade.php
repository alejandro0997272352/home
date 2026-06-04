@extends('layouts.app')

@section('title', 'Editar Materia')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-book-edit mr-2 text-indigo-600"></i>Editar Materia: {{ $materia->nombre }}
    </h1>
</div>
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 max-w-lg">
    <form method="POST" action="{{ route('admin.materias.update', $materia) }}">
        @csrf @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre *</label>
                <input type="text" name="nombre" value="{{ old('nombre', $materia->nombre) }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código</label>
                <input type="text" name="codigo" value="{{ old('codigo', $materia->codigo) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Área</label>
                <input type="text" name="area" value="{{ old('area', $materia->area) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Créditos</label>
                <input type="number" name="creditos" value="{{ old('creditos', $materia->creditos) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                <textarea name="descripcion" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">{{ old('descripcion', $materia->descripcion) }}</textarea>
            </div>
            <div>
                <label class="flex items-center cursor-pointer group">
                    <input type="checkbox" name="activo" value="1" {{ old('activo', $materia->activo) ? 'checked' : '' }}
                        class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 group-hover:border-indigo-400 transition-colors">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 group-hover:text-gray-900 transition-colors">Materia activa</span>
                </label>
            </div>
        </div>
        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t dark:border-t-gray-700">
            <a href="{{ route('admin.materias.index') }}" class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">Cancelar</a>
            <button type="submit" class="btn-ripple px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md">
                <i class="fas fa-save mr-1"></i> Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
