<x-admin titre="Gestion des Enseignants" page_titre="Liste des Enseignants" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Liste des Enseignants</h1>
        </div>

        <!-- Search and Filter Card -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Bar -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Nom, prénom, spécialité..."
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Tous</option>
                        <option value="Permanent" {{ request('status') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                        <option value="Vacataire" {{ request('status') == 'Vacataire' ? 'selected' : '' }}>Vacataire</option>
                    </select>
                </div>

                <!-- Contract Type Filter -->
                <div>
                    <label for="contract" class="block text-sm font-medium text-gray-700 mb-1">Type de contrat</label>
                    <select name="contract" id="contract" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Tous</option>
                        <option value="CDI" {{ request('contract') == 'CDI' ? 'selected' : '' }}>CDI</option>
                        <option value="CDD" {{ request('contract') == 'CDD' ? 'selected' : '' }}>CDD</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Filtrer
                    </button>
                    @if(request()->has('search') || request()->has('status') || request()->has('contract'))
                    <a href="" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Réinitialiser
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Teachers Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nom & Prénom
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Spécialité
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contrat
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Téléphone
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($enseignants as $enseignant)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <svg class="h-10 w-10 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 14.016q2.531 0 5.273 1.102t3.727 3.867v2.016h-18v-2.016q0-2.766 3.727-3.867t5.273-1.102zM12 12q-2.344 0-3.984-1.641t-1.641-3.984 1.641-3.984 3.984-1.641 3.984 1.641 1.641 3.984-1.641 3.984-3.984 1.641z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $enseignant->enseignant_nom }} {{ $enseignant->enseignant_prenom }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $enseignant->enseignant_email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $enseignant->enseignant_specialite }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $enseignant->enseignant_permanent_vacataire == 'Permanent' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $enseignant->enseignant_permanent_vacataire }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $enseignant->enseignant_contrat }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $enseignant->enseignant_tel }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('responsable.all_enseignant',$enseignant->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Voir</a>
                                <a href="{{ route('enseignants.edit',$enseignant->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucun enseignant trouvé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $enseignants->links() }}
            </div>
        </div>
    </div>
</x-admin>
