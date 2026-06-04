@extends('layouts.app')

@section('title', 'Explorar Base de Datos')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-database mr-2 text-indigo-600"></i>Base de Datos
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Tablas con registros</p>
</div>

<div x-data="{ tabla: null }">
    <div class="flex flex-wrap gap-2 mb-6">
        @foreach($data as $tableName => $rows)
            <button @click="tabla = tabla === '{{ $tableName }}' ? null : '{{ $tableName }}'"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-all"
                :class="tabla === '{{ $tableName }}' ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 shadow-sm'">
                <i class="fas fa-table mr-1"></i>{{ $tableName }}
                <span class="ml-1 text-xs opacity-60">({{ $rows->count() }})</span>
            </button>
        @endforeach
    </div>

    @foreach($data as $tableName => $rows)
        <div x-show="tabla === '{{ $tableName }}'" x-transition:enter.duration.300ms class="mb-6">
            <div class="card-hover bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 text-left text-gray-500 dark:text-gray-400">
                                @foreach((array) $rows->first() as $col => $val)
                                    <th class="px-4 py-3 font-medium whitespace-nowrap">{{ $col }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                                <tr class="border-t border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    @foreach((array) $row as $val)
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200 max-w-xs truncate" title="{{ $val }}">
                                            @if(is_null($val))
                                                <span class="text-gray-400 italic">NULL</span>
                                            @else
                                                {{ $val }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
