<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Emploi du Temps</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

<div class="max-w-7xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-10 uppercase">Modifier un Cours</h1>

    <form action="{{ route('emploi.update', $emploiTemp->id) }}" method="POST" class="space-y-8 bg-white p-8 rounded-lg shadow-md border border-gray-200">
        @csrf
        @method('PUT')

        <!-- Jour -->
        <div>
            <label for="jour" class="block text-sm font-semibold text-gray-700 mb-1">Jour</label>
            <input type="text" name="jour" id="jour" value="{{ $emploiTemp->jour }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Date et Salle -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="date" class="block text-sm font-semibold text-gray-700 mb-1">Date</label>
                <input type="date" name="date" id="date" value="{{ $emploiTemp->date }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label for="salle" class="block text-sm font-semibold text-gray-700 mb-1">Salle</label>
                <input type="text" name="salle" id="salle" value="{{ $emploiTemp->salle }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>

        <!-- Plage Horaire -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="horaire" class="block text-sm font-semibold text-gray-700 mb-1">Plage Horaire</label>
        <select name="horaire" id="horaire" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
            @foreach ($timeSlots as $slot)
                <option value="{{ $slot }}" {{ $emploiTemp->heure_debut . ' - ' . $emploiTemp->heure_fin == $slot ? 'selected' : '' }}>
                    {{ $slot }}
                </option>
            @endforeach
        </select>
    </div>
</div>

        <!-- Matière et Enseignant -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="matiere_id" class="block text-sm font-semibold text-gray-700 mb-1">Matière</label>
                <select name="matiere_id" id="matiere_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    @foreach ($matieres as $matiere)
                        <option value="{{ $matiere->id }}" {{ $emploiTemp->matiere_id == $matiere->id ? 'selected' : '' }}>
                            {{ $matiere->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="enseignant_id" class="block text-sm font-semibold text-gray-700 mb-1">Enseignant</label>
                <select name="enseignant_id" id="enseignant_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    @foreach ($enseignants as $enseignant)
                        <option value="{{ $enseignant->id }}" {{ $emploiTemp->enseignant_id == $enseignant->id ? 'selected' : '' }}>
                            {{ $enseignant->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Classe -->
        <div>
            <label for="classe_id" class="block text-sm font-semibold text-gray-700 mb-1">Classe</label>
            <select name="classe_id" id="classe_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}" {{ $emploiTemp->classe_id == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom_classe }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Bouton Mettre à jour -->
        <div class="pt-4 flex justify-between">
            <a href="{{ route('emploi') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg transition shadow">
                ↩️ Annuler
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition shadow">
                💾 Mettre à jour
            </button>
        </div>
    </form>
</div>

<!-- Affichage des erreurs -->
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mt-6">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    // Générer les plages horaires dynamiquement
    private function generateTimeSlots()
{
    $startTime = new \DateTime('08:45'); // Début des cours à 8h45
    $endTime = new \DateTime('17:30'); // Fin des cours à 17h30
    $timeSlots = [];

    while ($startTime < $endTime) {
        $nextTime = clone $startTime;
        $nextTime->modify('+1 hour 30 minutes'); // Ajouter 1h30

        if ($nextTime > $endTime) {
            break;
        }

        $timeSlots[] = $startTime->format('H:i') . ' - ' . $nextTime->format('H:i');
        $startTime = clone $nextTime;

        // Ajouter une pause
        if ($startTime->format('H:i') === '12:15') {
            $startTime->modify('+30 minutes'); // Pause de 30 minutes après le matin
        } else {
            $startTime->modify('+15 minutes'); // Pause de 15 minutes
        }
    }

    return $timeSlots;
}

    // Charger les plages horaires dans le champ select
    document.addEventListener('DOMContentLoaded', () => {
        const timeSlots = generateTimeSlots();
        const horaireSelect = document.getElementById('horaire');
        timeSlots.forEach(slot => {
            const option = document.createElement('option');
            option.value = slot;
            option.textContent = slot;
            horaireSelect.appendChild(option);
        });
    });
</script>

</body>
</html>