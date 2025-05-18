<x-admin titre="{{ isset($absence) ? 'Modifier' : 'Ajouter' }} une absence" page_titre="{{ isset($absence) ? 'Modifier' : 'Ajouter' }} une absence"  :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom">
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex items-center mb-8">
        <div class="bg-blue-600 text-white p-4 rounded-xl mr-4">
            <i class="fas fa-{{ isset($absence) ? 'edit' : 'plus' }} text-2xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ isset($absence) ? 'Modifier' : 'Ajouter' }} une absence</h1>
            <p class="text-gray-600">Gestion des absences et retards des étudiants</p>
        </div>
    </div>

    <!-- Affichage des erreurs -->
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 mt-1 mr-3"></i>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-red-800">Il y a {{ $errors->count() }} erreur(s) dans le formulaire</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Carte principale -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <form action="{{ isset($absence) ? route('responsable.absences.update', $absence->id) : route('responsable.absences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($absence))
                @method('PUT')
            @endif

            <div class="p-6">
                <!-- Section Classe et Étudiant -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="classe_id" class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                        <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                                id="classe_id" name="classe_id" required>
                            <option value="">Sélectionner une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}"
                                    {{ (isset($absence) && $absence->classe_id == $classe->id) ? 'selected' : '' }}>
                                    {{ $classe->nom_classe }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="etudiant_id" class="block text-sm font-medium text-gray-700 mb-1">Étudiant</label>
                        <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                                id="etudiant_id" name="etudiant_id" required {{ isset($absence) ? '' : 'disabled' }}>
                            <option value="">Sélectionner un étudiant</option>
                            @if(isset($absence))
                                <option value="{{ $absence->etudiant_id }}" selected>
                                    {{ $absence->etudiant->etudiant_nom }} {{ $absence->etudiant->etudiant_prenom }}
                                </option>
                            @endif
                        </select>
                    </div>
                </div>

                <!-- Section Séance et Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="emploi_temps_id" class="block text-sm font-medium text-gray-700 mb-1">Séance</label>
                        <select class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                                id="emploi_temps_id" name="emploi_temps_id" required {{ isset($absence) ? '' : 'disabled' }}>
                            <option value="">Sélectionner une séance</option>
                            @if(isset($absence))
                                @foreach($emplois->where('classe_id', $absence->classe_id ?? $absence->etudiant->classe_id) as $emploi)
                                    <option value="{{ $emploi->id }}" @if($absence->emploi_temps_id == $emploi->id) selected @endif>
                                        {{ \Carbon\Carbon::parse($emploi->heure_debut)->format('H:i') }} à {{ \Carbon\Carbon::parse($emploi->heure_fin)->format('H:i') }} - {{ $emploi->matiere->nom }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <label for="date_absence" class="block text-sm font-medium text-gray-700 mb-1">Date de l'absence</label>
                        <input type="date" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                               id="date_absence" name="date_absence"
                               value="{{ isset($absence) ? \Carbon\Carbon::parse($absence->date_absence)->format('Y-m-d') : old('date_absence') }}" required>
                    </div>
                </div>

                <!-- Section Type et Durée -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <div class="flex space-x-6">
                            <div class="flex items-center">
                                <input class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500"
                                       type="radio" name="type" id="type_absence"
                                       value="absence" {{ (isset($absence) && $absence->type == 'absence') ? 'checked' : '' }} required>
                                <label for="type_absence" class="ml-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-exclamation-circle mr-1"></i> Absence
                                    </span>
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500"
                                       type="radio" name="type" id="type_retard"
                                       value="retard" {{ (isset($absence) && $absence->type == 'retard') ? 'checked' : '' }}>
                                <label for="type_retard" class="ml-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Retard
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="duree_container" class="{{ (isset($absence) && $absence->type == 'retard') ? '' : 'hidden' }}">
                        <label for="duree_minutes" class="block text-sm font-medium text-gray-700 mb-1">Durée du retard (minutes)</label>
                        <div class="flex rounded-md shadow-sm">
                            <input type="number" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   id="duree_minutes" name="duree_minutes"
                                   value="{{ isset($absence) ? $absence->duree_minutes : old('duree_minutes') }}">
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500">minutes</span>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('responsable.absences') }}" class="btn-gray">
                        <i class="fas fa-times mr-2"></i> Annuler
                    </a>
                    <button type="submit" class="btn-blue">
                        <i class="fas fa-save mr-2"></i> {{ isset($absence) ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .btn-blue {
        @apply bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors;
    }
    .btn-gray {
        @apply bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium transition-colors;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du type (absence/retard)
    document.querySelectorAll('input[name="type"]').forEach(el => {
        el.addEventListener('change', function() {
            const container = document.getElementById('duree_container');
            if (this.value === 'retard') {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        });
    });

    // Chargement dynamique des étudiants et séances
    const classeSelect = document.getElementById('classe_id');
    const etudiantSelect = document.getElementById('etudiant_id');
    const emploiTempsSelect = document.getElementById('emploi_temps_id');

    classeSelect.addEventListener('change', function() {
        const classeId = this.value;

        if (classeId) {
            // Charger les étudiants
            fetch(`/absences/etudiants-par-classe/${classeId}`)
                .then(response => response.json())
                .then(data => {
                    etudiantSelect.disabled = false;
                    etudiantSelect.innerHTML = '<option value="">Sélectionner un étudiant</option>';
                    data.forEach(etudiant => {
                        const option = document.createElement('option');
                        option.value = etudiant.id;
                        option.textContent = `${etudiant.nom} ${etudiant.prenom}`;
                        etudiantSelect.appendChild(option);
                    });
                });

            // Charger les séances
            fetch(`/absences/seances-par-classe/${classeId}`)
                .then(response => response.json())
                .then(data => {
                    emploiTempsSelect.disabled = false;
                    emploiTempsSelect.innerHTML = '<option value="">Sélectionner une séance</option>';
                    data.forEach(emploi => {
                        const option = document.createElement('option');
                        option.value = emploi.id;
                        const heureDebut = new Date(`1970-01-01T${emploi.heure_debut}`);
                        const heureFin = new Date(`1970-01-01T${emploi.heure_fin}`);
                        option.textContent = `${heureDebut.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})} à ${heureFin.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})} - ${emploi.matiere}`;
                        emploiTempsSelect.appendChild(option);
                    });
                });
        } else {
            etudiantSelect.disabled = true;
            emploiTempsSelect.disabled = true;
            etudiantSelect.innerHTML = '<option value="">Sélectionner un étudiant</option>';
            emploiTempsSelect.innerHTML = '<option value="">Sélectionner une séance</option>';
        }
    });

    // Initialiser si mode édition
    @if(isset($absence))
        if (classeSelect.value) {
            classeSelect.dispatchEvent(new Event('change'));
        }
    @endif
});
</script>
</x-admin>
