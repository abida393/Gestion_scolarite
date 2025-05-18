<x-admin 
    titre="Gestion des Absences" 
    page_titre="Gestion des Absences" 
    :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom"
>
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl font-bold text-white">
                        <i class="fas fa-calendar-times mr-2"></i> Gestion des Absences
                    </h1>
                    <p class="mt-2 text-blue-100">Suivi et gestion des absences étudiantes</p>
                </div>
                <!-- <div class="bg-white/10 backdrop-blur-sm rounded-xl px-6 py-3 shadow-sm border border-white/20">
                    <span class="text-white font-medium">
                        <i class="fas fa-user-shield mr-2"></i>
                        {{ Auth::guard('responsable')->user()->respo_nom }}
                    </span>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-10">
        <!-- Filter Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
            <div class="px-6 py-4">
                <form method="GET" action="{{ route('responsable.absences') }}">
                    <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                            <label for="classe_id" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                Filtrer par classe
                            </label>
                            <select 
                                name="classe_id" 
                                id="classe_id" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm"
                            >
                                <option value="">Toutes les classes</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom_classe ?? $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex items-end space-x-3">
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                </svg>
                                Appliquer
                            </button>
                            
                            @if(request('classe_id'))
                            <a 
                                href="{{ route('responsable.absences') }}" 
                                class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                            >
                                Réinitialiser
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex border-b border-gray-200 mb-6">
            <a 
                href="{{ route('responsable.absences') }}" 
                class="py-3 px-6 font-medium text-sm border-b-2 border-blue-500 text-blue-600 flex items-center"
            >
                <i class="fas fa-list-check mr-2"></i>Toutes les absences
            </a>
            <a 
                href="{{ route('responsable.absences.justifications') }}" 
                class="py-3 px-6 font-medium text-sm text-gray-500 hover:text-blue-500 flex items-center"
            >
                <i class="fas fa-clock-rotate-left mr-2"></i>Justifications en attente
            </a>
        </div>

        <!-- Absences Table Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div class="mb-4 sm:mb-0">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-table-cells-large text-blue-500 mr-2"></i>
                        Liste des absences
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $absences->total() }} absences enregistrées
                    </p>
                </div>
                
                <div class="flex space-x-3">
                    <a 
                        href="{{ route('responsable.absences.create') }}" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                    >
                        <i class="fas fa-plus mr-2"></i> Ajouter
                    </a>
                    
                    <!-- Export Dropdown -->
                    <div x-data="{ exportOpen: false }" class="relative">
                        <button 
                            @click="exportOpen = !exportOpen" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200"
                            type="button"
                        >
                            <i class="fas fa-file-export mr-2"></i> Exporter
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div 
                            x-show="exportOpen" 
                            @click.away="exportOpen = false" 
                            class="absolute right-0 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            style="display: none;"
                        >
                            <div class="py-1">
                                <form method="POST" action="{{ route('responsable.absences.export.csv') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    @csrf
                                    <input type="hidden" name="classe_id" value="{{ request('classe_id') }}">
                                    <button type="submit" class="w-full text-left flex items-center">
                                        <i class="fas fa-file-csv text-green-600 mr-2"></i> Export CSV
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('responsable.absences.export.pdf') }}" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    @csrf
                                    <input type="hidden" name="classe_id" value="{{ request('classe_id') }}">
                                    <button type="submit" class="w-full text-left flex items-center">
                                        <i class="fas fa-file-pdf text-red-600 mr-2"></i> Export PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Séance</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($absences as $absence)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Student Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-medium">
                                            {{ substr($absence->etudiant->etudiant_prenom, 0, 1) }}{{ substr($absence->etudiant->etudiant_nom, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $absence->etudiant->etudiant_prenom }} {{ $absence->etudiant->etudiant_nom }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $absence->etudiant->numero_etudiant }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Session Column -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $absence->emploiTemps->matiere->nom_matiere ?? 'Inconnue' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    @if($absence->emploiTemps && $absence->emploiTemps->heure_debut && $absence->emploiTemps->heure_fin)
                                        {{ \Carbon\Carbon::parse($absence->emploiTemps->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($absence->emploiTemps->heure_fin)->format('H:i') }}
                                    @else
                                        Horaire inconnu
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Type Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($absence->type === 'retard')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Retard ({{ $absence->duree_minutes }} min)
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        Absence
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Status Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($absence->Justifier)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Justifiée
                                    </span>
                                @elseif($absence->status === 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-hourglass-half mr-1"></i> En attente
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Non justifiée
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Actions Column -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3">
                                    <a 
                                        href="{{ route('responsable.absences.edit', $absence->id) }}" 
                                        class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                        title="Modifier"
                                    >
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    
                                    @if($absence->justification_file)
                                    <a 
                                        href="{{ route('responsable.absences.download', $absence->id) }}" 
                                        class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200"
                                        title="Télécharger"
                                    >
                                        <i class="fas fa-download"></i>
                                    </a>
                                    @endif
                                    
                                    <form 
                                        action="{{ route('responsable.absences.destroy', $absence->id) }}" 
                                        method="POST" 
                                        class="inline"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette absence?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                            title="Supprimer"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h4 class="text-lg font-medium text-gray-500">Aucune absence enregistrée</h4>
                                    <p class="mt-1 text-sm">Votre historique d'absence apparaîtra ici</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center">
                <div class="text-sm text-gray-500 mb-4 sm:mb-0">
                    Affichage <span class="font-medium">{{ $absences->firstItem() }}</span> à <span class="font-medium">{{ $absences->lastItem() }}</span> 
                    sur <span class="font-medium">{{ $absences->total() }}</span> résultats
                </div>
                <div class="flex">
                    {{ $absences->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    [x-cloak] { display: none !important; }
    .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
    .bg-white\/10 { background-color: rgba(255, 255, 255, 0.1); }
    .border-white\/20 { border-color: rgba(255, 255, 255, 0.2); }
    .backdrop-blur-sm { backdrop-filter: blur(4px); }
</style>
</x-admin>