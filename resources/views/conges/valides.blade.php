@extends('layouts.template')

@section('content')

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Congés validés</h4>
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
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($conges as $conge)
                        <tr>
                            <td>{{ $conge->employee->nom }} {{ $conge->employee->prenom }}</td>
                            <td>{{ $conge->date_debut }}</td>
                            <td>{{ $conge->date_fin }}</td>
                            <td>{{ ucfirst($conge->type) }}</td>
                            <td>{{ $conge->motif }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($conge->date_debut)->diffInDays(\Carbon\Carbon::parse($conge->date_fin)) + 1 }} <!-- Calcul total jours -->
                            </td>
                            <td>
                                <span class="badge bg-success">Validé</span>
                            </td>
                            <td>
                                <a href="{{ route('conges.pdf', $conge->id) }}" class="btn btn-sm btn-primary">
                                    Télécharger
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
