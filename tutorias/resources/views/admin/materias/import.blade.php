@extends('layouts.app')

@section('title', 'Importar Materias')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-file-import mr-2 text-indigo-600"></i>Importar Materias
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Carga masiva de materias desde archivo CSV o Excel</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-upload mr-2 text-indigo-500"></i>Subir Archivo
        </h2>
        <form method="POST" action="{{ route('admin.materias.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Archivo (CSV, XLSX, XLS) *</label>
                <input type="file" name="archivo" accept=".csv,.xlsx,.xls" required
                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 dark:file:bg-indigo-900/30 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100">
                @error('archivo') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn-ripple px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md">
                <i class="fas fa-upload mr-1"></i> Importar
            </button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-info-circle mr-2 text-blue-500"></i>Instrucciones
        </h2>
        <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
            <p>El archivo debe contener las siguientes columnas:</p>
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-3">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">
                            <th class="pb-1">Columna</th>
                            <th class="pb-1">Descripción</th>
                            <th class="pb-1">Requerido</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        <tr><td class="py-1 font-medium">nombre</td><td class="py-1">Nombre de la materia</td><td class="py-1 text-green-600">Sí</td></tr>
                        <tr><td class="py-1 font-medium">codigo</td><td class="py-1">Clave o código</td><td class="py-1 text-gray-400">No</td></tr>
                        <tr><td class="py-1 font-medium">area</td><td class="py-1">Área académica</td><td class="py-1 text-gray-400">No</td></tr>
                        <tr><td class="py-1 font-medium">creditos</td><td class="py-1">Número de créditos</td><td class="py-1 text-gray-400">No</td></tr>
                        <tr><td class="py-1 font-medium">descripcion</td><td class="py-1">Descripción breve</td><td class="py-1 text-gray-400">No</td></tr>
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500">Ejemplo CSV: <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">nombre,codigo,area,creditos,descripcion</code></p>
            <p class="text-xs text-gray-400 dark:text-gray-500">Máximo 2MB por archivo.</p>
        </div>
    </div>
</div>
@endsection
