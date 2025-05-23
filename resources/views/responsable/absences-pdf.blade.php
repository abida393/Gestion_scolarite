
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export des Absences</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #2d3748; text-align: center; }
        .header { margin-bottom: 20px; }
        .info { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f7fafc; text-align: left; padding: 8px; border: 1px solid #e2e8f0; }
        td { padding: 8px; border: 1px solid #e2e8f0; }
        .text-center { text-align: center; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 12px; }
        .badge-justified { background-color: #c6f6d5; color: #22543d; }
        .badge-pending { background-color: #feebc8; color: #7b341e; }
        .badge-unjustified { background-color: #fed7d7; color: #742a2a; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport des Absences</h1>
        <div class="info text-center">
            <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
            @if($classe)
                <p>Classe: {{ $classe->nom_classe ?? $classe->nom }}</p>
            @endif
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Étudiant</th>
                <th>Matière</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Type</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absences as $absence)
            <tr>
                <td>{{ $absence->etudiant->etudiant_prenom }} {{ $absence->etudiant->etudiant_nom }}</td>
                <td>{{ $absence->emploiTemps->matiere->nom_matiere ?? 'Inconnue' }}</td>
                <td>{{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</td>
                <td>
                    @if($absence->emploiTemps && $absence->emploiTemps->heure_debut && $absence->emploiTemps->heure_fin)
                        {{ \Carbon\Carbon::parse($absence->emploiTemps->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($absence->emploiTemps->heure_fin)->format('H:i') }}
                    @else
                        Inconnu
                    @endif
                </td>
                <td>{{ $absence->type === 'retard' ? 'Retard' : 'Absence' }}</td>
                <td>
                    @if($absence->Justifier)
                        <span class="badge badge-justified">Justifiée</span>
                    @elseif($absence->status === 'pending')
                        <span class="badge badge-pending">En attente</span>
                    @else
                        <span class="badge badge-unjustified">Non justifiée</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>