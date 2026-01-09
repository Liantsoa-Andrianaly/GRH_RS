    @extends('layouts.template')

    @section('content')

    <form action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($employee))
            @method('PUT')
        @endif

    <div class="row">

        {{-- NOM --}}
        <div class="col-md-6 mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control"
                value="{{ old('nom', $employee->nom ?? '') }}" required>
        </div>

        {{-- PRENOM --}}
        <div class="col-md-6 mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control"
                value="{{ old('prenom', $employee->prenom ?? '') }}" required>
        </div>

        {{-- SEXE --}}
        <div class="col-md-6 mb-3">
            <label>Sexe</label>
            <select name="sexe" class="form-control">
                <option value=""> Sélectionnez </option>
                <option value="Homme" {{ old('sexe', $employee->sexe ?? '') == 'Homme' ? 'selected' : '' }}>Homme</option>
                <option value="Femme" {{ old('sexe', $employee->sexe ?? '') == 'Femme' ? 'selected' : '' }}>Femme</option>
            </select>
        </div>

        {{-- STATUT MATRIMONIAL --}}
        <div class="col-md-6 mb-3">
            <label>Statut Matrimonial</label>
            <select name="statut_matrimonial" class="form-control">
                <option value="">Sélectionnez</option>
                <option value="Célibataire" {{ old('statut_matrimonial', $employee->statut_matrimonial ?? '') == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                <option value="Marié(e)" {{ old('statut_matrimonial', $employee->statut_matrimonial ?? '') == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                <option value="Divorcé(e)" {{ old('statut_matrimonial', $employee->statut_matrimonial ?? '') == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                <option value="Veuf(ve)" {{ old('statut_matrimonial', $employee->statut_matrimonial ?? '') == 'Veuf(ve)' ? 'selected' : '' }}>Veuf(ve)</option>
            </select>
        </div>

        {{-- EMAIL --}}
        <div class="col-md-6 mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                value="{{ old('email', $employee->email ?? '') }}">
        </div>

        {{-- TELEPHONE --}}
        <div class="col-md-6 mb-3">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control"
                value="{{ old('telephone', $employee->telephone ?? '') }}">
        </div>

        {{-- ADRESSE --}}
        <div class="col-md-6 mb-3">
            <label>Adresse</label>
            <input type="text" name="adresse" class="form-control"
                value="{{ old('adresse', $employee->adresse ?? '') }}">
        </div>

        {{-- DIPLOME --}}
        <div class="col-md-6 mb-3">
            <label>Diplôme</label>
            <select name="diplome" class="form-control" id="diplomeSelect">
                <option value="">-- Sélectionnez --</option>
                <option value="BEPC" {{ old('diplome', $employee->diplome ?? '') == 'BEPC' ? 'selected' : '' }}>BEPC</option>
                <option value="BAC" {{ old('diplome', $employee->diplome ?? '') == 'BAC' ? 'selected' : '' }}>BAC</option>
                <option value="Licence" {{ old('diplome', $employee->diplome ?? '') == 'Licence' ? 'selected' : '' }}>Licence</option>
                <option value="Master" {{ old('diplome', $employee->diplome ?? '') == 'Master' ? 'selected' : '' }}>Master</option>
                <option value="Doctorat" {{ old('diplome', $employee->diplome ?? '') == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                <option value="Autre" {{ !in_array(old('diplome', $employee->diplome ?? ''), ['BEPC','BAC','Licence','Master','Doctorat']) ? 'selected' : '' }}>Autre</option>
            </select>
            <input type="text"
            name="diplome_autre"
            id="diplomeAutre"
            class="form-control mt-2"
            placeholder="Précisez"
            value="{{ !in_array(old('diplome', $employee->diplome ?? ''), ['BEPC','BAC','Licence','Master','Doctorat']) 
                            ? old('diplome', $employee->diplome ?? '') 
                            : '' }}"
            style="display: none;">
        </div>

        {{-- POSTE --}}
        <div class="col-md-6 mb-3">
            <label>Poste</label>
            <select name="poste_id" class="form-control" required>
                <option value="">-- Choisir --</option>
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

        {{-- AGENCE --}}
        <div class="col-md-6 mb-3">
            <label>Agence</label>
            <select name="agence_id" class="form-control" required>
                <option value="">-- Sélectionner --</option>
                @foreach ($agences as $agence)
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
                value="{{ old('date_naissance', $employee->date_naissance ?? '') }}">
        </div>

        {{-- LIEU NAISSANCE --}}
        <div class="col-md-6 mb-3">
            <label>Lieu de naissance</label>
            <input type="text" name="lieu_naissance" class="form-control"
                value="{{ old('lieu_naissance', $employee->lieu_naissance ?? '') }}">
        </div>

        {{-- CIN --}}
        <div class="col-md-6 mb-3">
            <label>CIN</label>
            <input type="text" name="cin" class="form-control" 
                value="{{ old('cin', $employee->cin ?? '') }}">
        </div>

        {{-- Permis de conduire --}}
        <div class="col-md-6 mb-3">
            <label>Permis de conduire</label>
            <select name="permis_de_conduire" class="form-control" id="permisSelect">
                <option value="">-- Sélectionnez --</option>
                <option value="A" {{ old('permis_de_conduire', $employee->permis_de_conduire ?? '') == 'Rien' ? 'selected' : '' }}>Rien</option>
                <option value="A" {{ old('permis_de_conduire', $employee->permis_de_conduire ?? '') == 'A' ? 'selected' : '' }}>Permis A</option>
                <option value="B" {{ old('permis_de_conduire', $employee->permis_de_conduire ?? '') == 'B' ? 'selected' : '' }}>Permis B</option>
                <option value="C" {{ old('permis_de_conduire', $employee->permis_de_conduire ?? '') == 'C' ? 'selected' : '' }}>Permis C</option>
                <option value="D" {{ old('permis_de_conduire', $employee->permis_de_conduire ?? '') == 'D' ? 'selected' : '' }}>Permis D</option>
                <option value="Autre" {{ !in_array(old('permis_de_conduire', $employee->permis_de_conduire ?? ''), ['A','B','C','D']) ? 'selected' : '' }}>Autre</option>
            </select>

            <input type="text" 
            class="form-control mt-2"
            name="permis_de_conduire_autre"
            id="permisAutre"
            placeholder="Précisez"
            value="{{ !in_array(old('permis_de_conduire', $employee->permis_de_conduire ?? ''), ['A','B','C','D']) 
                            ? old('permis_de_conduire', $employee->permis_de_conduire ?? '') 
                            : '' }}"
            style="display: none;">
        </div>

        {{-- Photo --}}
        <div class="col-md-6 mb-3">
            <label>Photo</label>
            <input type="file" name="photo" class="form-control">
            @if(isset($employee) && $employee->photo)
                <img src="{{ asset('storage/'.$employee->photo) }}" width="100" class="mt-2">
            @endif
        </div>

        {{-- Nationalité --}}
        <div class="col-md-6 mb-3">
            <div class="col-md-6 mb-3">
            <label>Nationalité</label>
            <select name="nationalite" class="form-control">
                <option value="">-- Sélectionnez --</option>
                <option value="Malagasy" {{ old('nationalite', $employee->nationalite ?? '') == 'Malagasy' ? 'selected' : '' }}>Malagasy</option>
                <option value="Française" {{ old('nationalite', $employee->nationalite ?? '') == 'Française' ? 'selected' : '' }}>Française</option>
                <option value="Comorienne" {{ old('nationalite', $employee->nationalite ?? '') == 'Comorienne' ? 'selected' : '' }}>Comorienne</option>
                <option value="Mauricienne" {{ old('nationalite', $employee->nationalite ?? '') == 'Mauricienne' ? 'selected' : '' }}>Mauricienne</option>
                <option value="Autre">Autre</option>
            </select>
    </div>
        </div>

    

        {{-- Status --}}
        <div class="col-md-6 mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="actif" {{ (old('status', $employee->status ?? '') == 'actif') ? 'selected' : '' }}>Actif</option>
                <option value="demissionnaire" {{ (old('status', $employee->status ?? '') == 'demissionnaire') ? 'selected' : '' }}>Démissionnaire</option>
                <option value="licencie" {{ (old('status', $employee->status ?? '') == 'licencie') ? 'selected' : '' }}>Licencié</option>
                <option value="fin_cdd" {{ (old('status', $employee->status ?? '') == 'fin_cdd') ? 'selected' : '' }}>Fin CDD</option>
            </select>
        </div>

        {{-- Date embauche --}}
        <div class="col-md-6 mb-3">
            <label>Date d'embauche</label>
            <input type="date" name="date_embauche" class="form-control" 
                value="{{ old('date_embauche', $employee->date_embauche ?? '') }}">
        </div>


    </div>
    {{-- SALAIRE DE BASE --}}
    <div class="col-md-6 mb-3">
        <label>Salaire de base (MGA)</label>
        <input type="number" name="salaire_base" class="form-control"
            value="{{ old('salaire_base', $employee->salaire_base ?? 0) }}" required min="0">
        @error('salaire_base')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">
            {{ isset($employee) ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
    </div>





    </form>

    <script>
        const permis = document.getElementById('permisSelect');
        const permisAutre = document.getElementById('permisAutre');

        if (permis.value === "Autre") {
            permisAutre.style.display = "block";
        }

        permis.addEventListener('change', function() {
            permisAutre.style.display = (this.value === "Autre") ? "block" : "none";
        });

        const diplome = document.getElementById('diplomeSelect');
        const diplomeAutre = document.getElementById('diplomeAutre');

        if (diplome.value === "Autre") {
            diplomeAutre.style.display = "block";
        }

        diplome.addEventListener('change', function() {
            diplomeAutre.style.display = (this.value === "Autre") ? "block" : "none";
        });
    </script>

    @endsection
