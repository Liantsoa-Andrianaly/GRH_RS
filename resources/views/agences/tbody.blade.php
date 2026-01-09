@extends('layouts.template')

@section('content')

@forelse ($agences as $agence)
    <tr>
        <td>{{ $agence->code }}</td>
        <td>{{ $agence->nom }}</td>
        <td>{{ $agence->abreviation }}</td>
        <td>{{ $agence->siege }}</td>
        <td>{{ $agence->date_creation }}</td>
        <td>{{ $agence->mapping }}</td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted">Aucune agence trouvée</td>
    </tr>
@endforelse
@endsection