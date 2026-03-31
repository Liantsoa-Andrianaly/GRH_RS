@extends('layouts.template')

@section('content')
<style>
    /* 1. Correction majeure : overflow-x: auto au lieu de hidden */
    .table-responsive {
        border-radius: 10px;
        overflow-x: auto; /* Permet le scroll horizontal sur mobile */
        -webkit-overflow-scrolling: touch; /* Scroll fluide sur iPhone */
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border: 1px solid #dee2e6;
    }
    
    .table th, .table td {
        white-space: nowrap; /* Empêche les données de s'écraser */
        vertical-align: middle;
        font-family: 'Poppins', sans-serif;
    }

    /* 2. On s'assure que le tableau garde une largeur minimum sur mobile */
    @media (max-width: 768px) {
        .table {
            min-width: 800px; 
        }
        .btn-responsive {
            width: 100%;
            margin-bottom: 15px;
        }
        .display-mobile-title {
            font-size: 1.2rem;
        }
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary fw-bold display-mobile-title">
        LISTE DES EMPLOYÉS SUPPRIMÉS
    </h2>
    
    <div class="mb-3">
        <a href="{{ route('employees.index') }}" class="btn btn-danger btn-responsive">
             <i class="fas fa-arrow-left"></i> Revenir à la liste
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-primary">
                <tr>
                    <th scope="col">Matricule</th>
                    <th scope="col">Nom & Prénom</th>
                    <th scope="col" class="d-none d-lg-table-cell">Poste</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col" class="d-none d-md-table-cell">Adresse</th>
                    <th scope="col">Date de suppression</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backups as $backup)
                <tr>
                    <td><span class="badge bg">{{ $backup->matricule ?? 'N/D' }}</span></td>
                    <td class="fw-bold">{{ $backup->nom }} {{ $backup->prenom }}</td>
                    <td class="d-none d-lg-table-cell">{{ $backup->poste?->nom ?? 'Non défini' }}</td>
                    <td>{{ $backup->telephone }}</td>
                    <td class="d-none d-md-table-cell text-truncate" style="max-width: 150px;">
                        {{ $backup->adresse }}
                    </td>
                    <td>
                        <span class="text-danger fw-bold">
                            {{ \Carbon\Carbon::parse($backup->deleted_at)->format('d/m/Y') }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <!-- Note: le colspan doit correspondre au nombre de colonnes visibles -->
                    <td colspan="6" class="text-center py-4 text-muted">
                        Aucun employé supprimé trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $backups->links() }}
    </div>
</div>
@endsection