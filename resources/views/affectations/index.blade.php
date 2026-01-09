@extends('layouts.template')

@section('content')
<style>
    .employee-item {
        transition: background-color 0.3s, color 0.3s;
        cursor: pointer;
    }

    .employee-item.active {
        background-color: #7fc3d8ff !important;
        color: white !important;
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary">AFFECTATIONS DES EMPLOYES</h2>

    <div class="row">
        <!-- Liste des employés -->
        <div class="col-md-5">
            <input type="text" class="form-control mb-3" id="search" placeholder="Rechercher (matricule / nom / prénom)...">
            <div class="list-group" id="employee-list">
                @foreach($employees as $emp)
                    <button class="list-group-item list-group-item-action employee-item" data-id="{{ $emp->id }}">
                        <strong>{{ $emp->matricule }}</strong> — {{ $emp->nom }} {{ $emp->prenom }}
                        <br>
                        <small class="text-muted">
                            Poste : {{ $emp->poste->nom ?? 'Aucun' }}
                            @if($emp->poste && $emp->poste->service)
                                (Service : {{ $emp->poste->service->nom }})
                            @endif
                            <br>
                            Agence : {{ $emp->agence->nom ?? 'Aucune' }}
                        </small>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Formulaire + Historique -->
        <div class="col-md-7">
            <div class="card shadow" id="details-card" style="display:none;">
                <div class="card-header bg-primary text-white">
                    <h5 id="employee-name" class="mb-0">Informations Employé</h5>
                </div>
                <div class="card-body">
                    <p><strong>Matricule :</strong> <span id="emp-matricule"></span></p>
                    <p><strong>Poste actuel :</strong> <span id="emp-poste-ancien"></span></p>
                    <p><strong>Agence actuelle :</strong> <span id="emp-agence-ancien"></span></p>
                    <p><strong>Date dernière affectation :</strong> <span id="emp-date"></span></p>

                    <hr>

                    <form id="affectation-form">@csrf
                        <input type="hidden" id="employee_id" name="employee_id">

                        <div class="mb-3">
                            <label class="form-label"><strong>Nouveau poste</strong></label>
                            <select class="form-control" name="poste_nouveau_id" id="poste_nouveau_id" required>
                                <option value="">-- Sélectionner un poste --</option>
                                @foreach($postes as $p)
                                    <option value="{{ $p->id }}">{{ $p->nom }} @if($p->service) ({{ $p->service->nom }}) @endif</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Nouvelle agence</strong></label>
                            <select class="form-control" name="agence_nouveau_id" id="agence_nouveau_id" required>
                                <option value="">-- Sélectionner une agence --</option>
                                @foreach($agences as $a)
                                    <option value="{{ $a->id }}">{{ $a->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Valider l'affectation</button>
                    </form>

                    <div id="success-message" class="alert alert-success mt-3" style="display:none;">
                        Affectation enregistrée avec succès !
                    </div>

                    <!-- Historique -->
                    <div class="card mt-4">
                        <div class="card-header bg-info text-white"><strong>Historique des Affectations</strong></div>
                        <div class="card-body" id="historique-container">
                            <p class="text-muted">Cliquez un employé pour voir son historique…</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // 🔎 Recherche employé
    document.getElementById('search').addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll('.employee-item').forEach(item => {
            item.style.display = item.innerText.toLowerCase().includes(value) ? "block" : "none";
        });
    });

    // 🖱 Clique sur employé
    const employeeItems = document.querySelectorAll('.employee-item');
    employeeItems.forEach(item => {
        item.addEventListener('click', () => {
            employeeItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');

            const id = item.dataset.id;

            fetch(`/affectations/${id}`)
                .then(res => res.json())
                .then(data => {
                    const emp = data.employee;
                    const aff = data.affectation;

                    document.getElementById('details-card').style.display = 'block';
                    document.getElementById('employee_id').value = emp.id;
                    document.getElementById('employee-name').innerText = emp.nom + " " + emp.prenom;
                    document.getElementById('emp-matricule').innerText = emp.matricule;
                    document.getElementById('emp-poste-ancien').innerText = emp.poste ? emp.poste.nom : "Aucun poste";
                    document.getElementById('emp-agence-ancien').innerText = emp.agence ? emp.agence.nom : "Aucune agence";
                    document.getElementById('poste_nouveau_id').value = "";
                    document.getElementById('agence_nouveau_id').value = "";
                    document.getElementById('success-message').style.display = 'none';

                    if(aff){
                        const date = new Date(aff.date_creation);
                        document.getElementById('emp-date').innerText = date.toLocaleString('fr-FR', { timeZone: 'Indian/Antananarivo' });
                    } else {
                        document.getElementById('emp-date').innerText = "Aucune affectation";
                    }

                    loadHistorique(emp.id, emp.nom + " " + emp.prenom);
                });
        });
    });

    // 🟢 Valider affectation
    document.getElementById('affectation-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('/affectations', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    document.getElementById('success-message').style.display = 'block';
                    document.getElementById('emp-poste-ancien').innerText = data.employee.poste ? data.employee.poste.nom : "Aucun poste";
                    document.getElementById('emp-agence-ancien').innerText = data.employee.agence ? data.employee.agence.nom : "Aucune agence";

                    loadHistorique(data.employee.id, data.employee.nom + " " + data.employee.prenom);
                }
            });
    });

    // 🔄 Historique
    function loadHistorique(employeeId, employeeName, page = 1){
        fetch(`/affectations/historique/${employeeId}?page=${page}`)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                let html = "";
                if(data.data.length === 0){
                    html = "<p class='text-muted'>Aucun historique pour cet employé.</p>";
                } else {
                    data.data.forEach(item => {
                        const date = new Date(item.date_creation);
                        html += `<div class="border-bottom pb-2 mb-2">
                            <strong>Employé :</strong> ${employeeName}<br>
                            <strong>Ancien poste :</strong> ${item.poste_ancien_id ? item.poste_ancien.nom : '—'}<br>
                            <strong>Nouveau poste :</strong> ${item.poste_nouveau.nom}<br>
                            <strong>Ancienne agence :</strong> ${item.agence_ancien_id ? item.agence_ancien.nom : '—'}<br>
                            <strong>Nouvelle agence :</strong> ${ item.agence_nouveau.nom}<br>
                            <strong>Date :</strong> ${date.toLocaleString('fr-FR', { timeZone: 'Indian/Antananarivo' })}<br>
                            <strong>Modifié par :</strong> ${item.user ? item.user.name : '—'}
                        </div>`;
                    });

                    html += `<nav><ul class="pagination">`;
                    if(data.prev_page_url) html += `<li class="page-item"><a href="#" class="page-link" onclick="loadHistorique(${employeeId}, '${employeeName}', ${data.current_page-1}); return false;">Précédent</a></li>`;
                    if(data.next_page_url) html += `<li class="page-item"><a href="#" class="page-link" onclick="loadHistorique(${employeeId}, '${employeeName}', ${data.current_page+1}); return false;">Suivant</a></li>`;
                    html += `</ul></nav>`;
                }
                document.getElementById('historique-container').innerHTML = html;
            });
    }

});
</script>
@endsection
