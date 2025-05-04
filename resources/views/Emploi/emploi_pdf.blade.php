<!-- filepath: c:\Gestion_scolarite\resources\views\Emploi\emploi_pdf.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emploi du Temps - {{ $classe->nom_classe }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
        h1 { text-align: center; font-size: 20px; margin-bottom: 20px; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .bg-gray { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Emploi du Temps - {{ $classe->nom_classe }}</h1>
    <table>
        <thead>
            <tr>
                <th class="text-left">Jour</th>
                <th>Cours 1</th>
                <th>Cours 2</th>
                <th>Cours 3</th>
                <th>Cours 4</th>
                <th>Cours 5</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Trier les emplois du temps par jour
                $jourOrdre = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
                $grouped = $emploisTemps->sortBy(function($e) use ($jourOrdre) {
                    return array_search(strtolower($e->jour), $jourOrdre);
                })->groupBy('jour');
            @endphp

            @foreach ($grouped as $jour => $coursDuJour)
                <tr>
                    <!-- Affichage du jour -->
                    <td class="text-left font-bold">{{ ucfirst($jour) }}</td>

                    @php
                        $maxCours = 5; // Nombre maximum de cours par jour
                        $coursCount = count($coursDuJour);
                    @endphp

                    <!-- Affichage des cours -->
                    @foreach ($coursDuJour as $cours)
                        <td>
                            <div class="font-bold">{{ $cours->matiere->name }}</div>
                            <div>
                                {{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H:i') }}
                            </div>
                            <div>{{ $cours->enseignant->name }}</div>
                            <div><strong>{{ $cours->salle }}</strong></div>
                        </td>
                    @endforeach

                    <!-- Ajouter des cases vides si le nombre de cours est inférieur à 5 -->
                    @for ($i = $coursCount; $i < $maxCours; $i++)
                        <td class="bg-gray"></td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>