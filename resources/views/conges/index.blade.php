@extends('layouts.template')

@section('content')
<div class="container-fluid px-2 px-md-4 py-4">
    {{-- En-tête --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <h2 class="fw-bold text-primary mb-0"><i class="bi bi-calendar2-check me-2"></i>LISTE DES CONGÉS</h2>
        
        <div class="d-flex gap-2">
            <a href="{{ route('conges.vider') }}" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm" 
               onclick="return confirm('Voulez-vous vraiment supprimer tous les congés ?')">
                <i class="bi bi-trash3 me-1"></i> Vider la liste
            </a>
        </div>
    </div>

    {{-- Notifications --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4">Employé</th>
                            <th>Période</th>
                            <th class="text-center">Type / Jours</th>
                            <th class="text-center">Statut</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($conges as $conge)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2 bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:35px; height:35px; background: #eef2ff;">
                                            {{ strtoupper(substr($conge->employee?->nom ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block text-dark">{{ $conge->employee?->nom ?? '-' }}</span>
                                            <small class="text-muted">{{ $conge->employee?->prenom ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <span class="d-block"><i class="bi bi-calendar-event text-muted me-1"></i>Du {{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }}</span>
                                        <span class="d-block text-muted">Au {{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border fw-normal mb-1">{{ $conge->type }}</span>
                                    <div class="small fw-bold text-primary">{{ $conge->nombre ?? '0' }} jour(s)</div>
                                </td>
                                <td class="text-center">
                                    @if($conge->statut === 'en_attente')
                                        <span class="badge bg-warning-soft text-warning px-3 py-2 rounded-pill" style="background: #fffbeb;">En attente</span>
                                    @elseif($conge->statut === 'valide')
                                        <span class="badge bg-success-soft text-success px-3 py-2 rounded-pill" style="background: #f0fdf4;">Validé</span>
                                    @else
                                        <span class="badge bg-danger-soft text-danger px-3 py-2 rounded-pill" style="background: #fef2f2;">Refusé</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        @if($conge->statut === 'en_attente')
                                            {{-- Bouton Valider --}}
                                            <form action="{{ route('conges.valider', $conge->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success rounded-start-pill px-3 btn-valider-conge" title="Valider">
                                                    <i class="bi bi-check-lg"></i> <span class="d-none d-lg-inline">Valider</span>
                                                </button>
                                            </form>

                                            {{-- Bouton Refuser --}}
                                            <form action="{{ route('conges.refuser', $conge->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="commentaire_validation" value="Refus automatique">
                                                <button type="submit" class="btn btn-sm btn-danger rounded-end-pill px-3 btn-refuser" title="Refuser">
                                                    <i class="bi bi-x-lg"></i> <span class="d-none d-lg-inline">Refuser</span>
                                                </button>
                                            </form>

                                        @elseif($conge->statut === 'valide')
                                            <a href="{{ route('conges.pdf', $conge->id) }}" class="btn btn-outline-danger btn-sm rounded-pill shadow-none">
                                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF
                                            </a>
                                        @else
                                            <button class="btn btn-light btn-sm rounded-pill disabled border" title="Aucune action">
                                                <i class="bi bi-slash-circle"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted small">Aucun congé enregistré.</td>
                                    </tr>
                                @endforelse
                                {{-- Modaux de refus --}}
                                @foreach($conges as $conge)
                                <div class="modal fade" id="refuserModal{{ $conge->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            <form method="POST" action="{{ route('conges.refuser', $conge->id) }}">
                                                @csrf
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold text-danger">Refuser la demande</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body py-4">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Motif du refus</label>
                                                        <textarea name="commentaire_validation" class="form-control bg-light border-0" rows="4" placeholder="Indiquez ici la raison du refus..." required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-danger rounded-pill px-4">Confirmer le refus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $conges->links('pagination::bootstrap-5') }}
    </div>
</div>


<style>
    /* Amélioration visuelle et responsive */
    body { background-color: #f8fafc; }
    .table thead th { font-size: 0.8rem; letter-spacing: 0.05rem; text-transform: uppercase; border-top: none; }
    .table-hover tbody tr:hover { background-color: #f8fbff; }
    
    /* Responsive : Cache les infos moins cruciales sur petit écran si besoin */
    @media (max-width: 768px) {
        .table-responsive { border: 0; }
        .btn-sm { padding: 0.4rem 0.6rem; }
    }

    /* Styles pour les badges soft colors */
    .bg-warning-soft { color: #854d0e !important; }
    .bg-success-soft { color: #166534 !important; }
    .bg-danger-soft { color: #991b1b !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // SweetAlert pour Valider
    document.querySelectorAll('.btn-valider-conge').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: 'Valider ce congé ?',
                text: "Le solde sera déduit automatiquement.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Oui, valider',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if(result.isConfirmed){
                    form.submit();
                }
            });
        });
    });

    // SweetAlert pour Refuser
    document.querySelectorAll('.btn-refuser').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: 'Refuser ce congé ?',
                text: "Cette action ne pourra pas être annulée.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, refuser',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if(result.isConfirmed){
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection