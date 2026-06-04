@extends('layouts.app')

@section('title', 'Mensajes')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-comments mr-2 text-indigo-600"></i>Mensajes
    </h1>
    <p class="text-gray-600 dark:text-gray-400">Conversaciones con tutores y estudiantes</p>
</div>

<div class="card-hover glass-card rounded-xl shadow-md overflow-hidden">
    @if($conversations->isNotEmpty())
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($conversations as $conv)
                <a href="{{ route('chat.show', $conv) }}"
                    class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 animate-fade-in stagger-{{ min($loop->index + 1, 10) }}">
                    <div class="relative flex-shrink-0">
                        @if($conv->other->foto_perfil)
                            <img src="{{ $conv->other->foto_url }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 flex items-center justify-center">
                                <i class="fas fa-user text-indigo-500 text-xl"></i>
                            </div>
                        @endif
                        @if($conv->unread > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1">{{ $conv->unread }}</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $conv->other->name }}</h3>
                            <span class="text-xs text-gray-400 flex-shrink-0 ml-2">{{ $conv->last_message_at?->diffForHumans() ?? '' }}</span>
                        </div>
                        @if($conv->lastMessage)
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate mt-0.5">
                                @if($conv->lastMessage->sender_id === auth()->id())
                                    <span class="text-gray-400">Tú: </span>
                                @endif
                                {{ $conv->lastMessage->message }}
                            </p>
                        @else
                            <p class="text-sm text-gray-400 mt-0.5">Sin mensajes aún</p>
                        @endif
                    </div>
                    <i class="fas fa-chevron-right text-gray-300 dark:text-gray-600 text-sm flex-shrink-0"></i>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
            <i class="fas fa-comments text-4xl text-gray-300 dark:text-gray-500 mb-3"></i>
            <p>No tienes conversaciones aún</p>
            @if(auth()->user()->role === 'estudiante')
                <a href="{{ route('estudiante.buscar') }}" class="btn-ripple inline-block mt-3 px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all">
                    <i class="fas fa-search mr-1"></i> Buscar Tutores
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
