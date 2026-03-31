@extends('layouts.template')

@section('content')

<style>
    body {
        background-color: #f4f6f9 !important;
    }

    .profile-header {
        background: linear-gradient(135deg, #283278ff, #5c6bc0);
        padding: 25px;
        border-radius: 10px 10px 0 0;
        color: white;
    }

    .profile-header h3 {
        margin: 0;
    }

    .section-title {
        color: #3949ab;
        font-weight: 700;
        margin-top: 25px;
    }

    .btn-retour {
        background-color: #3949ab;
        border: none;
        padding: 10px 25px;
        border-radius: 6px;
        color: white;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-retour:hover {
        background-color: #283593;
    }

</style>

<div class="container mt-4">
    <div class="card shadow border-0">

        {{-- HEADER COLORÉ --}}
        <div class="profile-header d-flex align-items-center">
            <!-- <img src="{{ $employee->photo ? asset('storage/' . $employee->photo) : asset('images/photo-placeholder.png') }}"
                 class="rounded-circle me-3"
                 width="110" height="110"
                 style="object-fit: cover; border: 3px solid white;"> -->

            <div>
                <h3>{{ $employee->nom }} {{ $employee->prenom }}</h3>
                <p class="mb-0">
                    {{ $employee->poste->nom ?? '-' }} • {{ $employee->agence->nom ?? '-' }}
                </p>
            </div>
        </div>

        <div class="card-body">

            {{-- INFOS PERSONNELLES --}}
            <h5 class="section-title">Informations personnelles</h5>
            <div class="row mt-2">
                <div class="col-md-6">
                    <p><strong>Email : </strong>{{ $employee->email ?? '-' }}</p>
                    <p><strong>Téléphone : </strong>{{ $employee->telephone ?? '-' }}</p>
                    <p><strong>Adresse : </strong>{{ $employee->adresse ?? '-' }}</p>
                    <p>
                        <strong>Date et lieu de naissance :</strong>
                        {{ $employee->date_naissance ? $employee->date_naissance->format('d/m/Y') : '-' }}
                        à {{ $employee->lieu_naissance ?? '-' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <p><strong>Nationalité : </strong>{{ $employee->nationalite ?? '-' }}</p>
                    <p><strong>CIN : </strong>{{ $employee->cin ?? '-' }}</p>
                    <p><strong>Permis : </strong>{{ $employee->permis_de_conduire == 1 ? 'Rien' : ($employee->permis_de_conduire ?? '-') }}</p>
                    <p><strong>Sexe : </strong>{{ $employee->sexe ?? '-' }}</p>
                </div>
            </div>
            <hr>

            {{-- POSTE --}}
            <h5 class="section-title">Poste et Structures</h5>
            <p><strong>Service : </strong>{{ $employee->poste->service->nom ?? '-' }}</p>
            <p><strong>Poste : </strong>{{ $employee->poste->nom ?? '-' }}</p>
            <p><strong>Agence : </strong>{{ $employee->agence->nom ?? '-' }}</p>
            <p><strong>Diplôme : </strong>{{ $employee->diplome ?? '-' }}</p>
            <hr>

            {{-- ADMINISTRATIF --}}
            <h5 class="section-title">Informations administratives</h5>
            <div class="alert alert-info">
                <strong>Solde de congé : </strong> {{ $employee->solde_conge ?? 0 }} jour(s)
            </div>

            <p><strong>Status : </strong>{{ ucfirst($employee->status ?? '-') }}</p>
            <p><strong>Salaire de base : </strong>{{ $employee->salaire_base ?? 0 }} MGA</p>

            
            <p>
                <strong>Date d’embauche :</strong>
                {{ $employee->date_embauche ? $employee->date_embauche->format('d/m/Y') : '-' }}
            </p>
            {{-- BOUTON RETOUR --}}
            <div class="mt-4 text-end">
                <a href="{{ route('employees.index') }}" class="btn btn-retour">← Retour</a>
            </div>

        </div>

    </div>
</div>

@endsection