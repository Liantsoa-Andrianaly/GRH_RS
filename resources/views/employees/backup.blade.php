@extends('layouts.template')

@section('content')
<div class="container-fluid px-4 mt-4">
    <h2 class="mb-4 text-center text-primary fw-bold">LISTE DES EMPLOYÉS SUPPRIMÉS</h2>

    <div class="mb-3">
        <a href="{{ route('employees.index') }}" class="btn btn-outline-danger shadow-sm">
            <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Revenir à la liste</span>
        </a>
    </div>

    {{-- 1. VUE TABLEAU (Pour Ordinateurs et Tablettes) --}}
    <div class="table-responsive shadow-sm d-none d-md-block">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Matricule</th>
                    <th>Nom & Prénom</th>
                    <th>Poste</th>
                    <th>Téléphone</th>
                    <th>Date Suppression</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backups as $backup)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $backup->matricule ?? 'N/D' }}</span></td>
                    <td>{{ $backup->nom }} {{ $backup->prenom }}</td>
                    <td>{{ $backup->poste?->nom ?? 'Non défini' }}</td>
                    <td>{{ $backup->telephone }}</td>
                    <td class="text-danger fw-bold">{{ $backup->deleted_at_formatted }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Aucun employé supprimé trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 2. VUE CARTES (Pour Mobiles) --}}
    <div class="d-md-none">
        @forelse($backups as $backup)
        <div class="card mb-3 shadow-sm border-start border-danger border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-secondary">#{{ $loop->iteration }}</span>
                    <small class="text-danger fw-bold">{{ $backup->deleted_at_formatted }}</small>
                </div>
                <h5 class="card-title text-uppercase fw-bold mb-1">{{ $backup->nom }} {{ $backup->prenom }}</h5>
                <p class="card-text mb-1"><strong>Matricule:</strong> {{ $backup->matricule ?? 'N/D' }}</p>
                <p class="card-text mb-1"><strong>Poste:</strong> {{ $backup->poste?->nom ?? 'N/D' }}</p>
                <p class="card-text mb-0 text-muted small"><i class="bi bi-telephone"></i> {{ $backup->telephone }}</p>
            </div>
        </div>
        @empty
        <div class="alert alert-info text-center">Aucun employé supprimé trouvé.</div>
        @endforelse
    </div>

    {{-- 3. PAGINATION (En dehors de tout tableau ou carte) --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $backups->links() }}
    </div>
</div>
@endsection