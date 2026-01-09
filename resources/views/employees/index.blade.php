@extends('layouts.template')

@section('content')


    <h2 class="mb-4 text-center text-primary" >LISTE DES EMPLOYÉ(E)S</h2>

  {{-- Barre de recherche --}}
<div class="mb-3 d-flex justify-content-center" style="max-width: 400px;">
    <input type="text" id="search" class="form-control" placeholder="Rechercher un employé...">
</div>


    {{-- Ajouter un employé --}}
    <div class="mb-3 text-center">
        <a href="{{ route('employees.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Ajouter un employé
        </a>
    </div>

    {{-- Tableau des employés --}}

        <table class="table table-bordered table-hover" id="employees-table">
            <thead class="thead-light">
                <tr>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Sexe</th>
                     <!--th>Statut</th-->
                    <!--th>Email</th-->
                    <th>Téléphone</th>
                    <th>Poste</th>
                   
                    <th>Service</th>
                    <th>Agence</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="employees-tbody">
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->matricule }}</td>
                    <td>{{ $employee->nom }}</td>
                    <td>{{ $employee->prenom }}</td>
                    <td>{{ $employee->sexe }}</td>
                    <!--td>{{ $employee->statut_matrimonial ?? 'Non défini' }}</td-->
                    <!--td>{{ $employee->email ?? '-' }}</td-->
                    <td>{{ $employee->telephone ?? '-' }}</td>
                    <td>{{ $employee->poste?->nom ?? 'Non défini' }}</td>
                    
                    <td>{{ $employee->poste?->service?->nom ?? 'Non défini' }}</td>
                    <td>{{ $employee->agence?->nom ?? 'Non défini' }}</td>
                    <td>
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
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $employees->links('pagination::bootstrap-5') }}
    </div>


{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // SweetAlert suppression
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            let form = this.closest('form');
            Swal.fire({
                title: "Êtes-vous sûr ?",
                text: "Cet employé sera définitivement supprimé.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Oui, supprimer",
                cancelButtonText: "Annuler"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Recherche en temps réel
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('keyup', function () {
        const query = this.value.toLowerCase();

        document.querySelectorAll('#employees-tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

});
</script>

@endsection