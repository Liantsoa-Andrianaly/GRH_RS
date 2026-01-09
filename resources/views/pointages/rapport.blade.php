<!--div class="container">

@extends('layouts.template')

@section('content')

    <h2>Rapport des heures travaillées</h2>

    <form method="GET" action="{{ route('pointages.rapport') }}">
        <label>Date début:</label>
        <input type="date" name="date_debut" value="{{ request('date_debut') }}">
        <label>Date fin:</label>
        <input type="date" name="date_fin" value="{{ request('date_fin') }}">
        <button type="submit">Filtrer</button>
    </form>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Date</th>
                <th>Arrivée</th>
                <th>Départ</th>
                <th>Heures travaillées</th>
            </tr>
        </thead>
        <tbody>
           @foreach($pointages as $p)
            @php
                $heures_travaillees = 0;
                if ($p->heure_arrivee && $p->heure_depart) {
                    $heures_travaillees = (strtotime($p->heure_depart) - strtotime($p->heure_arrivee)) / 3600;
                }
            @endphp
            <tr>
                
                <td>{{ $p->employee ? $p->employee->nom . ' ' . $p->employee->prenom : 'Employé supprimé' }}</td>
                <td>{{ $p->date }}</td>
                <td>{{ $p->heure_arrivee ?? '-' }}</td>
                <td>{{ $p->heure_depart ?? '-' }}</td>
                <td>{{ number_format($heures_travaillees, 2) }} h</td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endsection
