@extends('layouts.app')

@section('title', 'Registro de Actividad')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
        <i class="fas fa-history mr-2 text-indigo-600"></i>Registro de Actividad
    </h1>
</div>

<div x-data="activityTable()" x-init="init()" id="activityTableWrapper">
    <div class="card-hover glass-card rounded-xl shadow-md overflow-hidden" id="tableContainer">
        @include('admin.partials.activity-table')
    </div>
</div>
@endsection

@push('scripts')
<script>
function activityTable() {
    return {
        loading: false,

        init() {
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

        goPage(p) {
            this.loading = true;
            fetch('{{ route('admin.actividad') }}?page=' + p, {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(d => {
                document.getElementById('tableContainer').innerHTML = d.html;
                this.loading = false;
                history.replaceState(null, '', '{{ route('admin.actividad') }}?page=' + p);
            })
            .catch(() => { this.loading = false; });
        }
    };
}
</script>
@endpush
