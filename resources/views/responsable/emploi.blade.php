<!-- resources/views/responsable/emploi.blade.php -->
 <script>
    function openAbsenceModalWithId(emploiId) {
    document.getElementById('modal_emploi_id').value = emploiId;
    document.getElementById('absenceModal').classList.remove('hidden');
}
function closeAbsenceModal() {
    document.getElementById('absenceModal').classList.add('hidden');
}
 </script>
<x-admin titre="Gestion des Emplois du Temps" page_titre="Emplois du Temps" 
         :nom_complete="Auth::guard('responsable')->user()->respo_nom . ', ' . Auth::guard('responsable')->user()->respo_prenom">

<div class="bg-gray-50 min-h-screen p-6">
    <!-- Notifications -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Modal d'absence -->
    <div id="absenceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Déclarer une absence</h3>
                <button onclick="closeAbsenceModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('responsable.declarer_absence') }}" method="POST">
                @csrf
                <input type="hidden" id="modal_emploi_id" name="emploi_id">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="statut" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Sélectionnez un statut</option>
                        <option value="annule">Annulé</option>
                        <option value="reporte">Reporté</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Motif</label>
                    <textarea name="motif_annulation" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeAbsenceModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- En-tête -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
            <span class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Emplois du Temps
            </span>
            @if(request('classe_id') && $emploisTemps->isNotEmpty())
                <span class="text-lg text-gray-600 ml-2">- {{ $classes->firstWhere('id', request('classe_id'))->nom_classe }}</span>
            @endif
        </h1>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <a href="{{ route('responsable.create', ['classe_id' => request('classe_id')]) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>Ajouter un cours</span>
            </a>
            <a href="{{ route('responsable.create_emploi_complet') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Créer un EDT complet</span>
            </a>
            <!-- @if(request('classe_id'))
            <button onclick="openAbsenceModal()"
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition">
                <span>⚠️</span>
                <span>Déclarer absence</span>
            </button>
            @endif -->
        </div>
    </div>

   <!-- Filtres et statistiques -->
<div class="bg-white p-6 rounded-lg shadow mb-8 ">
    <form id="filtre-form" action="{{ route('responsable.emploi') }}" method="GET" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Filtre Formation -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Formation</label>
                <div class="relative">
                    <select id="formation_id" name="formation_id" 
                            class="w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md appearance-none">
                        <option value="">Toutes les formations</option>
                        @foreach($formations as $formation)
                        <option value="{{ $formation->id }}" {{ request('formation_id') == $formation->id ? 'selected' : '' }}>
                            {{ $formation->nom_formation }}
                        </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Filtre Filière -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filière</label>
                <div class="relative">
                    <select id="filiere_id" name="filiere_id"
    class="w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md appearance-none">
                        <option value="">Toutes les filières</option>
                        @foreach($filieres as $filiere)
                        <option value="{{ $filiere->id }}" data-formation="{{ $filiere->formation_id }}"
                                {{ request('filiere_id') == $filiere->id ? 'selected' : '' }}>
                            {{ $filiere->nom_filiere }}
                        </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Filtre Classe -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                <div class="relative">
                    <select id="classe_id" name="classe_id"
                            class="w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md appearance-none">
                        <option value="">Toutes les classes</option>
                        @foreach($classes->unique('id') as $classe)
                        <option value="{{ $classe->id }}"
                                data-filiere="{{ $classe->filiere ? $classe->filiere->id : '' }}"
                                data-formation="{{ $classe->filiere && $classe->filiere->formation ? $classe->filiere->formation->id : '' }}"
                                {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom_classe }}
                        </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Bouton Filtrer -->
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Filtrer
                </button>
            </div>
        </div>
    </form>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 justify-center">
        <!-- Carte Classes -->
        <div class="bg-white border border-blue-100 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Classes</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $classes->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Carte Cours cette semaine -->
        <div class="bg-white border border-green-100 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-50 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Cours cette semaine</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $coursSemaine }}</p>
                </div>
            </div>
        </div>

        <!-- Carte Enseignants -->
        <div class="bg-white border border-yellow-100 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-50 text-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Enseignants</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $enseignantsCount }}</p>
                </div>
            </div>
        </div>

        <!-- Carte Conflits -->
        <!-- <div class="bg-white border border-red-100 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-50 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Conflits détectés</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $conflitsCount }}</p>
                </div>
            </div>
        </div> -->
    </div>
