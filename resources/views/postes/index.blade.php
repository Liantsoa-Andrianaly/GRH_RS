@extends('layouts.template')

@section('content')
<style>
    /* Optimisation de la table responsive */
    .table-responsive {
        border-radius: 10px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border: 1px solid #dee2e6;
        background-color: white;
    }

    .table th, .table td {
        vertical-align: middle;
        font-family: 'Poppins', sans-serif;
        white-space: nowrap; /* Évite les retours à la ligne désordonnés */
    }

    @media (max-width: 768px) {
        .btn-responsive {
            width: 100%;
            margin-bottom: 10px;
        }
        .search-container {
            width: 100% !important;
            max-width: 100% !important;
        }
        /* On réduit la taille de la police pour gagner de la place sur mobile */
        .table td, .table th {
            font-size: 0.85rem;
            padding: 0.5rem;
        }
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary fw-bold">LISTE DES POSTES</h2>

    {{-- Barre d'outils (Recherche + Création) --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <div class="search-container" style="max-width: 400px;">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="search" class="form-control border-start-0" placeholder="Rechercher un poste...">
                </div>
            </div>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('postes.create') }}" class="btn btn-success btn-responsive shadow-sm">
                <i class="bi bi-plus-circle"></i> Créer un poste
            </a>
        </div>
    </div>

    {{-- Tableau Responsive --}}
    <div class="table-responsive shadow-sm">
        <table class="table table-hover mb-0" id="postes-table">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Nom du poste</th>
                    <th scope="col">Service lié</th>
                    <th scope="col" class="text-center" style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody id="postes-tbody">
                @forelse($postes as $poste)
                    <tr>
                        <td class="fw-bold">{{ $poste->nom }}</td>
                        <td>
                            <span class="badge bg-light text-primary border">
                                {{ $poste->service->nom ?? 'Non défini' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('postes.edit', $poste->id) }}" class="btn btn-outline-warning btn-sm" title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('postes.destroy', $poste->id) }}" method="POST" class="d-inline delete-form">
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
                        <td colspan="4" class="text-center py-4 text-muted italic">
                            Aucun poste trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination centrée --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $postes->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Notification SweetAlert améliorée --}}
@if(session('success') || session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: "{{ session('success') ? 'success' : 'error' }}",
                title: "{{ session('success') ? 'Succès' : 'Erreur' }}",
                text: "{{ addslashes(session('success') ?? session('error')) }}",
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                timerProgressBar: true
            });
        });
    </script>
@endif

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Confirmation de suppression
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: "Êtes-vous sûr ?",
                text: "Cette action est irréversible.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Oui, supprimer",
                cancelButtonText: "Annuler",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Recherche en temps réel (optimisée pour éviter les bugs d'affichage)
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', function () {
        const query = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('#postes-tbody tr');

        rows.forEach(row => {
            if(row.cells.length > 1) { // Ne pas filtrer la ligne "Aucun résultat"
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            }
        });
    });

});
</script>

@endsection