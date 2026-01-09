<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Autorisation de congé</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .box {
            border: 1px solid #000;
            padding: 15px;
        }
        .row {
            margin-bottom: 8px;
        }
        .label {
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="title">AUTORISATION DE CONGÉ</div>

    <div class="box">
        <div class="row">
            <span class="label">Employé :</span>
            {{ $conge->employee->nom }} {{ $conge->employee->prenom }}
        </div>

        <div class="row">
            <span class="label">Type de congé :</span>
            {{ ucfirst($conge->type) }}
        </div>

        <div class="row">
            <span class="label">Période :</span>
            du {{ $conge->date_debut }} au {{ $conge->date_fin }}
        </div>

        <div class="row">
            <span class="label">Nombre de jours :</span>
            {{ $conge->nombre }} jours
        </div>

        <div class="row">
            <span class="label">Solde restant :</span>
            {{ $conge->solde_restant }} jours
        </div>

        <div class="row">
            <span class="label">Statut :</span>
            {{ strtoupper($conge->statut) }}
        </div>

        <div class="row">
            <span class="label">Motif :</span>
            {{ $conge->motif ?? '—' }}
        </div>

        <div class="row">
            <span class="label">Commentaire RH :</span>
            {{ $conge->commentaire_validation }}
        </div>
    </div>

    <div class="footer">
        <p>Fait le {{ now()->format('d/m/Y') }}</p>
        <p><strong>Responsable RH</strong></p>
    </div>

</body>
</html>
