@extends('layouts.template')

@section('content')
<style>
    /* Optimisation du conteneur de table */
    .table-responsive {
        border-radius: 10px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border: 1px solid #dee2e6;
        margin-bottom: 1rem;
    }

    .table th, .table td {
        white-space: nowrap;
        vertical-align: middle;
        font-family: 'Poppins', sans-serif;
    }

    /* Style pour la barre de recherche */
    .search-container {
        max-width: 100%;
        width: 400px;
    }

    @media (max-width: 768px) {
        .table {
            min-width: 700px; /* Force le scroll si l'écran est trop petit */
        }
        .btn-responsive {
            width: 100%;
        }
        .search-container {
            width: 100%;
            margin-bottom: 15px;
        }
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary fw-bold">LISTE DES AGENCES</h2>

    <div class="row mb-4 align-items-center">
        {{-- Barre de recherche --}}
        <div class="col-md-6 d-flex justify-content-start">
            <div class="search-container">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="search" class="form-control" placeholder="Rechercher une agence...">
                </div>
            </div>
        </div>

        {{-- Ajouter une agence --}}
        <div class="col-md-6 text-md-end text-center mt-3 mt-md-0">
            <a href="{{ route('agences.create') }}" class="btn btn-success btn-responsive">
                <i class="fas fa-plus"></i> Ajouter une agence
            </a>
        </div>
    </div>

    {{-- Tableau des agences enveloppé pour la responsivité --}}
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0" id="agences-table">
            <thead class="table-light">
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th class="d-none d-md-table-cell">Abrev</th>
                    <th class="d-none d-lg-table-cell">Siège</th>
                    <th class="d-none d-xl-table-cell">Date création</th>
                    <th class="d-none d-lg-table-cell">Mapping</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="agences-tbody">
                @forelse($agences as $agence)
                <tr>
                    <td class="fw-bold text-secondary">{{ $agence->code }}</td>
                    <td>{{ $agence->nom }}</td>
                    <td class="d-none d-md-table-cell">{{ $agence->abreviation }}</td>
                    <td class="d-none d-lg-table-cell">{{ $agence->siege }}</td>
                    <td class="d-none d-xl-table-cell">{{ $agence->date_creation }}</td>
                    <td class="d-none d-lg-table-cell small text-muted">{{ $agence->mapping }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('agences.show', $agence->id) }}" class="btn btn-outline-info btn-sm" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('agences.edit', $agence->id) }}" class="btn btn-outline-warning btn-sm" title="Modifier">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('agences.destroy', $agence->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger btn-sm btn-delete" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">Aucune agence trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $agences->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // SweetAlert suppression
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: "Êtes-vous sûr ?",
                text: "Cette agence sera définitivement supprimée.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Oui, supprimer",
                cancelButtonText: "Annuler",
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Recherche en temps réel optimisée
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('#agences-tbody tr');

        rows.forEach(row => {
            // On ne cherche que dans les lignes qui ne sont pas le message "vide"
            if(row.cells.length > 1) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            }
        });
    });
});
</script>
@endsection