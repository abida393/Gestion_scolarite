<!-- resources/views/responsable/emploi.blade.php -->
<x-admin titre="Gestion des Emplois du Temps" page_titre="Emplois du Temps" 
         :nom_complete="Auth::guard('responsable')->user()->respo_nom . ', ' . Auth::guard('responsable')->user()->respo_prenom">

<div class="bg-gray-50 min-h-screen p-6">
    <!-- Notifications -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- En-tête -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Emplois du Temps 
            @if(request('classe_id') && $emploisTemps->isNotEmpty())
                - {{ $classes->firstWhere('id', request('classe_id'))->nom_classe }}
            @endif
            
        </h1>
        
        <div class="flex space-x-3">
            <a href="{{ route('responsable.create', ['classe_id' => request('classe_id')]) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition">
                <span>➕</span>
                <span>Ajouter un cours</span>
            </a>
            <a href="{{ route('responsable.create_emploi_complet') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition">
                <span>📅</span>
                <span>Créer un EDT complet</span>
            </a>
        </div>
    </div>

    <!-- Filtres et statistiques -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
    <form id="filtre-form" action="{{ route('responsable.emploi') }}" method="GET" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Formation</label>
                <select id="formation_id" name="formation_id" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Toutes</option>
                    @foreach($formations as $formation)
                        <option value="{{ $formation->id }}" {{ request('formation_id') == $formation->id ? 'selected' : '' }}>
                            {{ $formation->nom_formation }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filière</label>
                <select id="filiere_id" name="filiere_id" class="w-full border-gray-300 rounded-md shadow-sm" disabled>
                    <option value="">Toutes</option>
                    @foreach($filieres as $filiere)
                        <option value="{{ $filiere->id }}" data-formation="{{ $filiere->formation_id }}"
                            {{ request('filiere_id') == $filiere->id ? 'selected' : '' }}>
                            {{ $filiere->nom_filiere }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                <select id="classe_id" name="classe_id" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Toutes</option>
                @foreach($classes->unique('id') as $classe)
    <option value="{{ $classe->id }}"
        data-filiere="{{ $classe->filiere ? $classe->filiere->id : '' }}"
        data-formation="{{ $classe->filiere && $classe->filiere->formation ? $classe->filiere->formation->id : '' }}"
        {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
        {{ $classe->nom_classe }} 
    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md w-full">
                    Filtrer
                </button>
            </div>
        </div>
    </form>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="text-blue-800 font-medium">Classes</div>
                <div class="text-2xl font-bold">{{ $classes->count() }}</div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="text-green-800 font-medium">Cours cette semaine</div>
                <div class="text-2xl font-bold">{{ $coursSemaine }}</div>
            </div>
            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                <div class="text-yellow-800 font-medium">Enseignants</div>
                <div class="text-2xl font-bold">{{ $enseignantsCount }}</div>
            </div>
            <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                <div class="text-red-800 font-medium">Conflits</div>
                <div class="text-2xl font-bold">{{ $conflitsCount }}</div>
            </div>
        </div>
    </div>

    <!-- Affichage des emplois -->
    @if(request('classe_id') && $emploisTemps->isNotEmpty())
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="font-semibold text-lg">
                    Emploi du temps - {{ $classes->firstWhere('id', request('classe_id'))->nom_classe }}
                </h2>
<a href="{{ route('responsable.emploi_pdf', ['classeId' => request('classe_id')]) }}"   >            
   <span class="mr-1">📥</span> Exporter
                </a>
            </div>
            

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jour</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Créneau</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matière</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enseignant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Salle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                   <tbody class="bg-white divide-y divide-gray-200">
    @foreach($emploisTemps as $emploi)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap font-medium">
            {{ $emploi->jour }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ substr($emploi->heure_debut, 0, 5) }} - {{ substr($emploi->heure_fin, 0, 5) }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                {{ $emploi->matiere->nom_matiere ?? 'Matière inconnue' }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $emploi->enseignant->enseignant_nom ?? 'Enseignant inconnu' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 py-1 bg-gray-100 rounded text-sm">
                {{ $emploi->salle }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <div class="flex space-x-2">
                <a href="{{ route('responsable.edit', $emploi->id) }}" 
                   class="text-blue-600 hover:text-blue-900">Modifier</a>
                <form action="{{ route('responsable.destroy', $emploi->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?')"
                            class="text-red-600 hover:text-red-900">
                        Supprimer
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            
        <!-- </div> -->
    @elseif(request('classe_id'))
        <div class="bg-white p-8 rounded-lg shadow text-center">
            <p class="text-gray-500">Aucun emploi du temps trouvé pour cette classe.</p>
            <a href="{{ route('responsable.create_emploi_complet', ['classe_id' => request('classe_id')]) }}"
               class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg">
                Créer un emploi du temps
            </a>
        </div>
    @else
        <div class="bg-white p-8 rounded-lg shadow text-center">
            <p class="text-gray-500">Veuillez sélectionner une classe pour afficher son emploi du temps.</p>
        </div>
    @endif
</div>
<script>
 // Filtrage automatique
    document.querySelectorAll('select[name="formation_id"], select[name="classe_id"], input[name="week"]').forEach(el => {
        el.addEventListener('change', function() {
            document.getElementById('filtre-form').submit();
        });
    });

   document.addEventListener('DOMContentLoaded', function() {
    // Gestion des dépendances entre les filtres
    const formationSelect = document.getElementById('formation_id');
    const filiereSelect = document.getElementById('filiere_id');
    const classeSelect = document.getElementById('classe_id');

    formationSelect.addEventListener('change', function() {
        const formationId = this.value;
        filiereSelect.disabled = !formationId;
        
        // Réinitialiser les sélections
        filiereSelect.value = '';
        classeSelect.value = '';
        classeSelect.disabled = true;

        // Filtrer les filières
        Array.from(filiereSelect.options).forEach(option => {
            if (!option.value || option.getAttribute('data-formation') === formationId) {
                option.hidden = false;
            } else {
                option.hidden = true;
            }
        });
    });

    filiereSelect.addEventListener('change', function() {
        const filiereId = this.value;
        // classeSelect.disabled = !filiereId;
        
        // Filtrer les classes
        Array.from(classeSelect.options).forEach(option => {
            if (!option.value || option.getAttribute('data-filiere') === filiereId) {
                option.hidden = false;
            } else {
                option.hidden = true;
            }
        });
    });

    // Ajout : Quand on choisit une classe, on sélectionne automatiquement la filière et la formation associées
    // classeSelect.addEventListener('change', function() {
    //     const selectedOption = classeSelect.options[classeSelect.selectedIndex];
    //     const filiereId = selectedOption.getAttribute('data-filiere');
    //     const formationId = selectedOption.getAttribute('data-formation');

    //     // Sélectionner la filière et la formation correspondantes
    //     if (filiereId) {
    //         filiereSelect.value = filiereId;
    //         filiereSelect.disabled = false;
    //     }
    //     if (formationId) {
    //         formationSelect.value = formationId;
    //     }

    //     // Afficher uniquement les filières et classes correspondantes
    //     Array.from(filiereSelect.options).forEach(option => {
    //         if (!option.value || option.getAttribute('data-formation') === formationId) {
    //             option.hidden = false;
    //         } else {
    //             option.hidden = true;
    //         }
    //     });
    //     Array.from(classeSelect.options).forEach(option => {
    //         if (!option.value || option.getAttribute('data-filiere') === filiereId) {
    //             option.hidden = false;
    //         } else {
    //             option.hidden = true;
    //         }
    //     });
    // });

    // Soumission automatique du formulaire
    document.querySelectorAll('#formation_id, #filiere_id, #classe_id').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filtre-form').submit();
        });
    });
});
</script>
</x-admin>