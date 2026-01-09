@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <h4>Solde des congés</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employé</th>
                <!--th>Congés annuelle</th-->
                <th>Congés pris</th>
                <th>Solde restant</th>
            </tr>
        </thead>
        <tbody>
        @foreach($employees as $employee)
            @php
                $pris = $employee->conges->sum('nombre');
                $solde = 30 - $pris;
            @endphp
            <tr>
                <td>{{ $employee->nom }} {{ $employee->prenom }}</td>
                <!--td>30 jours</td-->
                <td>{{ $pris }} jours</td>
                <td>{{ max($solde, 0) }} jours</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
