@php
    $classeBordure = 'border-attente';
    if($conge->statut == 'valide') $classeBordure = 'border-valide';
    if($conge->statut == 'refuse' || $conge->statut == 'refusé') $classeBordure = 'border-refuse';
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Décision de Congé - {{ $conge->id }}</title>
    <style>
        @page { size: A4; margin: 1.5cm 2cm; }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #333;
            margin: 0;
        }

        /* En-tête */
        .header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .company-info { display: table-cell; width: 60%; }
        .company-name { font-size: 16pt; font-weight: bold; color: #0056b3; }
        .doc-meta { display: table-cell; width: 40%; text-align: right; font-size: 9pt; color: #666; vertical-align: bottom; }

        /* Titre */
        .doc-title { text-align: center; margin: 30px 0; }
        .doc-title h1 { 
            font-size: 18pt; 
            margin: 0; 
            color: #000;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .doc-title .ref { font-size: 10pt; color: #666; }

        /* Sections */
        .section { margin-bottom: 25px; }
        .section-header {
            font-weight: bold;
            font-size: 10pt;
            color: #0056b3;
            text-transform: uppercase;
            border-bottom: 1px solid #eee;
            margin-bottom: 10px;
        }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table td { padding: 6px 0; vertical-align: top; }
        .label { width: 180px; color: #666; font-size: 10pt; }
        .value { font-weight: 500; color: #000; }

        /* Bloc Décision avec bordure dynamique */
        .decision-alert {
        background-color: #f8f9fa;
        padding: 20px;
        margin: 30px 0;
    }
    /* On définit les bordures selon des classes fixes */
    .border-valide { border-left: 5px solid #28a745; }
    .border-refuse { border-left: 5px solid #dc3545; }
    .border-attente { border-left: 5px solid #ffc107; }
        .status-label { font-size: 9pt; text-transform: uppercase; color: #666; margin-bottom: 5px; }
        .status-value { font-size: 14pt; font-weight: bold; color: #000; }

        /* Signatures */
        .signature-group {
            margin-top: 50px;
            width: 100%;
            display: table;
        }
        .sig-box {
            display: table-cell;
            width: 50%;
            text-align: center;
        }
        .sig-line {
            margin: 60px auto 10px;
            width: 80%;
            border-top: 1px solid #ccc;
        }
        .sig-name { font-size: 10pt; font-weight: bold; }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            font-size: 8pt;
            text-align: center;
            color: #aaa;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="company-info">
            <div class="company-name">RAPIDE SERVICE </div>
            <div style="font-size: 9pt;">Ressources Humaines</div>
        </div>
        <div class="doc-meta">
            Fait à Antananarivo, le {{ date('d/m/Y') }}<br>
            Réf : {{ date('Y') }}/CONG/{{ str_pad($conge->id, 4, '0', STR_PAD_LEFT) }}
        </div>
    </div>

    <div class="doc-title">
        <h1>Attestation de Congé</h1>
        <div class="ref">Notification de décision administrative</div>
    </div>

    <div class="section">
        <div class="section-header">Bénéficiaire</div>
        <table class="data-table">
            <tr>
                <td class="label">Nom & Prénoms</td>
                <td class="value">{{ $conge->employee->nom }} {{ $conge->employee->prenom }}</td>
            </tr>
            <tr>
                <td class="label">Poste occupé</td>
                <td class="value">{{ $conge->employee->poste->nom ?? 'Non renseigné' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-header">Détails de l'absence</div>
        <table class="data-table">
            <tr>
                <td class="label">Type de congé</td>
                <td class="value">{{ ucfirst($conge->type) }}</td>
            </tr>
            <tr>
                <td class="label">Période d'absence</td>
                <td class="value">Du {{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Durée totale</td>
                <td class="value">{{ $conge->nombre }} jour(s) ouvré(s)</td>
            </tr>
            <tr>
                <td class="label">Reprise de service</td>
                <td class="value">{{ \Carbon\Carbon::parse($conge->date_fin)->addDay()->format('d/m/Y') }} (matin)</td>
            </tr>
        </table>
    </div>

    <div class="decision-alert">
        <div class="status-label">Décision de la direction :</div>
        <div class="status-value">
            @if($conge->statut == 'valide')
                DÉCISION FAVORABLE
            @elseif($conge->statut == 'refuse' || $conge->statut == 'refusé')
                DÉCISION DÉFAVORABLE
            @else
                EN ATTENTE DE VALIDATION
            @endif
        </div>
        @if($conge->commentaire_validation)
            <div style="margin-top: 10px; font-size: 10pt; font-style: italic; color: #555;">
                Note : "{{ $conge->commentaire_validation }}"
            </div>
        @endif
    </div>

    <div class="signature-group">
        <div class="sig-box">
            <div class="sig-name">L'Employé(e)</div>
            <div style="font-size: 8pt; color: #999;">(Signature précédée de la mention "bon pour accord")</div>
            <div class="sig-line"></div>
        </div>
        <div class="sig-box">
            <div class="sig-name">La Direction RH</div>
            <div style="font-size: 8pt; color: #999;">(Signature et cachet)</div>
            <div class="sig-line"></div>
        </div>
    </div>

    <div class="footer">
        Document généré par le système RH - RAPIDE SERVICE 
    </div>

</body>
</html>