<x-admin titre="Créer un Emploi du Temps Complet" page_titre="Créer un EDT Complet" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ',' . Auth::guard('responsable')->user()->respo_prenom">

    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-white">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Header avec bouton retour -->
            <div class="flex items-center mb-8">
                <a href="{{ route('responsable.emploi') }}"
                    class="mr-4 p-2 rounded-full bg-white shadow-sm hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Création d'emploi du temps</h1>
            </div>

            <!-- Carte principale avec effet glassmorphism -->
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-white/30 overflow-hidden">
                <form action="{{ route('responsable.storeMultiple') }}" method="POST">
                    @csrf

                    <!-- Section de sélection -->
                    <div class="p-8 border-b border-white/20">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Configuration de base
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Sélection de la classe -->
                            <div>
                                <label for="classe_id"
                                    class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    Classe
                                </label>
                                <select id="classe_id" name="classe_id"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white/80 backdrop-blur"
                                    required>
                                    <option value="">Sélectionner une classe</option>
                                    @foreach ($classes as $classe)
                                        <option value="{{ $classe->id }}"
                                            data-filiere="{{ $classe->filiere ? $classe->filiere->id : '' }}"
                                            data-formation="{{ $classe->filiere && $classe->filiere->formation ? $classe->filiere->formation->id : '' }}">
                                            {{ $classe->nom_classe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sélection de la filière -->
                            <div>
                                <label for="filiere_id"
                                    class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Filière
                                </label>
                                <select id="filiere_id" name="filiere_id"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white/80 backdrop-blur"
                                    disabled>
                                    <option value="">Sélectionner une filière</option>
                                    @foreach ($filieres as $filiere)
                                        <option value="{{ $filiere->id }}"
                                            data-formation="{{ $filiere->formation_id }}">
                                            {{ $filiere->nom_filiere }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sélection de la formation -->
                            <div>
                                <label for="formation_id"
                                    class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path
                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                    </svg>
                                    Formation
                                </label>
                                <select id="formation_id" name="formation_id"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white/80 backdrop-blur"
                                    disabled>
                                    <option value="">Sélectionner une formation</option>
                                    @foreach ($formations as $formation)
                                        <option value="{{ $formation->id }}">{{ $formation->nom_formation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Jours à cocher -->
                    <div class="p-8 border-b border-white/20">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Jours de cours
                        </h2>

                        <div class="grid grid-cols-2 md:grid-cols-6 gap-3 mb-6">
                            @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour)
                                <label
                                    class="flex items-center space-x-2 p-3 rounded-lg border border-gray-200 hover:border-blue-300 bg-white/80 backdrop-blur cursor-pointer transition-all hover:shadow-sm">
                                    <input type="checkbox" name="jours[]" value="{{ $jour }}"
                                        class="rounded-full h-5 w-5 text-blue-600 border-gray-300 focus:ring-blue-500 jour-checkbox"
                                        checked>
                                    <span class="font-medium text-gray-700">{{ $jour }}</span>
                                </label>
                            @endforeach
                        </div>

                        <button type="button" onclick="genererStructureEDT()"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-medium rounded-lg shadow-md transition-all transform hover:scale-[1.02] flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Générer la structure
                        </button>
                    </div>

                    <!-- Liste des cours générés -->
                    <div id="cours-list" class="p-8">
                        <div
                            class="text-center py-12 rounded-xl border-2 border-dashed border-gray-300 bg-white/50 backdrop-blur">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-700">Structure vide</h3>
                            <p class="mt-1 text-gray-500">Générez d'abord la structure de l'emploi du temps</p>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div
                        class="p-6 bg-gray-50/50 backdrop-blur-sm border-t border-white/20 flex justify-end space-x-4">
                        <a href="{{ route('responsable.emploi') }}"
                            class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg shadow-sm hover:bg-gray-50 transition-all">
                            Annuler
                        </a>
                        <button type="submit" id="submit-btn"
                            class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-medium rounded-lg shadow-md transition-all transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                            Créer l'emploi du temps
                        </button>
                    </div>
                </form>
            </div>
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
            return date.toTimeString().slice(0, 5);
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
                jourBlock.className =
                    "mb-8 rounded-xl shadow-sm border border-gray-200 bg-white/80 backdrop-blur overflow-hidden";
                jourBlock.id = jourId;

                // Header du jour
                jourBlock.innerHTML = `
                <div class="flex items-center justify-between px-6 py-4 border-b bg-gradient-to-r from-blue-50 to-blue-100/30">
                    <h3 class="font-bold text-lg text-blue-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        ${jour}
                    </h3>
                    <button type="button" onclick="supprimerJour('${jourId}')" class="text-sm font-medium text-red-600 hover:text-red-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Supprimer
                    </button>
                </div>
                <div class="p-6 space-y-4" id="${jourId}-creneaux"></div>
            `;

                // Ajoute les créneaux horaires générés dynamiquement
                const creneauxContainer = jourBlock.querySelector(`#${jourId}-creneaux`);
                timeSlots.forEach(slot => {
                    creneauxContainer.innerHTML += `
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center p-5 rounded-lg border border-gray-200 bg-white shadow-sm hover:shadow-md transition-all">
                        <input type="hidden" name="cours[${index}][jour]" value="${jour}">
                        <div class="md:col-span-1 font-medium text-blue-700">${slot.heure_debut}-${slot.heure_fin}</div>
                        <div class="md:col-span-2">
                            <input type="date" name="cours[${index}][date]" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div class="md:col-span-2">
                            <select name="cours[${index}][matiere_id]" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Matière</option>
                                ${matieresData.map(m => `<option value="${m.id}">${m.nom_matiere}</option>`).join('')}
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <select name="cours[${index}][enseignant_id]" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Enseignant</option>
                                ${enseignantsData.map(e => `<option value="${e.id}">${e.enseignant_nom}</option>`).join('')}
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <input type="text" name="cours[${index}][salle]" placeholder="Salle" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div class="md:col-span-2 flex items-center gap-2">
                            <input type="time" name="cours[${index}][heure_debut]" value="${slot.heure_debut}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            <input type="time" name="cours[${index}][heure_fin]" value="${slot.heure_fin}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            <button type="button" onclick="this.closest('.grid').remove()" class="p-2 text-red-600 hover:text-red-800 rounded-full hover:bg-red-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
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
