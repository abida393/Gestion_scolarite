<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Créer un Emploi du Temps</title>
</head>
<body class="bg-gray-100 font-sans">

<div class="max-w-7xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-10 uppercase">Créer un Emploi du Temps</h1>

    <form action="{{ route('emploi.storeMultiple') }}" method="POST" class="space-y-8 bg-white p-8 rounded-lg shadow-md border border-gray-200">
        @csrf

        <!-- Sélection de la formation -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Formation</label>
            <select id="formation-select" name="formation_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">-- Sélectionnez une formation --</option>
                @forelse ($formations as $formation)
                    <option value="{{ $formation->id }}">{{ $formation->nom_formation }}</option>
                @empty
                    <option value="">Aucune formation disponible</option>
                @endforelse
            </select>
        </div>

        <!-- Sélection de la filière -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Filière</label>
            <select id="filiere-select" name="filiere_id" class="form-control">
                <option value="">-- Sélectionnez une filière --</option>
                @foreach ($filieres as $filiere)
                    <option value="{{ $filiere->id }}">{{ $filiere->nom_filiere }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sélection de la classe -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Classe</label>
            <select id="classe-select" name="classe_id" class="form-control">
                <option value="">-- Sélectionnez une classe --</option>
                @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom_classe }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sélection des jours -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Sélectionner les jours</label>
            <select id="jours-select" name="jours[]" class="w-full px-4 py-2 border rounded-lg" multiple required>
                <option value="Lundi">Lundi</option>
                <option value="Mardi">Mardi</option>
                <option value="Mercredi">Mercredi</option>
                <option value="Jeudi">Jeudi</option>
                <option value="Vendredi">Vendredi</option>
                <option value="Samedi">Samedi</option>
                <option value="Dimanche">Dimanche</option>
            </select>
            <small class="text-gray-500">Maintenez la touche Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs jours.</small>
        </div>

        <!-- Liste des cours générés dynamiquement -->
        <div id="cours-list">
            <!-- Les cours seront ajoutés ici dynamiquement -->
        </div>

        <!-- Boutons -->
        <div class="flex justify-between">
            <button type="button" onclick="generateCours()" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow">
                ➕ Générer les Cours
            </button>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">
                📅 Créer Emploi du Temps
            </button>
        </div>
    </form>
</div>

<script>
    // Charger les filières en fonction de la formation sélectionnée
    document.getElementById('formation-select').addEventListener('change', function () {
        const formationId = this.value;
        fetch(`/filieres-par-formation/${formationId}`)
            .then(response => response.json())
            .then(data => {
                const filiereSelect = document.getElementById('filiere-select');
                filiereSelect.innerHTML = '<option value="">-- Sélectionnez une filière --</option>';
                data.forEach(filiere => {
                    filiereSelect.innerHTML += `<option value="${filiere.id}">${filiere.nom_filiere}</option>`;
                });
            });
    });

    // Charger les classes en fonction de la filière sélectionnée
    document.getElementById('filiere-select').addEventListener('change', function () {
        const filiereId = this.value;
        fetch(`/classes-par-filiere/${filiereId}`)
            .then(response => response.json())
            .then(data => {
                const classeSelect = document.getElementById('classe-select');
                classeSelect.innerHTML = '<option value="">-- Sélectionnez une classe --</option>';
                data.forEach(classe => {
                    classeSelect.innerHTML += `<option value="${classe.id}">${classe.nom_classe}</option>`;
                });
            });
    });

    // Générer dynamiquement les cours
    function generateCours() {
        const joursSelect = document.getElementById('jours-select');
        const selectedJours = Array.from(joursSelect.selectedOptions).map(option => option.value);
        const container = document.getElementById('cours-list');
        container.innerHTML = ''; // Réinitialiser la liste des cours

        let index = 0;
        selectedJours.forEach(jour => {
            const newCours = `
            <div class="cours grid grid-cols-1 md:grid-cols-2 gap-6 mb-8" id="cours-${index}">
                <div>
                    <label class="block text-sm font-semibold mb-1">Jour</label>
                    <input type="text" name="cours[${index}][jour]" value="${jour}" class="w-full px-4 py-2 border rounded-lg" readonly>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Date</label>
                    <input type="date" name="cours[${index}][date]" class="w-full px-4 py-2 border rounded-lg" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Plage Horaire</label>
                    <select name="cours[${index}][horaire]" class="w-full px-4 py-2 border rounded-lg" required>
                        ${generateTimeSlots().map(slot => `<option value="${slot}">${slot}</option>`).join('')}
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Matière</label>
                    <select name="cours[${index}][matiere_id]" class="w-full px-4 py-2 border rounded-lg" required>
                        @foreach ($matieres as $matiere)
                            <option value="{{ $matiere->id }}">{{ $matiere->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Enseignant</label>
                    <select name="cours[${index}][enseignant_id]" class="w-full px-4 py-2 border rounded-lg" required>
                        @foreach ($enseignants as $enseignant)
                            <option value="{{ $enseignant->id }}">{{ $enseignant->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Salle</label>
                    <input type="text" name="cours[${index}][salle]" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
            </div>`;
            container.insertAdjacentHTML('beforeend', newCours);
            index++;
        });
    }

    // Générer les plages horaires
    function generateTimeSlots() {
        const startTime = new Date();
        startTime.setHours(8, 45, 0); // Début des cours à 8h45
        const endTime = new Date();
        endTime.setHours(17, 30, 0); // Fin des cours à 17h30

        const timeSlots = [];
        let currentTime = new Date(startTime);

        while (currentTime < endTime) {
            const nextTime = new Date(currentTime);
            nextTime.setMinutes(nextTime.getMinutes() + 90); // Ajouter 1h30

            if (nextTime > endTime) break;

            const formattedStart = currentTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const formattedEnd = nextTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            timeSlots.push(`${formattedStart} - ${formattedEnd}`);

            // Ajouter une pause
            currentTime = new Date(nextTime);
            currentTime.setMinutes(currentTime.getMinutes() + (formattedEnd === "12:15" ? 30 : 15)); // Pause de 30 min après le matin, sinon 15 min
        }

        return timeSlots;
    }
</script>

</body>
</html>