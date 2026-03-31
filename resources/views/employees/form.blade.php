@extends('layouts.template')

@section('content')

<div class="container">
    <h2 class="text-center mb-4" style="color:#043275;">
        {{ isset($employee) ? 'MODIFIER UN(E) EMPLOYÉ(E)' : 'AJOUTER UN(E) EMPLOYÉ(E)' }}
    </h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}" method="POST">
        @csrf

        @if(isset($employee))
            @method('PUT')
        @endif

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control"
                    value="{{ old('nom', $employee->nom ?? '') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Prénom</label>
                <input type="text" name="prenom" class="form-control"
                    value="{{ old('prenom', $employee->prenom ?? '') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Sexe</label>
                <select name="sexe" class="form-control">
                    <option value="">Sélectionnez</option>
                    <option value="Homme" {{ old('sexe', $employee->sexe ?? '') == 'Homme' ? 'selected' : '' }}>Homme</option>
                    <option value="Femme" {{ old('sexe', $employee->sexe ?? '') == 'Femme' ? 'selected' : '' }}>Femme</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $employee->email ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Téléphone</label>
                <input type="text" name="telephone" class="form-control"
                    value="{{ old('telephone', $employee->telephone ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Adresse</label>
                <input type="text" name="adresse" class="form-control"
                    value="{{ old('adresse', $employee->adresse ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Poste</label>
                <select name="poste_id" class="form-control">
                    @foreach($services as $service)
                        <optgroup label="{{ $service->nom }}">
                            @foreach($service->postes as $poste)
                                <option value="{{ $poste->id }}"
                                    {{ old('poste_id', $employee->poste_id ?? '') == $poste->id ? 'selected' : '' }}>
                                    {{ $poste->nom }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Agence</label>
                <select name="agence_id" class="form-control">
                    @foreach($agences as $agence)
                        <option value="{{ $agence->id }}"
                            {{ old('agence_id', $employee->agence_id ?? '') == $agence->id ? 'selected' : '' }}>
                            {{ $agence->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- DATE NAISSANCE --}}
            <div class="col-md-6 mb-3">
                <label>Date de naissance</label>
                <input type="date" name="date_naissance" class="form-control"
                    value="{{ old('date_naissance', isset($employee) && $employee->date_naissance ? $employee->date_naissance->format('Y-m-d') : '') }}">
            </div>

            {{-- LIEU --}}
            <div class="col-md-6 mb-3">
                <label>Lieu de naissance</label>
                <input type="text" name="lieu_naissance" class="form-control"
                    value="{{ old('lieu_naissance', $employee->lieu_naissance ?? '') }}">
            </div>

             {{-- fiplome --}}
            <div class="col-md-6 mb-3">
                <label>Diplôme</label>
                <input type="text" name="diplome" class="form-control"
                    value="{{ old('diplome', $employee->diplome ?? '') }}">
            </div>

            {{-- DATE EMBAUCHE --}}
            <div class="col-md-6 mb-3">
                <label>Date d’embauche</label>
                <input type="date" name="date_embauche" class="form-control"
                    value="{{ old('date_embauche', isset($employee) && $employee->date_embauche ? $employee->date_embauche->format('Y-m-d') : '') }}">
            </div>

            {{-- SALAIRE --}}
            <div class="col-md-6 mb-3">
                <label>Salaire</label>
                <input type="number" name="salaire_base" class="form-control"
                    value="{{ old('salaire_base', $employee->salaire_base ?? 0) }}">
            </div>

        </div>

        <div class="text-center">
            <button class="btn btn-primary">
                {{ isset($employee) ? 'Mettre à jour' : 'Enregistrer' }}
            </button>
        </div>

    </form>
</div>

@endsection