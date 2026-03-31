@extends('layouts.template')

@section('content')
<style>
    /* Conteneur principal */
    .table-responsive {
        border-radius: 10px;
        overflow-x: auto;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border: 1px solid #dee2e6;
        background-color: white;
    }

    .table th, .table td {
        vertical-align: middle;
        font-family: 'Poppins', sans-serif;
    }

    /* Style spécifique pour mobile (Cartes) */
    .mobile-card {
        display: none; /* Caché par défaut */
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    @media (max-width: 768px) {
        /* On cache la table classique sur petit mobile si on veut privilégier les cartes */
        /* Ou on garde la table mais on force son défilement */
        .desktop-table {
            display: none; 
        }
        .mobile-card {
            display: block;
        }
        .btn-responsive {
            width: 100%;
            margin-bottom: 10px;
        }
        .search-container {
            width: 100% !important;
            max-width: 100% !important;
        }
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary fw-bold">LISTE DES SERVICES</h2>

    {{-- Barre d'outils --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <div class="search-container" style="max-width: 400px;">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="search" class="form-control border-start-0" placeholder="Rechercher un service...">
                </div>
            </div>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('services.create') }}" class="btn btn-success btn-responsive shadow-sm">
                <i class="bi bi-plus-circle"></i> <span class="d-none d-sm-inline">Créer un service</span><span class="d-inline d-sm-none">Ajouter</span>
            </a>
        </div>
    </div>

    {{-- VERSION DESKTOP : Tableau --}}
    <div class="table-responsive desktop-table shadow-sm">
        <table class="table table-hover mb-0" id="services-table">
            <thead class="table-primary">
                <tr>
                    <th scope="col" class="ps-3">Nom du service</th>
                    <th scope="col" class="d-none d-md-table-cell">Postes liés</th>
                    <th scope="col" class="text-center" style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody id="services-tbody">
                @forelse($services as $service)
                    <tr>
                        <td class="fw-bold text-dark ps-3">{{ $service->nom }}</td>
                        <td class="d-none d-md-table-cell">
                            @if($service->postes->count())
                                <span class="badge bg-info text-dark">{{ $service->postes->count() }} poste(s) lié(s)</span>
                            @else
                                <span class="text-muted small">Aucun poste</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('services.show', $service->id) }}" class="btn btn-outline-info btn-sm"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('services.edit', $service->id) }}" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-4">Aucun service trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- VERSION MOBILE : Liste de cartes (S'affiche uniquement sur mobile) --}}
    <div id="mobile-list" class="d-md-none">
        @foreach($services as $service)
            <div class="mobile-card service-item">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="fw-bold text-primary mb-0">{{ $service->nom }}</h5>
                    <span class="badge bg-light text-dark border">{{ $service->postes->count() }} postes</span>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $services->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Script de recherche mis à jour pour gérer Table + Cartes --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    
    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        
        // Recherche dans la table (Desktop)
        document.querySelectorAll('#services-tbody tr').forEach(row => {
            if(row.cells.length > 1) {
                row.style.display = row.textContent.toLowerCase().includes(query) ? '' : 'none';
            }
        });

        // Recherche dans les cartes (Mobile)
        document.querySelectorAll('.service-item').forEach(card => {
            card.style.display = card.textContent.toLowerCase().includes(query) ? 'block' : 'none';
        });
    });
});
</script>
@endsection