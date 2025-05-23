<x-admin titre="Page Absence" page_titre="Page Absence" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom">
<div class="min-h-screen bg-gray-50 p-6">
    <!-- Header Section -->
    <div class="flex flex-col space-y-4 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Justifications en attente de validation</h1>
        <div class="flex items-center space-x-2">
            <div class="h-1 w-16 bg-blue-500 rounded-full"></div>
            <div class="h-1 w-8 bg-blue-300 rounded-full"></div>
            <div class="h-1 w-4 bg-blue-200 rounded-full"></div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-500 to-blue-600">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-white">Liste des justifications</h2>
        <div class="flex space-x-2">
            <span class="px-3 py-1 bg-blue-400 bg-opacity-20 rounded-full text-white text-sm font-medium">
                {{ count($justifications) }} en attente
            </span>
        </div>
    </div>
</div>

        <!-- Card Body -->
        <div class="p-6">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seance</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Justification</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fichier</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($justifications as $justif)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-medium">{{ substr($justif->etudiant->etudiant_nom, 0, 1) }}{{ substr($justif->etudiant->etudiant_prenom, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $justif->etudiant->etudiant_nom }} {{ $justif->etudiant->etudiant_prenom }}</div>
                                        <div class="text-sm text-gray-500">{{ $justif->etudiant->etudiant_email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                          <td class="px-6 py-4 whitespace-nowrap">
    <div class="text-sm font-medium text-gray-900">
        {{ \Carbon\Carbon::parse($justif->date_absence)->format('d/m/Y ') }}
        —
        {{ $justif->emploiTemps->matiere->nom_matiere ?? 'Inconnue' }}
    </div>
    <div class="text-sm text-gray-500">
        @if($justif->emploiTemps && $justif->emploiTemps->heure_debut && $justif->emploiTemps->heure_fin)
            {{ \Carbon\Carbon::parse($justif->emploiTemps->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($justif->emploiTemps->heure_fin)->format('H:i') }}
        @else
            Horaire inconnu
        @endif
    </div>
</td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate">{{ $justif->justification }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($justif->justification_file)
                                    <a href="{{ route('responsable.absences.download', $justif->id) }}" 
                                       class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Télécharger
                                    </a>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Aucun fichier
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('responsable.absences.validate', $justif->id) }}" method="POST">
                                    @csrf
                                    <div class="flex space-x-2">
                                        <select name="action" class="block w-40 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" required>
                                            <option value="">Choisir...</option>
                                            <option value="accept" class="text-green-600">Accepter</option>
                                            <option value="reject" class="text-red-600">Rejeter</option>
                                            <option value="non_justifier" class="text-yellow-600">Non justifier</option>
                                        </select>
                                        <input type="text" name="commentaire" class="block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Commentaire">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Valider
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune justification en attente</h3>
                                    <p class="mt-1 text-sm text-gray-500">Toutes les justifications ont été traitées.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($justifications->hasPages())
            <div class="mt-6 flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($justifications->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-100 cursor-not-allowed">
                            Précédent
                        </span>
                    @else
                        <a href="{{ $justifications->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Précédent
                        </a>
                    @endif

                    @if($justifications->hasMorePages())
                        <a href="{{ $justifications->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Suivant
                        </a>
                    @else
                        <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-100 cursor-not-allowed">
                            Suivant
                        </span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Affichage de
                            <span class="font-medium">{{ $justifications->firstItem() }}</span>
                            à
                            <span class="font-medium">{{ $justifications->lastItem() }}</span>
                            sur
                            <span class="font-medium">{{ $justifications->total() }}</span>
                            résultats
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            @if($justifications->onFirstPage())
                                <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-300 cursor-not-allowed">
                                    <span class="sr-only">Précédent</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $justifications->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Précédent</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif

                            @foreach($justifications->getUrlRange(1, $justifications->lastPage()) as $page => $url)
                                @if($page == $justifications->currentPage())
                                    <span aria-current="page" class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if($justifications->hasMorePages())
                                <a href="{{ $justifications->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Suivant</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-300 cursor-not-allowed">
                                    <span class="sr-only">Suivant</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</x-admin>