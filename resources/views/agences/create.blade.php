@extends('layouts.template')

@section('content')
<div class="container mt-4">
        <h2 class="mb-4 text-center text-primary">AJOUTER UNE AGENCE</h2>


    <form action="{{ route('agences.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Code</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Abréviation</label>
            <input type="text" name="abreviation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Siège</label>
            <input type="text" name="siege" class="form-control">
        </div>

        <div class="mb-3">
            <label>Date de création</label>
            <input type="date" name="date_creation" class="form-control">
        </div>

        <div class="mb-3">
            <label>Mapping</label>
            <input type="text" name="mapping" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('agences.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
