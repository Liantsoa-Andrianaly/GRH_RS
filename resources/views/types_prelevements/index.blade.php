@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <h4>Types de prélèvements</h4>

    <a href="{{ route('types_prelevements.create') }}" class="btn btn-primary mb-3">
        Nouveau type
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Abréviation</th>
                <th>Nom complet</th>
                <th>Valeur</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($types as $type)
                <tr>
                    <td>{{ $type->abreviation }}</td>
                    <td title="{{ $type->nom_complet }}">{{ \Illuminate\Support\Str::limit($type->nom_complet, 50) }}</td>
                    <td>
                        @if($type->type_valeur === 'montant')
                            {{ number_format($type->valeur, 0, ',', ' ') }} MGA
                        @else
                            {{ $type->valeur }} %
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('types_prelevements.edit', $type) }}" class="btn btn-warning btn-sm">✏️</a>

                        <!-- Formulaire pour suppression avec classe delete-form -->
                        <form action="{{ route('types_prelevements.destroy', $type) }}"
                              method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="button">🗑️</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun type enregistré</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<!-- Inclure SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Message de succès -->
@if(session('success'))
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

<!-- Confirmation avant suppression -->
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.querySelector('button').addEventListener('click', function(e) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Soumettre le formulaire si confirmé
            }
        });
    });
});
</script>
@endsection
