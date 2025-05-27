<x-admin
    titre="Gestion des Absences"
    page_titre="Tableau de Bord des Absences"
    :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom"
>
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Header Section -->
    <div class="bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex items-start gap-4">
                    <div class="p-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg">
                        <i class="fas fa-calendar-times text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                            Gestion des Absences
                        </h1>
                        <p class="mt-1 text-gray-600">Suivi analytique des présences étudiantes</p>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 w-full md:w-auto">
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
                        <p class="text-xs font-medium text-gray-500">Total Absences</p>
                        <p class="text-xl font-bold text-blue-600">{{ $totalAbsences }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
                        <p class="text-xs font-medium text-gray-500">Justifiées</p>
                        <p class="text-xl font-bold text-green-600">{{ $justifiedAbsences }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
                        <p class="text-xs font-medium text-gray-500">En attente</p>
                        <p class="text-xl font-bold text-yellow-600">{{ $pendingAbsences }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
                        <p class="text-xs font-medium text-gray-500">Non justifiées</p>
                        <p class="text-xl font-bold text-red-600">{{ $unjustifiedAbsences }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Advanced Filter Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
            <div class="p-5">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center mb-4">
                    <i class="fas fa-sliders text-blue-500 mr-2"></i>
                    Filtres Avancés
                </h2>
                <form method="GET" action="{{ route('responsable.absences') }}" id="filter-form">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Classe Filter -->
                        <div>
                            <label for="classe_id" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-chalkboard-user text-blue-400 mr-2"></i>
                                Classe
                            </label>
                            <select name="classe_id" id="classe_id" class="filter-select appearance-none">
                                <option value="">Toutes les classes</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom_classe ?? $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Student Filter -->
                        <div>
                            <label for="etudiant_id" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-user-graduate text-blue-400 mr-2"></i>
                                Étudiant
                            </label>
                            <select name="etudiant_id" id="etudiant_id" class="filter-select appearance-none">
                                <option value="">Tous les étudiants</option>
                                @foreach($classes as $classe)
                                    @foreach($classe->etudiants as $etudiant)
                                        <option value="{{ $etudiant->id }}" {{ request('etudiant_id') == $etudiant->id ? 'selected' : '' }}>
                                            {{ $etudiant->etudiant_prenom }} {{ $etudiant->etudiant_nom }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                                Statut
                            </label>
                            <select name="status" id="status" class="filter-select appearance-none">
                                <option value="">Tous les statuts</option>
                                <option value="justified" {{ request('status') == 'justified' ? 'selected' : '' }}>Justifiées</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="unjustified" {{ request('status') == 'unjustified' ? 'selected' : '' }}>Non justifiées</option>
                            </select>
                        </div>

                        <!-- Type Filter -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                                <i class="fas fa-clock text-blue-400 mr-2"></i>
                                Type d'absence
                            </label>
                            <select name="type" id="type" class="filter-select appearance-none">
                                <option value="">Tous types</option>
                                <option value="absence" {{ request('type') == 'absence' ? 'selected' : '' }}>Absence</option>
                                <option value="retard" {{ request('type') == 'retard' ? 'selected' : '' }}>Retard</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 mt-6">
    <button type="reset"
        class="inline-flex items-center px-4 py-2 rounded-md bg-gray-100 text-gray-700 font-semibold shadow hover:bg-gray-200 hover:text-blue-600 transition focus:outline-none focus:ring-2 focus:ring-blue-400">
        <i class="fas fa-undo mr-2"></i> Réinitialiser
    </button>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 rounded-md bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow hover:from-blue-700 hover:to-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-400">
        <i class="fas fa-filter mr-2"></i> Appliquer
    </button>
</div>
                </form>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <!-- Absence Trends Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-base font-semibold text-gray-800 mb-1">Tendance des absences</h3>
                            <p class="text-xs text-gray-500">Évolution sur 30 jours</p>
                        </div>
                        <div class="p-2 rounded-lg bg-blue-50 text-blue-600">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="mt-4 h-32">
    <div class="flex items-end h-full space-x-1">
        @foreach($absenceTrends as $day)
            <div class="flex-1 flex flex-col items-center">
                <div
                    class="w-full bg-gradient-to-t from-blue-500 to-blue-300 rounded-t-sm"
                    style="height: {{ $day['percentage'] }}%"
                    title="{{ $day['count'] }} absences le {{ $day['date'] }}"
                ></div>
                <span class="text-xs text-gray-500 mt-1">{{ $day['day'] }}</span>
            </div>
        @endforeach
    </div>
</div>
                </div>
            </div>

            <!-- Top Classes Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-base font-semibold text-gray-800 mb-1">Classes avec plus d'absences</h3>
                            <p class="text-xs text-gray-500">Top 5 cette semaine</p>
                        </div>
                        <div class="p-2 rounded-lg bg-red-50 text-red-600">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="mt-4 space-y-3">
                        @foreach($topClasses as $class)
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="font-medium">Classe {{ $class->nom_classe }}</span>
                                <span class="text-gray-600">{{ $class->absences_count ?? 0 }} absences</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div
                                    class="bg-red-500 h-1.5 rounded-full"
                                    style="width: {{ ($maxClassAbsences > 0) ? (($class->absences_count ?? 0) / $maxClassAbsences) * 100 : 0 }}%"
                                ></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    <div class="p-5">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-base font-semibold text-gray-800 mb-1">Actions Rapides</h3>
                <p class="text-xs text-gray-500">Gestion des absences</p>
            </div>
            <div class="p-2 rounded-lg bg-green-50 text-green-600">
                <i class="fas fa-bolt"></i>
            </div>
        </div>
        <div class="mt-3 grid grid-cols-2 gap-2">
            <a href="{{ route('responsable.absences.create') }}" class="quick-action-btn bg-blue-50 text-blue-600 hover:bg-blue-100 py-2 border-radius: var(--radius-xl)">
                <i class="fas fa-plus-circle"></i>
                <span class="text-xs">Nouvelle absence</span>
            </a>
            <a href="{{ route('responsable.absences.justifications') }}" class="quick-action-btn bg-yellow-50 text-yellow-600 hover:bg-yellow-100 py-2 border-radius: var(--radius-xl)">
                <i class="fas fa-clock-rotate-left"></i>
                <span class="text-xs">Justifications</span>
            </a>
            <a href="{{ route('responsable.absences.export.csv') }}" class="quick-action-btn bg-green-50 text-green-600 hover:bg-green-100 py-2 border-radius: var(--radius-xl)">
                <i class="fas fa-file-csv"></i>
                <span class="text-xs">Export CSV</span>
            </a>
            <a href="{{ route('responsable.absences.export.pdf') }}" class="quick-action-btn bg-red-50 text-red-600 hover:bg-red-100 py-2 border-radius: var(--radius-xl)">
                <i class="fas fa-file-pdf"></i>
                <span class="text-xs">Export PDF</span>
            </a>
        </div>
    </div>
</div>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <!-- Card Header -->
            <div class="px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-table-cells-large text-indigo-500 mr-2"></i>
                        Détail des Absences
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $absences->total() }} absences trouvées •
                        <span class="text-green-600">{{ $justifiedAbsences }} justifiées</span> •
                        <span class="text-yellow-600">{{ $pendingAbsences }} en attente</span> •
                        <span class="text-red-600">{{ $unjustifiedAbsences }} non justifiées</span>
                    </p>
                </div>

                <!-- View Toggle -->
                <div class="inline-flex rounded-md shadow-sm space-x-2">
    <button type="button" class="view-toggle-btn active" data-view="list">
        <i class="fas fa-list"></i>
    </button>
    <button type="button" class="view-toggle-btn" data-view="grid">
        <i class="fas fa-th-large"></i>
    </button>
</div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto" id="list-view">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" class="bulk-checkbox">
                            </th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Détails</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($absences as $absence)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Checkbox Column -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                <input type="checkbox" class="item-checkbox" value="{{ $absence->id }}">
                            </td>

                            <!-- Student Column -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-9 w-9 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-medium shadow-sm">
                                        {{ substr($absence->etudiant->etudiant_prenom, 0, 1) }}{{ substr($absence->etudiant->etudiant_nom, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $absence->etudiant->etudiant_prenom }} {{ $absence->etudiant->etudiant_nom }}
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center mt-1">
                                            <span class="inline-block w-2 h-2 rounded-full bg-blue-400 mr-1"></span>
                                            Classe {{ $absence->etudiant->classe->nom_classe }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Details Column -->
                            <td class="px-5 py-4">
                                <div class="flex flex-col space-y-2">
                                    <div class="text-sm font-semibold text-gray-900 flex items-center">
                                        <i class="fas fa-book-open text-blue-400 mr-2 text-sm"></i>
                                        {{ $absence->emploiTemps->matiere->nom_matiere ?? 'Inconnue' }}
                                    </div>
                                    <div class="flex flex-wrap gap-x-4 gap-y-2">
                                        <div class="text-xs text-gray-500 flex items-center">
                                            <i class="far fa-calendar-alt text-gray-400 mr-1"></i>
                                            {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center">
                                            <i class="far fa-clock text-gray-400 mr-1"></i>
                                            @if($absence->emploiTemps && $absence->emploiTemps->heure_debut && $absence->emploiTemps->heure_fin)
                                                {{ \Carbon\Carbon::parse($absence->emploiTemps->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($absence->emploiTemps->heure_fin)->format('H:i') }}
                                            @else
                                                Horaire inconnu
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Status Column -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-2">
                                    @if($absence->Justifier)
                                        <span class="status-badge bg-green-100 text-green-800 inline-flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i> Justifiée
                                        </span>
                                        @if($absence->justification_file)
                                        <a href="{{ route('responsable.absences.download', $absence->id) }}" class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
                                            <i class="fas fa-paperclip mr-1"></i> Pièce jointe
                                        </a>
                                        @endif
                                    @elseif($absence->status === 'pending')
                                        <span class="status-badge bg-yellow-100 text-yellow-800 inline-flex items-center">
                                            <i class="fas fa-hourglass-half mr-1"></i> En attente
                                        </span>
                                    @else
                                        <span class="status-badge bg-red-100 text-red-800 inline-flex items-center">
                                            <i class="fas fa-times-circle mr-1"></i> Non justifiée
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Actions Column -->
                            <td class="px-5 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('responsable.absences.edit', $absence->id) }}"
                                       class="action-btn bg-blue-50 text-blue-600 hover:bg-blue-100"
                                       title="Modifier">
                                        <i class="fas fa-pencil-alt text-sm"></i>
                                    </a>

                                    @if($absence->justification_file)
                                    <a href="{{ route('responsable.absences.download', $absence->id) }}"
                                       class="action-btn bg-indigo-50 text-indigo-600 hover:bg-indigo-100"
                                       title="Télécharger">
                                        <i class="fas fa-download text-sm"></i>
                                    </a>
                                    @endif

                                    <form action="{{ route('responsable.absences.destroy', $absence->id) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette absence?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="action-btn bg-red-50 text-red-600 hover:bg-red-100"
                                                title="Supprimer">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h4 class="text-base font-medium text-gray-500">Aucune absence trouvée</h4>
                                    <p class="mt-1 text-xs">Vos résultats d'absence apparaîtront ici</p>
                                    <a href="{{ route('responsable.absences.create') }}" class="mt-3 inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-plus-circle mr-1"></i> Ajouter une absence
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Grid View (Hidden by Default) -->
            <div id="grid-view" class="hidden p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($absences as $absence)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <div class="p-4">
                        <!-- Student Header -->
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-medium shadow-sm">
                                {{ substr($absence->etudiant->etudiant_prenom, 0, 1) }}{{ substr($absence->etudiant->etudiant_nom, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-semibold text-gray-900">
                                    {{ $absence->etudiant->etudiant_prenom }} {{ $absence->etudiant->etudiant_nom }}
                                </h3>
                                <p class="text-xs text-gray-500">
                                    Classe {{ $absence->etudiant->classe->nom_classe }}
                                </p>
                            </div>
                        </div>

                        <!-- Absence Details -->
                        <div class="mt-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-xs font-medium text-gray-500">Module</h4>
                                    <p class="text-sm font-medium text-gray-900 mt-1">
                                        {{ $absence->emploiTemps->matiere->nom_matiere ?? 'Inconnue' }}
                                    </p>
                                </div>
                                <div>
                                    <h4 class="text-xs font-medium text-gray-500">Date</h4>
                                    <p class="text-sm font-medium text-gray-900 mt-1">
                                      {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-3">
                                <h4 class="text-xs font-medium text-gray-500">Horaire</h4>
                                <p class="text-sm font-medium text-gray-900 mt-1">
                                    @if($absence->emploiTemps && $absence->emploiTemps->heure_debut && $absence->emploiTemps->heure_fin)
                                        {{ \Carbon\Carbon::parse($absence->emploiTemps->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($absence->emploiTemps->heure_fin)->format('H:i') }}
                                    @else
                                        Horaire inconnu
                                    @endif
                                </p>
                            </div>

                            @if($absence->type === 'retard')
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Retard de {{ $absence->duree_minutes }} minutes
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Status & Actions -->
                        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between items-center">
                            <div>
                                @if($absence->Justifier)
                                    <span class="status-badge bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Justifiée
                                    </span>
                                @elseif($absence->status === 'pending')
                                    <span class="status-badge bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-hourglass-half mr-1"></i> En attente
                                    </span>
                                @else
                                    <span class="status-badge bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Non justifiée
                                    </span>
                                @endif
                            </div>

                            <div class="flex space-x-1">
                                <a href="{{ route('responsable.absences.edit', $absence->id) }}" class="text-blue-600 hover:text-blue-800 p-1">
                                    <i class="fas fa-pencil-alt text-sm"></i>
                                </a>
                                <form action="{{ route('responsable.absences.destroy', $absence->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 p-1">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 py-8 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h4 class="text-base font-medium text-gray-500">Aucune absence trouvée</h4>
                        <p class="mt-1 text-xs">Vos résultats d'absence apparaîtront ici</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Calendar View (Hidden by Default) -->
            <div id="calendar-view" class="hidden p-4">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div id="absence-calendar" class="p-2"></div>
                </div>
            </div>

            <!-- Pagination -->
            @if($absences->hasPages())
            <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="text-xs text-gray-500">
                    Affichage <span class="font-medium">{{ $absences->firstItem() }}</span> à <span class="font-medium">{{ $absences->lastItem() }}</span>
                    sur <span class="font-medium">{{ $absences->total() }}</span> résultats
                </div>
                <div class="flex">
                    {{ $absences->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .filter-select {
        @apply w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }

    .filter-input {
        @apply w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm;
    }

    .apply-btn {
        @apply inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500;
    }

    .reset-btn {
        @apply inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500;
    }

    .status-badge {
        @apply inline-flex items-center px-2 py-0.5 rounded text-xs font-medium;
    }

    .view-toggle-btn {
        @apply px-3 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 focus:z-10 focus:outline-none;
    }

    .view-toggle-btn:first-child {
        @apply rounded-l-md;
    }

    .view-toggle-btn:last-child {
        @apply rounded-r-md;
    }

    .view-toggle-btn.active {
        @apply bg-blue-500 text-white border-blue-500;
    }

    .action-btn {
        @apply inline-flex items-center justify-center p-1.5 rounded-md hover:bg-gray-100;
    }

    .quick-action-btn {
        @apply flex flex-col items-center justify-center p-2 rounded-lg hover:shadow-sm text-center;
    }

    .quick-action-btn i {
        @apply text-lg mb-1;
    }

    .bulk-checkbox, .item-checkbox {
        @apply h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500;
    }
</style>

<!-- Scripts -->
<script>
    window.classesData = @json($classes);
    document.addEventListener('DOMContentLoaded', function() {
        // View toggle functionality
        const viewToggleButtons = document.querySelectorAll('.view-toggle-btn');
        const views = {
            'list': document.getElementById('list-view'),
            'grid': document.getElementById('grid-view'),
            'calendar': document.getElementById('calendar-view')
        };

        viewToggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const view = this.getAttribute('data-view');

                // Update active button
                viewToggleButtons.forEach(btn => btn.classList.remove('active', 'bg-blue-500', 'text-white', 'border-blue-500'));
                this.classList.add('active', 'bg-blue-500', 'text-white', 'border-blue-500');

                // Show selected view
                Object.values(views).forEach(viewEl => viewEl.classList.add('hidden'));
                views[view].classList.remove('hidden');

                // Initialize calendar if needed
                if (view === 'calendar' && !window.calendarInitialized) {
                    initAbsenceCalendar();
                    window.calendarInitialized = true;
                }
            });
        });

        // Initialize calendar
        function initAbsenceCalendar() {
            const calendarEl = document.getElementById('absence-calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    @foreach($absences as $absence)
                    {
                        title: '{{ $absence->etudiant->etudiant_prenom }} {{ $absence->etudiant->etudiant_nom }}',
                        start: '{{ \Carbon\Carbon::parse($absence->date_absence)->format('Y-m-d') }}',
                        color: '{{ $absence->Justifier ? '#10B981' : ($absence->status === 'pending' ? '#F59E0B' : '#EF4444') }}',
                        url: '{{ route('responsable.absences.edit', $absence->id) }}'
                    },
                    @endforeach
                ],
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    window.location.href = info.event.url;
                }
            });
            calendar.render();
        }

        // Bulk select/deselect
        document.querySelector('.bulk-checkbox').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
    const classeSelect = document.getElementById('classe_id');
    const etudiantSelect = document.getElementById('etudiant_id');
    const classes = window.classesData;

    function updateEtudiants() {
        const classeId = classeSelect.value;
        etudiantSelect.innerHTML = '<option value="">Tous les étudiants</option>';
        if (!classeId) return;
        const classe = classes.find(c => c.id == classeId);
        if (classe && classe.etudiants) {
            classe.etudiants.forEach(etudiant => {
                const option = document.createElement('option');
                option.value = etudiant.id;
                option.textContent = etudiant.etudiant_prenom + ' ' + etudiant.etudiant_nom;
                etudiantSelect.appendChild(option);
            });
        }
    }

    // Met à jour au changement de classe
    classeSelect.addEventListener('change', updateEtudiants);

    // Si une classe est déjà sélectionnée (ex: retour de filtre), recharge les étudiants
    if (classeSelect.value) {
        updateEtudiants();
        // Remet la sélection si besoin
        const selected = "{{ request('etudiant_id') }}";
        if (selected) etudiantSelect.value = selected;
    }
});

</script>
</x-admin>
