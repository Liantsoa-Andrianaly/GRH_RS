@extends('layouts.template')

@section('content')
    <h2 class="mb-4 text-center text-primary">LISTE DES POSTES</h2>

{{-- Barre de recherche --}}
<div class="mb-3 d-flex justify-content-center" style="max-width: 400px;">
    <input type="text" id="search" class="form-control" placeholder="Rechercher un poste...">
</div>

<div class="mb-3 text-center">
    <a href="{{ route('postes.create') }}" class="btn btn-success mb-3">Créer un poste</a>
</div>
{{-- Notification SweetAlert --}}
@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    </script>
@endif

<table class="table table-bordered table-hover" id="postes-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nom du poste</th>
            <th>Service lié</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="postes-tbody">
        @forelse($postes as $poste)
            <tr>
                <td>{{ $poste->id }}</td>
                <td>{{ $poste->nom }}</td>
                <td>{{ $poste->service->nom ?? 'Non défini' }}</td>
                <td>
                    <a href="{{ route('postes.edit', $poste->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    <form action="{{ route('postes.destroy', $poste->id) }}" 
                          method="POST" 
                          class="d-inline delete-form">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-danger btn-sm btn-delete">
                             <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Aucun poste trouvé.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $postes->links() }}

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // SweetAlert pour suppression
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            let form = this.closest('form');
            Swal.fire({
                title: "Êtes-vous sûr ?",
                text: "Ce poste sera définitivement supprimé.",
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

        document.querySelectorAll('#postes-tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

});
</script>

@endsection
