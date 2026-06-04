@extends('layouts.app')

@section('title', 'Registro de Actividad')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-history mr-2 text-indigo-600"></i>Registro de Actividad
    </h1>
</div>

<div class="card-hover glass-card rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-gray-50 dark:from-gray-800/50 to-indigo-50 dark:to-indigo-900/20">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Acción</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">IP</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Fecha</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($logs as $log)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors table-row-glow animate-fade-in stagger-{{ min($loop->index + 1, 10) }}">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $log->user->name ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $log->user->email ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 text-xs rounded-full font-medium
                                @if($log->action === 'creación') bg-green-100 text-green-800
                                @elseif($log->action === 'actualización') bg-blue-100 text-blue-800
                                @elseif($log->action === 'eliminación') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $log->description }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 font-mono">{{ $log->ip_address ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($logs->isEmpty())
        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
            <i class="fas fa-history text-4xl text-gray-300 dark:text-gray-500 mb-3"></i>
            <p>No hay actividad registrada</p>
        </div>
    @endif
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30">{{ $logs->links() }}</div>
</div>
@endsection
