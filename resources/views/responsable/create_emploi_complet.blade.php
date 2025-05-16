
<x-admin titre="Créer un Emploi du Temps Complet" page_titre="Créer un EDT Complet">

<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Créer un nouvel emploi du temps complet</h2>
        
        <form action="{{ route('responsable.storeMultiple') }}" method="POST">
            @csrf
            
            <!-- Sélection de la classe -->
            <div class="mb-8">
                <label for="classe_id" class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                <select id="classe_id" name="classe_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Sélectionner une classe</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}"
                            data-filiere="{{ $classe->filiere ? $classe->filiere->id : '' }}"
                            data-formation="{{ $classe->filiere && $classe->filiere->formation ? $classe->filiere->formation->id : '' }}">
                            {{ $classe->nom_classe }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Sélection de la filière -->
            <div class="mb-8">
                <label for="filiere_id" class="block text-sm font-medium text-gray-700 mb-1">Filière</label>
                <select id="filiere_id" name="filiere_id" class="w-full border-gray-300 rounded-md shadow-sm" disabled>
                    <option value="">Sélectionner une filière</option>
                    @foreach($filieres as $filiere)
                        <option value="{{ $filiere->id }}" data-formation="{{ $filiere->formation_id }}">
                            {{ $filiere->nom_filiere }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Sélection de la formation -->
            <div class="mb-8">
                <label for="formation_id" class="block text-sm font-medium text-gray-700 mb-1">Formation</label>
                <select id="formation_id" name="formation_id" class="w-full border-gray-300 rounded-md shadow-sm" disabled>
                    <option value="">Sélectionner une formation</option>
                    @foreach($formations as $formation)
                        <option value="{{ $formation->id }}">{{ $formation->nom_formation }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Jours à cocher -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jours de la semaine</label>
                <div class="grid grid-cols-1 md:grid-cols-7 gap-2 mb-4">
                    @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="jours[]" value="{{ $jour }}" class="rounded text-blue-600 jour-checkbox" checked>
                            <span class="font-medium">{{ $jour }}</span>
                        </label>
                    @endforeach
                </div>
                <button type="button" onclick="genererStructureEDT()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    Générer la structure
                </button>
            </div>
            
            <!-- Liste des cours générés -->
            <div id="cours-list" class="space-y-4 mb-8">
                <div class="text-center text-gray-500 py-8">
                    <p>Générez d'abord la structure de l'emploi du temps</p>
                </div>
            </div>
            
            <!-- Boutons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('responsable.emploi') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
                    Annuler
                </a>
                <button type="submit" id="submit-btn" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md" disabled>
                    Créer l'emploi du temps
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Données disponibles
    const matieresData = @json($matieres);
    const enseignantsData = @json($enseignants);

    // Remplissage automatique filière/formation selon la classe choisie
    document.getElementById('classe_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const filiereId = selectedOption.getAttribute('data-filiere');
        const formationId = selectedOption.getAttribute('data-formation');

        // Sélectionne la filière
        const filiereSelect = document.getElementById('filiere_id');
        filiereSelect.value = filiereId || '';
        filiereSelect.disabled = false;

        // Sélectionne la formation
        const formationSelect = document.getElementById('formation_id');
        formationSelect.value = formationId || '';
        formationSelect.disabled = false;
    });

    // Génère dynamiquement les créneaux horaires (1h30 + 15min pause)
    function formatTime(date) {
        return date.toTimeString().slice(0,5);
    }
    function generateTimeSlots() {
        const timeSlots = [];
        let start = new Date(0, 0, 0, 8, 45);
        const end = new Date(0, 0, 0, 17, 30);

        while (start < end) {
            let next = new Date(start.getTime() + 90 * 60000); // 1h30
            if (next > end) break;
            timeSlots.push({
                heure_debut: formatTime(start),
                heure_fin: formatTime(next)
            });
            start = new Date(next.getTime() + 15 * 60000); // pause de 15 minutes
        }
        return timeSlots;
    }

    // Génère la structure de l'EDT
    function genererStructureEDT() {
        const classeId = document.getElementById('classe_id').value;
        if (!classeId) {
            alert('Veuillez sélectionner une classe');
            return;
        }
        const jours = Array.from(document.querySelectorAll('.jour-checkbox:checked')).map(cb => cb.value);
        if (jours.length === 0) {
            alert('Veuillez sélectionner au moins un jour');
            return;
        }

        const coursList = document.getElementById('cours-list');
        coursList.innerHTML = '';
        let index = 0;
        const timeSlots = generateTimeSlots();

        jours.forEach(jour => {
            const jourId = 'jour-' + jour.toLowerCase();
            const jourBlock = document.createElement('div');
            jourBlock.className = "mb-6 border rounded-lg bg-gray-50";
            jourBlock.id = jourId;

            // Header du jour
            jourBlock.innerHTML = `
                <div class="flex items-center justify-between px-4 py-3 border-b bg-white rounded-t-lg">
                    <h3 class="font-bold text-lg text-blue-800">${jour}</h3>
                    <button type="button" onclick="supprimerJour('${jourId}')" class="text-red-600 hover:text-red-800 text-sm">
                        Supprimer ce jour
                    </button>
                </div>
                <div class="p-4 space-y-4" id="${jourId}-creneaux"></div>
            `;

            // Ajoute les créneaux horaires générés dynamiquement
            const creneauxContainer = jourBlock.querySelector(`#${jourId}-creneaux`);
            timeSlots.forEach(slot => {
                creneauxContainer.innerHTML += `
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center p-4 border rounded-lg bg-white">
                        <input type="hidden" name="cours[${index}][jour]" value="${jour}">
                        <div class="md:col-span-2 font-medium">${slot.heure_debut}-${slot.heure_fin}</div>
                        <div class="md:col-span-2">
                            <input type="date" name="cours[${index}][date]" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div class="md:col-span-2">
                            <input type="time" name="cours[${index}][heure_debut]" value="${slot.heure_debut}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div class="md:col-span-2">
                            <input type="time" name="cours[${index}][heure_fin]" value="${slot.heure_fin}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div class="md:col-span-2">
                            <select name="cours[${index}][matiere_id]" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Choisir matière</option>
                                ${matieresData.map(m => `<option value="${m.id}">${m.nom_matiere}</option>`).join('')}
                            </select>
                        </div>
                        <div class="md:col-span-2 flex items-center gap-2">
                            <select name="cours[${index}][enseignant_id]" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Choisir enseignant</option>
                                ${enseignantsData.map(e => `<option value="${e.id}">${e.enseignant_nom}</option>`).join('')}
                            </select>
                            <input type="text" name="cours[${index}][salle]" placeholder="Salle" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <button type="button" onclick="this.closest('.grid').remove()" class="ml-2 bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                Supprimer
                            </button>
                        </div>
                    </div>
                `;
                index++;
            });

            coursList.appendChild(jourBlock);
        });

        document.getElementById('submit-btn').disabled = index === 0;
    }

    // Supprimer un jour complet
    function supprimerJour(jourId) {
        document.getElementById(jourId).remove();
        // Désactiver le bouton submit s'il n'y a plus de cours
        if (document.getElementById('cours-list').children.length === 0) {
            document.getElementById('submit-btn').disabled = true;
        }
    }
</script>
</x-admin>