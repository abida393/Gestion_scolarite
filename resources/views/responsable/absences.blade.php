<x-admin titre="Gestion des Absences" page_titre="Gestion des Absences" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom">
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex items-center mb-8">
        <div class="bg-blue-600 text-white p-4 rounded-xl mr-4">
            <i class="fas fa-calendar-times text-2xl"></i>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Absences</h1>
            <p class="text-gray-600">Suivi des absences et justifications</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex border-b border-gray-200 mb-6">
        <a href="{{ route('responsable.absences') }}" class="py-3 px-6 font-medium text-sm border-b-2 border-blue-500 text-blue-600">
            <i class="fas fa-list-check mr-2"></i>Toutes les absences
        </a>
        <a href="{{ route('responsable.absences.justifications') }}" class="py-3 px-6 font-medium text-sm text-gray-500 hover:text-blue-500">
            <i class="fas fa-clock-rotate-left mr-2"></i>Justifications en attente
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-semibold text-lg text-gray-800 flex items-center">
                <i class="fas fa-table-cells-large text-blue-500 mr-2"></i>
                Liste des absences
            </h3>
            <div class="flex space-x-2">
                <a href="{{ route('responsable.absences.create') }}" class="btn-blue">
                    <i class="fas fa-plus mr-1"></i> Ajouter
                </a>
                <a href="{{ route('responsable.absences.export') }}" class="btn-green">
                    <i class="fas fa-file-excel mr-1"></i> Exporter
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Séance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($absences as $absence)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-medium">
                                    {{ substr($absence->etudiant->etudiant_prenom, 0, 1) }}{{ substr($absence->etudiant->etudiant_nom, 0, 1) }}
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
                        <td class="px-6 py-4 whitespace-nowrap">
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
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('responsable.absences.edit', $absence->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-pen"></i>
                                </a>
                                @if($absence->justification_file)
                                <a href="{{ route('responsable.absences.download', $absence->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-download"></i>
                                </a>
                                @endif
                                <form action="{{ route('responsable.absences.destroy', $absence->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
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
        <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Affichage de <span class="font-medium">{{ $absences->firstItem() }}</span> à <span class="font-medium">{{ $absences->lastItem() }}</span> sur <span class="font-medium">{{ $absences->total() }}</span> résultats
            </div>
            <div class="flex">
                {{ $absences->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .btn-blue {
        @apply bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors;
    }
    .btn-green {
        @apply bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors;
    }
</style>

</x-admin>