
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emploi du Temps - {{ $classe->nom_classe }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f4f4f4; font-weight: bold; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 20px; }
        .text-left { text-align: left; }
        .bg-gray { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Emploi du Temps - {{ $classe->nom_classe }}</h1>
    <table>
        <thead>
            <tr>
                <th class="text-left">Jour</th>
                @php
                    $horaires = [];
                    $start = \Carbon\Carbon::createFromTime(8, 45);
                    $end = \Carbon\Carbon::createFromTime(17, 30);
                    while ($start->copy()->addMinutes(90) <= $end) {
                        $fin = $start->copy()->addMinutes(90);
                        $horaires[] = [$start->format('H:i'), $fin->format('H:i')];
                        $start = $fin->copy()->addMinutes(15); // Pause
                    }
                @endphp
                @foreach ($horaires as $h)
                    <th>{{ $h[0] }} - {{ $h[1] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $joursSemaine = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
                $grouped = $emploisTemps->map(function($e) {
                    $e->jour = strtolower(trim($e->jour));
                    return $e;
                })->groupBy('jour');
            @endphp

            @foreach ($joursSemaine as $jour)
                <tr>
                    <td class="text-left font-bold">{{ ucfirst($jour) }}</td>
                    @foreach ($horaires as $h)
                        @php
                            $cours = $grouped->get($jour, collect())->first(function ($e) use ($h) {
                                return \Carbon\Carbon::parse($e->heure_debut)->format('H:i') == $h[0] && \Carbon\Carbon::parse($e->heure_fin)->format('H:i') == $h[1];
                            });
                        @endphp
                        <td>
                            @if ($cours)
                                <div class="font-bold text-indigo-700 text-sm mb-1">{{ $cours->matiere->name }}</div>
                                <!-- <div>{{ \Carbon\Carbon::parse($cours->date)->format('d/m') }}</div> -->
                                {{-- Les heures ont été supprimées --}}
                                {{-- <div>{{ $cours->heure_debut }} - {{ $cours->heure_fin }}</div> --}}
                                <div class="text-sm text-gray-800 font-semibold">{{ $cours->enseignant->name }}</div>
                                <div class="text-sm text-gray-700 font-bold"><strong>{{ $cours->salle }}</strong></div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>