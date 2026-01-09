@extends('layouts.template')

@section('content')

    <h2 class="mb-4 text-center text-primary">MODIFIER POINTAGE</h2>

    <form action="{{ route('pointages.update', $pointage) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Employé</label>
            <select name="employee_id" class="form-control" required>
                @foreach($employees as $e)
                    <option value="{{ $e->id }}" @if($pointage->employee_id == $e->id) selected @endif>{{ $e->nom }} {{ $e->prenom ?? '' }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Entrée</label>
            <input type="datetime-local" name="entree" class="form-control" value="{{ optional($pointage->entree)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="form-group">
            <label>Sortie (optionnel)</label>
            <input type="datetime-local" name="sortie" class="form-control" value="{{ optional($pointage->sortie)->format('Y-m-d\TH:i') }}">
        </div>

        <button class="btn btn-success">Sauvegarder</button>
        <a href="{{ route('pointages.index') }}" class="btn btn-secondary">Annuler</a>
    </form>

@endsection