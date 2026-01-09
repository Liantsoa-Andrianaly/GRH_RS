@extends('layouts.template')

@section('content')

<h2 class="mb-4 text-center text-primary">DETAILS DU SERVICE</h2>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td>{{ $service->id }}</td>
    </tr>
    <tr>
        <th>Nom du service</th>
        <td>{{ $service->nom }}</td>
    </tr>
    <tr>
        <th>Postes liés</th>
        <td>
            @if($service->postes->count())
                <ul>
                    @foreach($service->postes as $poste)
                        <li>{{ $poste->nom }}</li>
                    @endforeach
                </ul>
            @else
                <span class="text-muted">Aucun poste</span>
            @endif
        </td>
    </tr>
</table>

<a href="{{ route('services.index') }}" class="btn btn-secondary">Retour</a>
<a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning">Modifier</a>

@endsection
