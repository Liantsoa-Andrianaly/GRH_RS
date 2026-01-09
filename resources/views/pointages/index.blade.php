@extends('layouts.template')

@section('content')

<h2 class="mb-4 text-center text-primary">FEUILLE DE POINTAGE</h2>

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
<div class="mb-3">
    <input type="text" id="searchInput" placeholder="Rechercher un employé..." class="form-control" style="width: 450px;">
</div>

<div class="card">
    <div class="card-header">
        <strong>Pointages enregistrés</strong>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover" id="pointagesTable">
            <thead class="thead-light">
                <tr>
                    <th>Heures travaillés</th>
                    <th>Employé</th>
                    <th>Date et heure d'entrée</th>
                    <th>Date et heure de sortie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Liste des pointages --}}
                @forelse($pointages->sortByDesc('entree') as $p)
                    <tr>
                        <td>{{ $p->heuresTotalesFormat() }}</td>
                        <td>{{ optional($p->employee)->nom ?? '—' }} {{ optional($p->employee)->prenom ?? '' }}</td>
                        <td>{{ optional($p->entree)->format('d/m/Y \\à H:i') ?? '—' }}</td>
                        <td>
                            @if($p->sortie)
                                {{ optional($p->sortie)->format('d/m/Y \\à H:i') }}
                            @else
                                <em>Pointage en cours…</em>
                            @endif
                        </td>
                        <td class="text-center">

                            {{-- Modifier --}}
                            <a href="{{ route('pointages.edit', $p) }}"
                            class="text-primary me-2"
                            title="Modifier">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </a>

                            {{-- Supprimer --}}
                            <form action="{{ route('pointages.destroy', $p) }}"
                                method="POST"
                                class="d-inline delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-link p-0 text-danger"
                                        title="Supprimer">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Aucun pointage enregistré pour le moment.</td>
                    </tr>
                @endforelse

                {{-- Ligne de création de pointage --}}
                <tr class="table-info">
                    <form action="{{ route('pointages.store') }}" method="POST">
                        @csrf
                        <td></td>
                        <td>
                            <select name="employee_id" class="form-control" required>
                                <option value="">-- Choisir un employé --</option>
                                @foreach($employees as $e)
                                    <option value="{{ $e->id }}">{{ $e->nom }} {{ $e->prenom }}</option>
                                @endforeach
                            </select>
                        </td>
                    <td>
                        <input type="datetime-local" name="entree" id="entree" class="form-control"
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}T00:00" required>
                    </td>
                    <td>
                        <input type="datetime-local" name="sortie" id="sortie" class="form-control"
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}T00:00">
                    </td>

                        <td>
                            <button class="btn btn-primary btn-block">ENREGISTRER</button>
                        </td>
                    </form>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-center mt-3">
    {{ $pointages->links() }}
</div>

<script>
    const entree = document.getElementById('entree');
    const sortie = document.getElementById('sortie');

    entree.addEventListener('input', function() {
        const dateEntree = this.value.split('T')[0];
        const heureSortie = sortie.value.split('T')[1] || '00:00';
        sortie.value = `${dateEntree}T${heureSortie}`;
    });
</script>

{{-- Script pour recherche et confirmation suppression --}}
<script>
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('pointagesTable').getElementsByTagName('tbody')[0];

    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        Array.from(tableBody.rows).forEach(row => {
            const nomPrenom = row.cells[1]?.textContent.toLowerCase() || '';
            row.style.display = nomPrenom.includes(filter) ? '' : 'none';
        });
    });

    // Confirmation SweetAlert pour suppression
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
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
                    form.submit();
                }
            });
        });
    });
</script>

@endsection
