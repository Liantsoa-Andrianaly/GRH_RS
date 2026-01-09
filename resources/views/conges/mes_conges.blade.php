@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <h4>Mes congés</h4>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Début</th>
                <th>Fin</th>
                <th>Statut</th>
                <th>Jours</th>
                <th>Solde restant</th>
            </tr>
        </thead>
        <tbody>
        @foreach($conges as $conge)
            <tr>
                <td>{{ $conge->date_debut }}</td>
                <td>{{ $conge->date_fin }}</td>
                <td>{{ $conge->statut }}</td>
                <td>{{ $conge->nombre ?? '-' }}</td>
                <td>{{ $conge->solde_restant ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