</div>

    <!-- Affichage des emplois -->
    @if(request('classe_id') && $emploisTemps->isNotEmpty())
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border-b gap-2">
                <h2 class="font-semibold text-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Emploi du temps - {{ $classes->firstWhere('id', request('classe_id'))->nom_classe }}
                </h2>
                <a href="{{ route('responsable.emploi_pdf', ['classeId' => request('classe_id')]) }}">            
                    <span class="mr-1">📥</span> Exporter
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jour</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créneau</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matière</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enseignant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
=======
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jour</th>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($emploisTemps as $emploi)
                        <tr class="hover:bg-gray-50 @if($emploi->statut === 'annule') bg-red-50 @elseif($emploi->statut === 'reporte') bg-yellow-50 @endif">
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($emploi->statut === 'annule')
                                    <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Annulé</span>
                                @elseif($emploi->statut === 'reporte')
                                    <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Reporté</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Prévu</span>
                                @endif
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
                                    <button onclick="openAbsenceModalWithId({{ $emploi->id }})"
                                       class="text-red-600 hover:text-red-900">
                                        Absence
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif(request('classe_id'))
    <div class="bg-white p-8 rounded-lg shadow text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900">Aucun cours programmé</h3>
        <p class="mt-1 text-gray-500">Aucun emploi du temps trouvé pour la classe {{ $classes->firstWhere('id', request('classe_id'))->nom_classe }}.</p>
        <div class="mt-6 flex justify-center space-x-4">
            <a href="{{ route('responsable.create_emploi_complet', ['classe_id' => request('classe_id')]) }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
                Créer un emploi du temps complet
            </a>
            <a href="{{ route('responsable.create', ['classe_id' => request('classe_id')]) }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Ajouter un cours
            </a>
        </div>
    </div>
@else
    <div class="bg-white p-8 rounded-lg shadow text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="mt-2 text-lg font-medium text-gray-900">Aucune classe sélectionnée</h3>
        <p class="mt-1 text-gray-500">Veuillez sélectionner une classe pour afficher son emploi du temps.</p>
    </div>
@endif
</div>

<script>
//     console.log('Formation select:', formationSelect);
// console.log('Filière options:', allFiliereOptions);
// console.log('Classe options:', allClasseOptions);
document.addEventListener('DOMContentLoaded', function() {
    const formationSelect = document.getElementById('formation_id');
    const filiereSelect = document.getElementById('filiere_id');
    const classeSelect = document.getElementById('classe_id');

    // Stocker toutes les options originales
    const allFiliereOptions = Array.from(filiereSelect.querySelectorAll('option'));
    const allClasseOptions = Array.from(classeSelect.querySelectorAll('option'));

    function updateFilieres() {
        const formationId = formationSelect.value;
        const currentFiliereValue = filiereSelect.value;

        // Filtrer les filières
        const filteredFilieres = allFiliereOptions.filter(option => {
            return !option.value || !formationId || option.dataset.formation === formationId;
        });

        // Mettre à jour le select
        filiereSelect.innerHTML = '';
        filteredFilieres.forEach(option => {
            filiereSelect.appendChild(option.cloneNode(true));
        });

        // Restaurer la sélection si possible
        if (currentFiliereValue && filiereSelect.querySelector(`option[value="${currentFiliereValue}"]`)) {
            filiereSelect.value = currentFiliereValue;
        }

        updateClasses();
    }

    function updateClasses() {
        const formationId = formationSelect.value;
        const filiereId = filiereSelect.value;
        const currentClasseValue = classeSelect.value;

        // Filtrer les classes
        const filteredClasses = allClasseOptions.filter(option => {
            if (!option.value) return true; // Garder l'option par défaut
            
            if (filiereId) {
                return option.dataset.filiere === filiereId;
            } else if (formationId) {
                return option.dataset.formation === formationId;
            }
            return true;
        });

        // Mettre à jour le select
        classeSelect.innerHTML = '';
        filteredClasses.forEach(option => {
            classeSelect.appendChild(option.cloneNode(true));
        });

        // Restaurer la sélection si possible
        if (currentClasseValue && classeSelect.querySelector(`option[value="${currentClasseValue}"]`)) {
            classeSelect.value = currentClasseValue;
        }
    }

    // Écouteurs d'événements
    formationSelect.addEventListener('change', updateFilieres);
    filiereSelect.addEventListener('change', updateClasses);

    // Initialisation
    updateFilieres();
});
</script>
</x-admin>