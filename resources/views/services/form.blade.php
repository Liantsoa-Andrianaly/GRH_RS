@extends('layouts.template')

@section('content')

<h2>{{ $service ? 'Modifier le service' : 'Créer un service' }}</h2>

<form action="{{ $service ? route('services.update', $service->id) : route('services.store') }}" method="POST">
    @csrf
    @if($service)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label>Nom du service</label>
        <input type="text" name="nom" class="form-control"
               value="{{ old('nom', $service->nom ?? '') }}" required>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ $service ? 'Mettre à jour' : 'Enregistrer' }}
    </button>
</form>

@endsection
