@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            <i class="fas fa-users mr-2 text-indigo-600"></i>Usuarios
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Gestión de usuarios del sistema</p>
    </div>
    <a href="{{ route('admin.usuarios.create') }}" class="btn-ripple inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
        <i class="fas fa-plus mr-2"></i>Nuevo Usuario
    </a>
</div>

<div x-data="userTable()" x-init="init()" id="userTableWrapper">
    <div class="card-hover glass-card rounded-xl shadow-md mb-6">
        <div class="p-4 border-b border-gray-100 dark:border-gray-700">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" x-model="search" @input.debounce.300ms="load()" placeholder="Buscar por nombre o email..."
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <select x-model="role" @change="load()" class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        <option value="">Todos los roles</option>
                        <option value="admin">Admin</option>
                        <option value="tutor">Tutor</option>
                        <option value="estudiante">Estudiante</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <span x-show="loading" class="text-sm text-gray-400"><i class="fas fa-spinner fa-spin mr-1"></i> Cargando...</span>
                    <span x-show="!loading && total > 0" class="text-sm text-gray-500" x-text="total + ' resultado(s)'"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card-hover glass-card rounded-xl shadow-md overflow-hidden" id="tableContainer">
        @include('admin.usuarios.partials.table')
    </div>
</div>
@endsection

@push('scripts')
<script>
function userTable() {
    return {
        search: '{{ request('search') }}',
        role: '{{ request('role') }}',
        tableHtml: '',
        loading: false,
        total: {{ $usuarios->total() }},

        init() {
            if (this.search || this.role) this.load();
            document.addEventListener('click', e => {
                const link = e.target.closest('#tableContainer a[href*="page="]');
                if (link) {
                    e.preventDefault();
                    const url = new URL(link.href);
                    const page = url.searchParams.get('page');
                    if (page) this.goPage(parseInt(page));
                }
            });
        },

        load() {
            this.loading = true;
            const params = new URLSearchParams({ search: this.search, role: this.role, page: this.page ?? 1 });
            fetch('{{ route('admin.usuarios.index') }}?' + params.toString(), {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(d => {
                document.getElementById('tableContainer').innerHTML = d.html;
                this.total = d.total;
                this.page = d.page;
                this.loading = false;
                history.replaceState(null, '', '{{ route('admin.usuarios.index') }}?' + params.toString());
            })
            .catch(() => { this.loading = false; });
        },

        goPage(p) {
            this.page = p;
            this.load();
        }
    };
}
</script>
@endpush
