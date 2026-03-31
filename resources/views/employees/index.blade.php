@extends('layouts.template')

@section('content')
<div class="container-fluid px-4"> <!-- Utilisation de container-fluid pour plus d'espace -->
    <h2 class="mb-4 text-center text-primary">LISTE DES EMPLOYÉ(E)S</h2>
    

    <div class="row g-3 mb-4 justify-content-center">
        {{-- Barre de recherche responsive --}}
        <div class="col-12 col-md-6">
            <input type="text" id="search" class="form-control" placeholder="Rechercher un employé...">
        </div>
        <br> <br>
        {{-- Bouton Ajouter --}}
        <div class="col-12 col text-center">
            <a href="{{ route('employees.create') }}" class="btn btn-success w-sm-100">
                <i class="fas fa-plus"></i> Ajouter un employé
            </a>
        </div>
    </div>

    {{-- Wrapper Responsive --}}
    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-hover align-middle" id="employees-table">
            <thead class="table-light">
                <tr>
                    <th>Matricule</th>
                    <th>Nom & Prénom</th> <!-- Fusion possible pour gagner de la place -->
                    <th class="d-none d-md-table-cell">Sexe</th> <!-- Masqué sur mobile -->
                    <th>Téléphone</th>
                    <th>Poste</th>
                    <th class="d-none d-lg-table-cell">Service</th> <!-- Masqué sur mobile/tablette -->
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="employees-tbody">
                @foreach($employees as $employee)
                <tr>
                    <td><span class="badge ">{{ $employee->matricule }}</span></td>
                    <td><strong>{{ $employee->nom }}</strong> {{ $employee->prenom }}</td>
                    <td class="d-none d-md-table-cell">{{ $employee->sexe }}</td>
                    <td>{{ $employee->telephone ?? '-' }}</td>
                    <td>{{ $employee->poste?->nom ?? 'Non défini' }}</td>
                    <td class="d-none d-lg-table-cell">{{ $employee->poste?->service?->nom ?? 'Non défini' }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $employees->links('pagination::bootstrap-5') }}
    </div>
</div>

<script>
    const searchInput = document.getElementById('search');
    const table = document.getElementById('employees-table'); // corrigé ici
    const rows = table.getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();

        // Boucle sur chaque ligne du tableau (sauf l'en-tête)
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            // Vérifie chaque cellule de la ligne
            for (let j = 0; j < cells.length; j++) {
                if (cells[j].textContent.toLowerCase().includes(filter)) {
                    match = true;
                    break;
                }
            }

            rows[i].style.display = match ? '' : 'none';
        }
    });
</script>
@endsection