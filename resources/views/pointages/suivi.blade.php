@extends('layouts.template')

@section('content')
<h2>Historique complet des présences</h2>

{{-- Formulaire pour filtrer par date --}}
<form method="GET" action="{{ route('pointages.suivi') }}" class="mb-3 d-flex align-items-center gap-2">
    <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}" style="width: 200px;">
    <button type="submit" class="btn btn-primary btn-sm">Afficher</button>
</form>

@foreach($dates as $date)
    {{-- Titre de la date --}}
    <h3 class="mt-4">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h3>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Présence</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->nom }} {{ $employee->prenom }}</td>
                    <td>
                        @if(isset($presences[$date][$employee->id]) && $presences[$date][$employee->id])
                            <span class="text-success">Présent</span>
                        @else
                            <span class="text-danger">Absent</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach

{{-- Pagination --}}
<div class="d-flex justify-content-center">
    {{ $dates->links('pagination::simple-bootstrap-5') }}
</div>


@endsection
