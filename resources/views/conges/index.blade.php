@extends('layouts.template')

@section('content')

<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary">LISTE DES CONGES</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Type</th>
                <th>Statut</th>
                <th>Jours</th>
                
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($conges as $conge)
            <tr>
                <td>{{ $conge->employee?->nom ?? '-' }} {{ $conge->employee?->prenom ?? '-' }}</td>
                <td>{{ $conge->date_debut }}</td>
                <td>{{ $conge->date_fin }}</td>
                <td>{{ $conge->type }}</td>
                <td>{{ $conge->statut }}</td>
                <td>{{ $conge->nombre ?? '-' }}</td>

                 
            <td>
                @if($conge->statut === 'en_attente')

                    {{-- VALIDER --}}
                    <form action="{{ route('conges.valider', $conge->id) }}"
                        method="POST"
                        style="display:inline">
                        @csrf
                        <button type="submit"
                                class="btn btn-success btn-sm btn-valider-conge">
                            Valider
                        </button>

                    </form>

                    {{-- REFUSER --}}
                    <button class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#refuserModal{{ $conge->id }}">
                        Refuser
                    </button>

                @elseif($conge->statut === 'valide')
                    <span class="badge bg-success">Validé</span>

                    {{-- Bouton PDF uniquement si validé --}}
                    <a href="{{ route('conges.pdf', $conge->id) }}"
                    class="btn btn-link p-0 text-danger ms-2">
                        <i class="bi bi-download"></i>

                    </a>

                @else
                    <span class="badge bg-danger">Refusé</span>
                    {{-- Pas de PDF si refusé --}}
                @endif
            </td>


            </tr>
        @endforeach
        </tbody>
    </table>




@foreach($conges as $conge)
<div class="modal fade" id="refuserModal{{ $conge->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('conges.refuser', $conge->id) }}">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Refuser le congé</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label>Motif du refus</label>
                    <textarea name="commentaire_validation"
                              class="form-control"
                              required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">
                        Confirmer le refus
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach





    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('conges.vider') }}" class="btn btn-danger mb-3" 
   onclick="return confirm('Voulez-vous vraiment supprimer tous les congés ?')">
   Vider tous les congés
</a>


</div>

<div class="d-flex justify-content-center mt-3">
    {{ $conges->links() }}
</div>

<script>
    document.querySelectorAll('.btn-valider-conge').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const form = this.closest('form');

            Swal.fire({
                title: 'Valider ce congé ?',
                text: "Le solde de congé de l’employé sera déduit.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, valider',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
