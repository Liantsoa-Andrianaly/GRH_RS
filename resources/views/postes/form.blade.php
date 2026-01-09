@extends('layouts.template')

@section('content')
<h2 class="mb-4 text-center text-primary">{{ $poste ? 'Modifier' : 'CREER ' }} UN POSTE</h2>


<form action="{{ $poste ? route('postes.update', $poste->id) : route('postes.store') }}" method="POST">
    @csrf
    @if($poste)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label>Nom du poste</label>
        <input type="text" name="nom" class="form-control" value="{{ old('nom', $poste->nom ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label>Service</label>
        <select name="service_id" class="form-control" required>
            <option value="">-- Sélectionnez un service --</option>
            @foreach($services as $service)
                <option value="{{ $service->id }}"
                    {{ old('service_id', $poste->service_id ?? '') == $service->id ? 'selected' : '' }}>
                    {{ $service->nom }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">{{ $poste ? 'Mettre à jour' : 'Enregistrer' }}</button>
</form>
@endsection
