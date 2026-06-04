@extends('layouts.app')

@section('title', 'Materias')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            <i class="fas fa-book mr-2 text-indigo-600"></i>Materias
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Catálogo de materias académicas</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.materias.import') }}" class="btn-ripple inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
            <i class="fas fa-file-import mr-2"></i>Importar
        </a>
        <a href="{{ route('admin.materias.create') }}" class="btn-ripple inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
            <i class="fas fa-plus mr-2"></i>Nueva Materia
        </a>
    </div>
</div>

<div x-data="subjectTable()" x-init="init()" id="subjectTableWrapper">
    <div class="card-hover glass-card rounded-xl shadow-md mb-6">
        <div class="p-4 border-b border-gray-100 dark:border-gray-700">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" x-model="search" @input.debounce.300ms="load()" placeholder="Buscar por nombre o código..."
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <select x-model="area" @change="load()" class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        <option value="">Todas las áreas</option>
                        @foreach($areas as $areaOption)
                            <option value="{{ $areaOption }}">{{ $areaOption }}</option>
                        @endforeach
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
        @include('admin.materias.partials.table')
    </div>
</div>
@endsection

@push('scripts')
<script>
function subjectTable() {
    return {
        search: '{{ request('search') }}',
        area: '{{ request('area') }}',
        loading: false,
        total: {{ $materias->total() }},

        init() {
            if (this.search || this.area) this.load();
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
            const params = new URLSearchParams({ search: this.search, area: this.area, page: this.page ?? 1 });
            fetch('{{ route('admin.materias.index') }}?' + params.toString(), {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(d => {
                document.getElementById('tableContainer').innerHTML = d.html;
                this.total = d.total;
                this.page = d.page;
                this.loading = false;
                history.replaceState(null, '', '{{ route('admin.materias.index') }}?' + params.toString());
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
