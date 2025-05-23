<x-home titre="absences-page" page_titre="Mes Absences" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ' ' . Auth::guard('etudiant')->user()->etudiant_prenom">
<script src="//unpkg.com/alpinejs" defer></script>
<div class="min-h-screen bg-gray-50">
    <!-- Premium Header with Glassmorphism Effect -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl font-bold text-white drop-shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 inline-block mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Gestion des Absences
                    </h1>
                    <p class="mt-2 text-blue-100 font-light">Suivi et justification de vos absences </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js scope -->
    <div x-data="{ openModal: null, activeTab: 'all' }" x-cloak>
        <!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-8">            <!-- Dashboard Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 truncate">Absences totales</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $absences->total() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 truncate">Justifiées</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $absences->where('Justifier', true)->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 truncate">En attente</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $absences->where('status', 'pending')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <!-- Table Header with Tabs -->
                <div class="px-6 py-5 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Historique des absences
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $absences->total() }} absences enregistrées
                            </p>
                        </div>

                        <div class="flex space-x-3">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <button
                                    @click="activeTab = 'all'"
                                    :class="activeTab === 'all' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                    class="px-4 py-2 text-sm font-medium rounded-l-lg border border-gray-200 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                    Toutes
                                </button>
                                <button
                                    @click="activeTab = 'justified'"
                                    :class="activeTab === 'justified' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                    class="px-4 py-2 text-sm font-medium border-t border-b border-gray-200 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                    Justifiées
                                </button>
                                <button
                                    @click="activeTab = 'pending'"
                                    :class="activeTab === 'pending' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                    class="px-4 py-2 text-sm font-medium border-t border-b border-gray-200 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                    En attente
                                </button>
                                <button
                                    @click="activeTab = 'unjustified'"
                                    :class="activeTab === 'unjustified' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                    class="px-4 py-2 text-sm font-medium rounded-r-lg border border-gray-200 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                >
                                    Non justifiées
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsive Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Séance</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($absences as $absence)
                            <tr class="hover:bg-gray-50 transition-colors duration-150" x-show="
                                activeTab === 'all' ||
                                (activeTab === 'justified' && {{ $absence->Justifier ? 'true' : 'false' }}) ||
                                (activeTab === 'pending' && {{ $absence->status === 'pending' ? 'true' : 'false' }}) ||
                                (activeTab === 'unjustified' && {{ !$absence->Justifier && $absence->status !== 'pending' ? 'true' : 'false' }})
                            ">
                                <!-- Course -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $absence->emploiTemps && $absence->emploiTemps->matiere ? $absence->emploiTemps->matiere->nom_matiere : 'Inconnue' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $absence->classe->nom ?? '' }}
                                                @if($absence->emploiTemps && $absence->emploiTemps->heure_debut && $absence->emploiTemps->heure_fin)
                                                    <span class="ml-2">
                                                        {{ \Carbon\Carbon::parse($absence->emploiTemps->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($absence->emploiTemps->heure_fin)->format('H:i') }}
                                                    </span>
                                                @else
                                                    <span class="ml-2 text-gray-400">Horaire inconnu</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Type -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($absence->type === 'retard')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Retard ({{ $absence->duree_minutes }} min)
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            Absence
                                        </span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($absence->Justifier)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Justifiée
                                        </span>
                                        @if($absence->commentaire_responsable)
                                            <p class="mt-1 text-xs text-gray-500 truncate max-w-xs" title="{{ $absence->commentaire_responsable }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                </svg>
                                                {{ Str::limit($absence->commentaire_responsable, 30) }}
                                            </p>
                                        @endif
                                    @elseif($absence->status === 'pending')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            En attente
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            Non justifiée
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        @if(!$absence->Justifier && $absence->status !== 'pending')
                                            <button
                                                @click="openModal = {{ $absence->id }}"
                                                type="button"
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Justifier
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
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

                <!-- Table Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-sm text-gray-500 mb-4 sm:mb-0">
                        Affichage <span class="font-medium">{{ $absences->firstItem() }}</span> à <span class="font-medium">{{ $absences->lastItem() }}</span>
                        sur <span class="font-medium">{{ $absences->total() }}</span> résultats
                    </div>
                    <div class="flex space-x-2">
                        {{ $absences->links() }}
                    </div>
                </div>
            </div>
        </main>

        <!-- Justification Modals -->
        @foreach($absences as $absence)
            @if(!$absence->Justifier && $absence->status !== 'pending')
            <div
                x-show="openModal === {{ $absence->id }}"
                class="fixed inset-0 z-50  px-9 py-12 mx-8 overflow-y-auto"
                aria-labelledby="modal-title"
                aria-modal="true"
                role="dialog"
            >
                <div class="flex items-end justify-center min-h-screen pt-4 px-4  pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div
                        x-show="openModal === {{ $absence->id }}"
                        @click="openModal = null"
                        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                        aria-hidden="true"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                    ></div>

                    <!-- Modal panel -->
                    <div
                        x-show="openModal === {{ $absence->id }}"
                        class="inline-block align-top bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-top sm:max-w-lg sm:w-full"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <!-- Modal header -->
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-4 py-5 sm:px-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Justifier une absence
                                </h3>
                                <button
                                    @click="openModal = null"
                                    type="button"
                                    class="text-white hover:text-blue-100 focus:outline-none"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Modal body -->
                        <form action="{{ route('etudiant.absences.justifier') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="absence_id" value="{{ $absence->id }}">
                            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="space-y-6">
                                    <!-- Absence Details -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Détails de l'absence</label>
                                        <div class="mt-1 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-600 text-sm">
                                            <div class="grid grid-cols-2 gap-4">

                                                <div>
                                                    <p class="font-medium">Matière</p>
                                                    <p>{{ $absence->emploiTemps && $absence->emploiTemps->matiere ? $absence->emploiTemps->matiere->nom_matiere : 'Inconnue' }}</p>
                                                </div>
                                                <div>
                                                    <p class="font-medium">Type</p>
                                                    <p>{{ $absence->type === 'retard' ? 'Retard' : 'Absence' }}</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Justification Text -->
                                    <div>
                                        <label for="justification" class="block text-sm font-medium text-gray-700 mb-1">
                                            Justification <span class="text-red-500">*</span>
                                        </label>
                                        <textarea
                                            id="justification"
                                            name="justification"
                                            rows="4"
                                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-3"
                                            placeholder="Décrivez précisément la raison de votre absence..."
                                            required
                                        ></textarea>
                                    </div>

                                    <!-- File Upload -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Fichier justificatif <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                                            <div class="space-y-1 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                        <span>Téléverser un fichier</span>
                                                        <input
                                                            type="file"
                                                            name="justification_file"
                                                            class="sr-only"
                                                            required
                                                            accept=".pdf,.jpg,.jpeg,.png"
                                                        >
                                                    </label>
                                                    <p class="pl-1">ou glisser-déposer</p>
                                                </div>
                                                <p class="text-xs text-gray-500">
                                                    PDF, JPG, PNG jusqu'à 2MB
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button
                                    type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Envoyer la justification
                                </button>
                                <button
                                    @click="openModal = null"
                                    type="button"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                >
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>

    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .bg-white\/80 { background-color: rgba(255, 255, 255, 0.8); }
        .border-white\/20 { border-color: rgba(255, 255, 255, 0.2); }
        .backdrop-blur-lg { backdrop-filter: blur(16px); }
    </style>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[name="justification_file"]').forEach(function(fileInput) {
        const label = fileInput.closest('label');
        const span = label.querySelector('span');
        fileInput.addEventListener('change', function () {
            if (fileInput.files.length > 0) {
                span.textContent = fileInput.files[0].name;
            } else {
                span.textContent = "Téléverser un fichier";
            }
        });
    });
});
</script>
</x-home>