@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <h4>Nouveau type de prélèvement</h4>

    <form method="POST" action="{{ route('types_prelevements.store') }}">
        @csrf

        <div class="mb-3">
            <label>Nom complet</label>
            <input type="text" name="nom_complet" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Abréviation</label>
            <input type="text" name="abreviation" class="form-control" maxlength="20" required>
        </div>

        <div class="mb-3">
            <label>Type de valeur</label>
            <select name="type_valeur" class="form-control" required>
                <option value="">-- Choisir --</option>
                <option value="montant">Montant fixe (MGA)</option>
                <option value="pourcentage">Pourcentage (%)</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Valeur</label>
            <input type="number" step="0.01" name="valeur" class="form-control" required>
        </div>

        <button class="btn btn-success">Enregistrer</button>
        <a href="{{ route('types_prelevements.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
