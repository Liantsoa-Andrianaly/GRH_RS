@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <h4>Modifier le type de prélèvement</h4>

    <form method="POST" action="{{ route('types_prelevements.update', $types_prelevement) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nom complet</label>
            <input type="text" name="nom_complet" class="form-control"
                   value="{{ $types_prelevement->nom_complet }}" required>
        </div>

        <div class="mb-3">
            <label>Abréviation</label>
            <input type="text" name="abreviation" class="form-control"
                   maxlength="20"
                   value="{{ $types_prelevement->abreviation }}" required>
        </div>

        <div class="mb-3">
            <label>Type de valeur</label>
            <select name="type_valeur" class="form-control" required>
                <option value="montant" {{ $types_prelevement->type_valeur == 'montant' ? 'selected' : '' }}>
                    Montant fixe (MGA)
                </option>
                <option value="pourcentage" {{ $types_prelevement->type_valeur == 'pourcentage' ? 'selected' : '' }}>
                    Pourcentage (%)
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label>Valeur</label>
            <input type="number" step="0.01" name="valeur" class="form-control"
                   value="{{ $types_prelevement->valeur }}" required>
        </div>

        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('types_prelevements.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
