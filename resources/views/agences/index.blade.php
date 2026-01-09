@extends('layouts.template')

@section('content')

<h2 class="mb-4 text-center text-primary">LISTE DES AGENCES</h2>

{{-- Barre de recherche --}}
<div class="mb-3 d-flex justify-content-center" style="max-width: 400px;">
    <input type="text" id="search" class="form-control" placeholder="Rechercher une agence...">
</div>

{{-- Ajouter une agence --}}
<div class="mb-3 text-center">
    <a href="{{ route('agences.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Ajouter une agence
    </a>
</div>

{{-- Tableau des agences --}}
<table class="table table-bordered table-hover" id="agences-table">
    <thead class="thead-light">
        <tr>
            <th>Code</th>
            <th>Nom</th>
            <th>Abrev</th>
            <th>Siège</th>
            <th>Date création</th>
            <th>Mapping</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="agences-tbody">
        @foreach($agences as $agence)
        <tr>
            <td>{{ $agence->code }}</td>
            <td>{{ $agence->nom }}</td>
            <td>{{ $agence->abreviation }}</td>
            <td>{{ $agence->siege }}</td>
            <td>{{ $agence->date_creation }}</td>
            <td>{{ $agence->mapping }}</td>
            <td>
                <a href="{{ route('agences.show', $agence->id) }}" class="btn btn-info btn-sm">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('agences.edit', $agence->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('agences.destroy', $agence->id) }}" method="POST" class="d-inline delete-form">
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
    {{ $agences->links('pagination::bootstrap-5') }}
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
                text: "Cette agence sera définitivement supprimée.",
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

        document.querySelectorAll('#agences-tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

});
</script>

@endsection
