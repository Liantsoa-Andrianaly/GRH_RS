@extends('layouts.template')

@section('content')

<div class="container py-4">
    {{-- En-tête stylisé --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold text-dark shadow-sm d-inline-block px-4 py-2 rounded-pill bg-white">
            <i class="bi bi-calendar-check text-primary me-2"></i>FEUILLE DE POINTAGE
        </h2>
    </div>

    {{-- Notifications SweetAlert --}}
    @if(session('success') || session('error'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: "{{ session('success') ? 'success' : 'error' }}",
                    title: "{{ session('success') ? 'Succès' : 'Erreur' }}",
                    text: "{{ session('success') ?? session('error') }}",
                    timer: 2500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            });
        </script>
    @endif

    {{-- Barre de recherche moderne --}}
    <div class="row mb-4 justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Rechercher un collaborateur...">
            </div>
        </div>
    </div>

    <div class="main-card shadow-lg border-0">
        <div class="card-header-custom">
            <span><i class="bi bi-clock-history me-2"></i>Flux d'activité</span>
            <span class="badge bg-primary-soft text-primary px-3">{{ $pointages->count() }} Entrées</span>
        </div>

        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0" id="pointagesTable">
                <thead>
                    <tr>
                        <th class="ps-4">TOTAL</th>
                        <th>EMPLOYÉ</th>
                        <th>ENTRÉE</th>
                        <th>SORTIE</th>
                        <th class="text-center pe-4">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pointages->sortByDesc('entree') as $p)
                        <tr>
                            <td class="ps-4">
                                <span class="time-badge">{{ $p->heuresTotalesFormat() }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        {{ strtoupper(substr($p->employee->nom ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold">{{ optional($p->employee)->nom }} {{ optional($p->employee)->prenom }}</span>
                                </div>
                            </td>
                            <td class="text-muted small">
                                <i class="bi bi-box-arrow-in-right text-success me-1"></i>
                                {{ optional($p->entree)->format('d/m/Y H:i') }}
                            </td>
                            <td class="small">
                                @if($p->sortie)
                                    <i class="bi bi-box-arrow-left text-danger me-1"></i>
                                    {{ optional($p->sortie)->format('d/m/Y H:i') }}
                                @else
                                    <span class="status-live">
                                        <span class="dot"></span> En cours
                                    </span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="action-buttons">
                                    <a href="{{ route('pointages.edit', $p) }}" class="btn-edit" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('pointages.destroy', $p) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small italic">Aucun enregistrement trouvé.</td>
                        </tr>
                    @endforelse

                    {{-- Ligne de création (Conservée en bas comme demandé) --}}
                    <tr class="add-row-modern">
                        <form action="{{ route('pointages.store') }}" method="POST">
                            @csrf
                            <td class="d-none d-md-table-cell ps-4">
                                <i class="bi bi-plus-circle-dotted fs-4 text-primary"></i>
                            </td>
                            <td>
                                <select name="employee_id" class="form-select-custom shadow-none" required>
                                    <option value="">Choisir l'employé...</option>
                                    @foreach($employees as $e)
                                        <option value="{{ $e->id }}">{{ $e->nom }} {{ $e->prenom }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="datetime-local" name="entree" id="entree" class="form-control-custom"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>
                            </td>
                            <td>
                                <input type="datetime-local" name="sortie" id="sortie" class="form-control-custom"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">
                            </td>
                            <td class="pe-4">
                                <button type="submit" class="btn-save-modern w-100">
                                    <i class="bi bi-check2-circle me-1"></i> ENREGISTRER
                                </button>
                            </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4 pagination-custom">
        {{ $pointages->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
    /* Global Background */
    body { background-color: #f4f7f6; font-family: 'Inter', sans-serif; }

    /* Search Box */
    .search-box {
        position: relative;
        background: white;
        border-radius: 15px;
        padding: 5px 15px;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .search-box i { color: #aaa; margin-right: 10px; }
    .search-box input {
        border: none;
        outline: none;
        width: 100%;
        padding: 8px 0;
        font-size: 0.95rem;
    }

    /* Card & Table */
    .main-card { background: white; border-radius: 20px; overflow: hidden; }
    .card-header-custom {
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
        font-weight: 700;
        color: #333;
    }
    
    .table-custom thead { background: #fcfcfc; }
    .table-custom thead th {
        font-size: 0.75rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #888;
        padding: 15px 10px;
        border: none;
    }

    .table-custom tbody tr { transition: all 0.2s; border-bottom: 1px solid #f9f9f9; }
    .table-custom tbody tr:hover { background-color: #f8fbff; }

    /* Badges & Avatars */
    .time-badge {
        background: #eef2ff;
        color: #4361ee;
        padding: 5px 12px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.9rem;
    }
    .avatar-sm {
        width: 32px; height: 32px;
        background: #4361ee; color: white;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; font-weight: bold;
    }

    /* Live Status Pulse */
    .status-live {
        background: #fff4e5;
        color: #d97706;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .dot {
        height: 8px; width: 8px;
        background-color: #f59e0b;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
        animation: pulse-dot 1.5s infinite;
    }
    @keyframes pulse-dot {
        0% { opacity: 1; } 50% { opacity: 0.3; } 100% { opacity: 1; }
    }

    /* Inputs Customs */
    .form-select-custom, .form-control-custom {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 0.85rem;
        width: 100%;
        transition: 0.3s;
    }
    .form-select-custom:focus, .form-control-custom:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    /* Buttons */
    .btn-edit { color: #4361ee; background: #eef2ff; border: none; padding: 6px 10px; border-radius: 8px; transition: 0.3s; }
    .btn-edit:hover { background: #4361ee; color: white; }
    
    .btn-delete { color: #ef4444; background: #fef2f2; border: none; padding: 6px 10px; border-radius: 8px; transition: 0.3s; }
    .btn-delete:hover { background: #ef4444; color: white; }

    .add-row-modern { background-color: #f8faff !important; border-top: 2px solid #eef2ff !important; }
    .btn-save-modern {
        background: #4361ee;
        color: white;
        border: none;
        padding: 8px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.75rem;
        transition: 0.3s;
    }
    .btn-save-modern:hover { background: #3046bd; transform: translateY(-1px); }

    .bg-primary-soft { background-color: rgba(67, 97, 238, 0.1); }
</style>

{{-- JS (Logique identique) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const entree = document.getElementById('entree');
        const sortie = document.getElementById('sortie');
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.querySelector('#pointagesTable tbody');

        entree.addEventListener('input', function() {
            if(this.value && !sortie.value) {
                const dateEntree = this.value.split('T')[0];
                const currentHeureSortie = sortie.value.split('T')[1] || '17:00';
                sortie.value = `${dateEntree}T${currentHeureSortie}`;
            }
        });

        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr:not(.add-row-modern)');
            rows.forEach(row => {
                const content = row.innerText.toLowerCase();
                row.style.display = content.includes(filter) ? '' : 'none';
            });
        });

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Confirmer la suppression ?',
                    text: "Cette donnée sera définitivement effacée.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) { this.submit(); }
                });
            });
        });
    });
</script>

@endsection