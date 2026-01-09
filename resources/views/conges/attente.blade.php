@extends('layouts.template')

@section('content')

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Congés en attente</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Employé</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Type</th>
                        <th>Motif</th>
                        <th>Total jours</th> <!-- Nouvelle colonne -->
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($conges as $conge)
                        <tr>
                            <td>{{ $conge->employe->nom }} {{ $conge->employe->prenom }}</td>
                            <td>{{ $conge->date_debut }}</td>
                            <td>{{ $conge->date_fin }}</td>
                            <td>{{ ucfirst($conge->type) }}</td>
                            <td>{{ $conge->motif }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($conge->date_debut)->diffInDays(\Carbon\Carbon::parse($conge->date_fin)) + 1 }}
                            </td>
                            <td>
                                <span class="badge bg-warning text-dark">En attente</span>
                            </td>
                            <td class="text-center">
                                <!-- Bouton Valider -->
                                <form action="{{ route('conges.valider', $conge->id) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Valider
                                    </button>
                                </form>

                                <!-- Bouton Refuser -->
                                <form action="{{ route('conges.refuser', $conge->id) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Refuser
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection
