@extends('layouts.template')

@section('content')


    <h2 class="mb-4 text-center text-primary">LISTE DES SERVICES</h2>


{{-- Notifications SweetAlert --}}
@if(session('success') || session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: '{{ session('error') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    </script>
@endif

{{-- Barre de recherche --}}
<div class="mb-3 d-flex justify-content-center" style="max-width: 400px;">
    <input type="text" id="search" class="form-control" placeholder="Rechercher un service...">
</div>
<div class="mb-3 text-center">

    <a href="{{ route('services.create') }}" class="btn btn-success mb-3">Créer un service</a>
</div>

<table class="table table-bordered table-hover" id="services-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nom du service</th>
            <th>Postes liés</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="services-tbody">
        @forelse($services as $service)
            <tr>
                <td>{{ $service->id }}</td>
                <td>{{ $service->nom }}</td>
                <td>
                    @if($service->postes->count())
                        <ul>
                            @foreach($service->postes as $poste)
                                <li>{{ $poste->nom }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">Aucun poste</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('services.show', $service->id) }}" 
                       class="btn btn-info btn-sm">
                       <i class="bi bi-eye"></i>
                    </a>

                    <a href="{{ route('services.edit', $service->id) }}" 
                       class="btn btn-warning btn-sm">
                       <i class="bi bi-pencil-square"></i>
                    </a>

                    <form action="{{ route('services.destroy', $service->id) }}" 
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
                <td colspan="4" class="text-center text-muted">Aucun service trouvé.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $services->links() }}

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
                text: "Ce service sera définitivement supprimé.",
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

        document.querySelectorAll('#services-tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

});
</script>

@endsection
