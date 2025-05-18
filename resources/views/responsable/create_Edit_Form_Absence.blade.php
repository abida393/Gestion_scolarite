<x-admin 
    titre="{{ isset($absence) ? 'Modifier' : 'Ajouter' }} une absence" 
    page_titre="{{ isset($absence) ? 'Modifier' : 'Ajouter' }} une absence"
    :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom"
>
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center">
                <div class="bg-white/20 p-3 rounded-lg mr-4 backdrop-blur-sm">
                    <i class="fas fa-{{ isset($absence) ? 'edit' : 'plus' }} text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">
                        {{ isset($absence) ? 'Modifier une absence' : 'Ajouter une nouvelle absence' }}
                    </h1>
                    <p class="mt-1 text-blue-100">Gestion des absences et retards des étudiants</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-10">
        <!-- Error Display -->
        @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Il y a {{ $errors->count() }} erreur(s) dans le formulaire
                    </h3>
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

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <form 
                action="{{ isset($absence) ? route('responsable.absences.update', $absence->id) : route('responsable.absences.store') }}" 
                method="POST"
            >
                @csrf
                @if(isset($absence))
                    @method('PUT')
                @endif

                <div class="p-6 space-y-6">
                    <!-- Class & Student Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Class Select -->
                        <div>
                            <label for="classe_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Classe <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="classe_id" 
                                name="classe_id" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm"
                                required
                            >
                                <option value="">Sélectionner une classe</option>
                                @foreach($classes as $classe)
                                    <option 
                                        value="{{ $classe->id }}"
                                        {{ (isset($absence) && $absence->classe_id == $classe->id ? 'selected' : '' )}}
                                    >
                                        {{ $classe->nom_classe }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Student Select -->
                        <div>
                            <label for="etudiant_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Étudiant <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="etudiant_id" 
                                name="etudiant_id" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm"
                                required 
                                {{ isset($absence) ? '' : 'disabled' }}
                            >
                                <option value="">Sélectionner un étudiant</option>
                                @if(isset($absence))
                                    <option value="{{ $absence->etudiant_id }}" selected>
                                        {{ $absence->etudiant->etudiant_nom }} {{ $absence->etudiant->etudiant_prenom }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <!-- Session & Date Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Session Select -->
                        <div>
                            <label for="emploi_temps_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Séance <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="emploi_temps_id" 
                                name="emploi_temps_id" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm"
                                required 
                                {{ isset($absence) ? '' : 'disabled' }}
                            >
                                <option value="">Sélectionner une séance</option>
                                @if(isset($absence))
                                    @foreach($emplois->where('classe_id', $absence->classe_id ?? $absence->etudiant->classe_id) as $emploi)
                                        <option 
                                            value="{{ $emploi->id }}" 
                                            {{ $absence->emploi_temps_id == $emploi->id ? 'selected' : '' }}
                                        >
                                            {{ \Carbon\Carbon::parse($emploi->heure_debut)->format('H:i') }} à 
                                            {{ \Carbon\Carbon::parse($emploi->heure_fin)->format('H:i') }} - 
                                            {{ $emploi->matiere->nom }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Date Input -->
                        <div>
                            <label for="date_absence" class="block text-sm font-medium text-gray-700 mb-1">
                                Date de l'absence <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="date_absence" 
                                name="date_absence"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm"
                                value="{{ isset($absence) ? \Carbon\Carbon::parse($absence->date_absence)->format('Y-m-d') : old('date_absence') }}" 
                                required
                            >
                        </div>
                    </div>

                    <!-- Type & Duration Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Type <span class="text-red-500">*</span>
                            </label>
                            <div class="flex space-x-6">
                                <div class="flex items-center">
                                    <input 
                                        class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" 
                                        type="radio" 
                                        name="type" 
                                        id="type_absence"
                                        value="absence" 
                                        {{ (isset($absence) && $absence->type == 'absence') ? 'checked' : '' }} 
                                        required
                                    >
                                    <label for="type_absence" class="ml-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-circle mr-1"></i> Absence
                                        </span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input 
                                        class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" 
                                        type="radio" 
                                        name="type" 
                                        id="type_retard"
                                        value="retard" 
                                        {{ (isset($absence) && $absence->type == 'retard') ? 'checked' : '' }}
                                    >
                                    <label for="type_retard" class="ml-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> Retard
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Duration Input (Conditional) -->
                        <div id="duree_container" class="{{ (isset($absence) && $absence->type == 'retard') ? '' : 'hidden' }}">
                            <label for="duree_minutes" class="block text-sm font-medium text-gray-700 mb-1">
                                Durée du retard (minutes)
                            </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input 
                                    type="number" 
                                    id="duree_minutes" 
                                    name="duree_minutes"
                                    class="focus:ring-blue-500 focus:border-blue-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300"
                                    value="{{ isset($absence) ? $absence->duree_minutes : old('duree_minutes') }}"
                                    min="1"
                                >
                                <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    minutes
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end space-x-3">
                    <a 
                        href="{{ route('responsable.absences') }}" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <i class="fas fa-times mr-2"></i> Annuler
                    </a>
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <i class="fas fa-save mr-2"></i> {{ isset($absence) ? 'Mettre à jour' : 'Enregistrer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle duration field based on absence type
    document.querySelectorAll('input[name="type"]').forEach(el => {
        el.addEventListener('change', function() {
            const container = document.getElementById('duree_container');
            container.classList.toggle('hidden', this.value !== 'retard');
        });
    });

    // Dynamic loading of students and sessions
    const classeSelect = document.getElementById('classe_id');
    const etudiantSelect = document.getElementById('etudiant_id');
    const emploiTempsSelect = document.getElementById('emploi_temps_id');

    classeSelect.addEventListener('change', function() {
        const classeId = this.value;

        if (classeId) {
            // Load students
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

            // Load sessions
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

    // Initialize if in edit mode
    @if(isset($absence))
        if (classeSelect.value) {
            classeSelect.dispatchEvent(new Event('change'));
        }
    @endif
});
</script>
</x-admin>