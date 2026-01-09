@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary">DEMANDE DE CONGE</h2>

    <form method="POST" action="{{ route('conges.store') }}">
        @csrf

        <div class="mb-3">
            <label>Employé</label>
            <select name="employee_id" class="form-control" required>
                <option value="">-- choisir --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">
                        {{ $employee->nom }} {{ $employee->prenom }}
                    </option>
                @endforeach
            </select>

        </div>

        <div class="mb-3">
            <label>Date début</label>
            <input type="date" name="date_debut" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Date fin</label>
            <input type="date" name="date_fin" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control">
                <option value="annuelle">Congé annuelle</option>
                <option value="maternité">Congé de maternité</option>
                <option value="paternité">Congé de paternité</option>
                <option value="exceptionnelle">Congé exceptionnelle</option>
                <option value="maladie">Congé maladie</option>

            </select>

        </div>

        <div class="mb-3">
            <label>Motif</label>
            <textarea name="motif" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Envoyer</button>
    </form>
</div>
@endsection
