<!DOCTYPE html>
<html lang="es" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tutorías Académicas') - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        .animate-fade-in { animation: fadeIn 0.5s ease-out both; }
        .animate-slide-up { animation: slideUp 0.5s ease-out both; }
        .animate-scale-in { animation: scaleIn 0.3s ease-out both; }
        .animate-shake { animation: shake 0.5s ease-in-out; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        @keyframes ripple { to { transform: scale(4); opacity: 0; } }
        @keyframes slideInRight { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeOutRight { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100px); } }
        @keyframes shake { 0%, 100% { transform: rotate(0); } 20% { transform: rotate(15deg); } 40% { transform: rotate(-10deg); } 60% { transform: rotate(8deg); } 80% { transform: rotate(-5deg); } }
        @keyframes skeleton-pulse { 0%, 100% { opacity: 0.4; } 50% { opacity: 0.8; } }
        @keyframes badge-pulse { 0%, 100% { box-shadow: 0 0 0 0 rgba(234,179,8,0.5); } 50% { box-shadow: 0 0 0 6px rgba(234,179,8,0); } }

        .stagger-1 { animation-delay: 0.05s; }
        .stagger-2 { animation-delay: 0.1s; }
        .stagger-3 { animation-delay: 0.15s; }
        .stagger-4 { animation-delay: 0.2s; }
        .stagger-5 { animation-delay: 0.25s; }
        .stagger-6 { animation-delay: 0.3s; }
        .stagger-7 { animation-delay: 0.35s; }
        .stagger-8 { animation-delay: 0.4s; }
        .stagger-9 { animation-delay: 0.45s; }
        .stagger-10 { animation-delay: 0.5s; }

        .btn-ripple { position: relative; overflow: hidden; }
        .btn-ripple::after { content: ''; position: absolute; inset: 0; border-radius: inherit; background: rgba(255,255,255,0.3); transform: scale(0); opacity: 0; pointer-events: none; }
        .btn-ripple:active::after { animation: ripple 0.6s ease-out; }

        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 12px 30px -10px rgba(79,70,229,0.2); }

        .nav-glass { background: rgba(255,255,255,0.9); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(229,231,235,0.5); }
        .dark .nav-glass { background: rgba(15,23,42,0.9); border-bottom: 1px solid rgba(55,65,81,0.5); }

        .toast { animation: slideInRight 0.4s ease-out; }
        .toast-exit { animation: fadeOutRight 0.3s ease-in forwards; }

        .skeleton { background: linear-gradient(90deg, #e5e7eb 25%, #f3f4f6 50%, #e5e7eb 75%); background-size: 200% 100%; animation: skeleton-pulse 1.5s ease-in-out infinite; border-radius: 0.375rem; }
        .dark .skeleton { background: linear-gradient(90deg, #334155 25%, #475569 50%, #334155 75%); background-size: 200% 100%; }

        .input-group { position: relative; }
        .input-group:focus-within label { color: #4f46e5; }
        .input-group input:focus { border-color: #4f46e5 !important; box-shadow: 0 0 0 3px rgba(79,70,229,0.15) !important; }

        .table-row-glow:hover { box-shadow: 0 0 15px rgba(99,102,241,0.15); position: relative; z-index: 1; }

        .back-to-top { opacity: 0; visibility: hidden; transition: all 0.3s ease; transform: translateY(20px); }
        .back-to-top.visible { opacity: 1; visibility: visible; transform: translateY(0); }

        .profile-photo { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .profile-photo:hover { transform: scale(1.15); box-shadow: 0 0 20px rgba(99,102,241,0.4); }

        .badge-pulse { animation: badge-pulse 2s ease-in-out infinite; }

        .glass-card { background: rgba(255,255,255,0.75); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.3); }
        .dark .glass-card { background: rgba(15,23,42,0.75); border: 1px solid rgba(55,65,81,0.3); }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }
    </style>
    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen transition-colors duration-200 animate-fade-in">

    @auth
        <nav class="nav-glass shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-9 rounded-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <span class="font-bold text-xl bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">Tutorías</span>
                        </a>
                        @php $role = auth()->user()->role; @endphp
                        <div class="ml-10 flex items-center space-x-1">
                            @if ($role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-chart-pie mr-1"></i>Dashboard
                                </a>
                                <a href="{{ route('admin.usuarios.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.usuarios.*') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-users mr-1"></i>Usuarios
                                </a>
                                <a href="{{ route('admin.materias.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.materias.*') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-book mr-1"></i>Materias
                                </a>
                                <a href="{{ route('admin.reportes') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.reportes') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-file-alt mr-1"></i>Reportes
                                </a>
                                <a href="{{ route('admin.actividad') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.actividad') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-history mr-1"></i>Actividad
                                </a>
                                <a href="{{ route('admin.db') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.db') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-database mr-1"></i>BD
                                </a>
                                <a href="{{ route('admin.reviews.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.reviews.*') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-star mr-1"></i>Reviews
                                </a>
                            @elseif ($role === 'tutor')
                                <a href="{{ route('tutor.dashboard') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('tutor.dashboard') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-chart-pie mr-1"></i>Dashboard
                                </a>
                                <a href="{{ route('tutor.disponibilidad') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('tutor.disponibilidad') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-clock mr-1"></i>Disponibilidad
                                </a>
                                <a href="{{ route('tutor.citas') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('tutor.citas') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-calendar-check mr-1"></i>Mis Citas
                                </a>
                                <a href="{{ route('chat.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('chat.*') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-comments mr-1"></i>Mensajes
                                </a>
                            @else
                                <a href="{{ route('estudiante.dashboard') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('estudiante.dashboard') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-chart-pie mr-1"></i>Dashboard
                                </a>
                                <a href="{{ route('estudiante.buscar') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('estudiante.buscar') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-search mr-1"></i>Buscar Tutores
                                </a>
                                <a href="{{ route('estudiante.citas') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('estudiante.citas') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-calendar-check mr-1"></i>Mis Citas
                                </a>
                                <a href="{{ route('chat.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('chat.*') ? 'text-white bg-indigo-600 shadow-md' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30' }}">
                                    <i class="fas fa-comments mr-1"></i>Mensajes
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="toggleDarkMode()" class="p-2 text-gray-600 dark:text-gray-400 hover:text-yellow-500 dark:hover:text-yellow-400 rounded-lg transition-all hover:bg-gray-100 dark:hover:bg-gray-700" title="{{ __('messages.dark_mode') }}">
                            <i class="fas fa-moon dark:hidden"></i>
                            <i class="fas fa-sun hidden dark:inline"></i>
                        </button>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg transition-all hover:bg-gray-100 dark:hover:bg-gray-700" title="{{ __('messages.language') }}">
                                <i class="fas fa-globe text-lg"></i>
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                class="absolute right-0 mt-2 w-36 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 z-50 overflow-hidden">
                                <a href="{{ route('locale.switch', 'es') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ app()->getLocale() === 'es' ? 'font-bold text-indigo-600' : '' }}">
                                    <span class="text-base">🇪🇸</span> {{ __('messages.spanish') }}
                                </a>
                                <a href="{{ route('locale.switch', 'en') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ app()->getLocale() === 'en' ? 'font-bold text-indigo-600' : '' }}">
                                    <span class="text-base">🇺🇸</span> {{ __('messages.english') }}
                                </a>
                            </div>
                        </div>
                        <div class="relative" x-data="{ open: false, count: 0, notifs: [], shake: false }"
                             @notify-update.window="if ($event.detail.count > count) { shake = true; setTimeout(() => shake = false, 500); } count = $event.detail.count; notifs = $event.detail.notificaciones">
                            <button @click="open = !open; if(open && notifs.length === 0) fetchNotifs()" class="relative p-2 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-lg transition-all hover:bg-gray-100 dark:hover:bg-gray-700" :class="{ 'animate-shake': shake }">
                                <i class="fas fa-bell text-lg"></i>
                                <span x-show="count > 0" x-text="count" class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[10px] font-bold rounded-full min-w-[16px] h-4 flex items-center justify-center px-1"></span>
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 z-50 overflow-hidden">
                                <div class="p-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                                    <span class="font-semibold text-gray-800 dark:text-gray-200 text-sm">Notificaciones</span>
                                    <a href="{{ route('notificaciones.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 transition-colors">Ver todas</a>
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    <template x-for="notif in notifs" :key="notif.id">
                                        <a :href="'{{ url('notificaciones') }}/' + notif.id + '/read'" class="flex items-start gap-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border-b border-gray-50 dark:border-gray-700/50 last:border-0">
                                            <div class="w-2 h-2 mt-2 rounded-full bg-indigo-500 flex-shrink-0" x-show="!notif.read_at"></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200" x-text="notif.title"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate" x-text="notif.message"></p>
                                            </div>
                                        </a>
                                    </template>
                                    <div x-show="notifs.length === 0" class="p-6 text-center text-gray-400 dark:text-gray-500 text-sm">
                                        <i class="fas fa-bell text-2xl mb-2"></i><br>Sin notificaciones
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('perfil') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors flex items-center gap-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 p-2 group">
                            @if(auth()->user()->foto_perfil)
                                <img src="{{ auth()->user()->foto_url }}" alt="Foto" class="profile-photo w-7 h-7 rounded-full object-cover ring-2 ring-indigo-200 dark:ring-indigo-800">
                            @else
                                <i class="fas fa-user-circle text-lg text-indigo-500 dark:text-indigo-400 profile-photo"></i>
                            @endif
                            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full font-medium
                                @if(auth()->user()->role === 'admin') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300
                                @elseif(auth()->user()->role === 'tutor') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300
                                @else bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 @endif">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-ripple px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-all duration-200">
                                <i class="fas fa-sign-out-alt mr-1"></i> <span class="hidden md:inline">Salir</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <div id="toastContainer" class="fixed top-20 right-4 z-[100] space-y-3 pointer-events-none"></div>

    <button id="backToTop" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="back-to-top fixed bottom-6 right-6 z-50 bg-gradient-to-r from-indigo-600 to-purple-600 text-white w-10 h-10 rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center justify-center">
        <i class="fas fa-arrow-up"></i>
    </button>

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            @if(session('success'))
                <div class="toast-data hidden" data-type="success" data-message="{{ session('success') }}"></div>
            @endif
            @if(session('error'))
                <div class="toast-data hidden" data-type="error" data-message="{{ session('error') }}"></div>
            @endif
            @if(session('info'))
                <div class="toast-data hidden" data-type="info" data-message="{{ session('info') }}"></div>
            @endif
            @yield('content')
        </div>
    </main>

    @stack('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <script>
        function fetchNotifs() {
            fetch('{{ route("notificaciones.unread") }}')
                .then(r => r.json())
                .then(d => {
                    const alpineEl = document.querySelector('[x-data]');
                    if (alpineEl) {
                        alpineEl.__x.$data.notifs = d.notificaciones;
                        alpineEl.__x.$data.count = d.count;
                        alpineEl.__x.$data.shake = d.count > 0;
                        setTimeout(() => { if (alpineEl.__x) alpineEl.__x.$data.shake = false; }, 500);
                    }
                });
        }

        function showToast(type, message) {
            const container = document.getElementById('toastContainer');
            if (!container) return;
            const icons = { success: 'fa-check-circle text-green-500', error: 'fa-exclamation-circle text-red-500', info: 'fa-info-circle text-blue-500' };
            const borders = { success: 'border-green-500', error: 'border-red-500', info: 'border-blue-500' };
            const bg = { success: 'from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30', error: 'from-red-50 to-rose-50 dark:from-red-900/30 dark:to-rose-900/30', info: 'from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/30' };
            const el = document.createElement('div');
            el.className = 'toast pointer-events-auto cursor-pointer bg-gradient-to-r ' + bg[type] + ' border-l-4 ' + borders[type] + ' text-gray-800 dark:text-gray-200 p-4 rounded-lg shadow-xl flex items-center gap-3 max-w-sm';
            el.innerHTML = '<i class="fas ' + icons[type] + ' text-lg"></i><span class="text-sm font-medium">' + message + '</span>';
            el.addEventListener('click', () => { el.classList.add('toast-exit'); setTimeout(() => el.remove(), 300); });
            container.appendChild(el);
            setTimeout(() => { if (el.isConnected) { el.classList.add('toast-exit'); setTimeout(() => el.remove(), 300); } }, 4500);
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (document.querySelector('[x-data]')) {
                fetchNotifs();
                setInterval(fetchNotifs, 30000);
            }

            document.querySelectorAll('.toast-data').forEach(el => {
                showToast(el.dataset.type, el.dataset.message);
                el.remove();
            });

            document.querySelectorAll('.count-up').forEach(el => {
                const target = parseInt(el.dataset.target);
                if (isNaN(target)) return;
                const duration = 1000;
                const start = performance.now();
                function update(now) {
                    const elapsed = now - start;
                    const progress = Math.min(elapsed / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.floor(eased * target);
                    if (progress < 1) requestAnimationFrame(update);
                }
                requestAnimationFrame(update);
            });

            const backBtn = document.getElementById('backToTop');
            if (backBtn) {
                window.addEventListener('scroll', () => {
                    backBtn.classList.toggle('visible', window.pageYOffset > 300);
                }, { passive: true });
            }
        });

        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('darkMode', isDark);
        }
    </script>
</body>
</html>
