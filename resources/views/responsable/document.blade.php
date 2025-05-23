<x-admin titre="Page demandes documents" page_titre="Page demandes documents" :nom_complete="Auth::guard('responsable')->user()?->respo_nom . ' ' . Auth::guard('responsable')->user()?->respo_prenom">
    <!-- Header -->
    <div class="text-center mb-12">
        <div
            class="inline-flex items-center justify-center w-20 h-20 mb-6 rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 shadow-lg">
            <i class="fas fa-file-import text-3xl text-white"></i>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            Gestion des <span
                class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Documents</span>
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Organisez et mettez les demandes des etudiants en toute
            simplicité</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Filter Section - Single Row -->
        <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-slate-200">
            <div class="flex flex-col gap-6">
                <h2 class="text-2xl font-bold text-slate-800">Toutes les Demandes</h2>

                <!-- Search Bar -->
                <div class="relative w-full max-w-2xl">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="student-search"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="Rechercher par nom ou email étudiant..." autocomplete="off">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 hidden" id="clear-search">
                        <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="flex flex-wrap gap-2">
                    <button
                        class="status-filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white text-slate-600 transition-all border border-slate-200"
                        data-status="all">
                        Tous
                    </button>
                    <button
                        class="status-filter-btn px-4 py-2 rounded-full font-medium bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition-all"
                        data-status="demande-recue">
                        Demandes reçues
                    </button>
                    <button
                        class="status-filter-btn px-4 py-2 rounded-full font-medium bg-blue-100 text-blue-700 hover:bg-blue-200 transition-all"
                        data-status="en-preparation">
                        En préparation
                    </button>
                    <button
                        class="status-filter-btn px-4 px-4 py-2 rounded-full font-medium bg-purple-100 text-purple-700 hover:bg-purple-200 transition-all"
                        data-status="document-pret">
                        Documents prêts
                    </button>
                    <button
                        class="status-filter-btn px-4 py-2 rounded-full font-medium bg-green-100 text-green-700 hover:bg-green-200 transition-all"
                        data-status="termine">
                        Terminés
                    </button>
                    <button
                        class="status-filter-btn px-4 py-2 rounded-full font-medium bg-red-100 text-red-700 hover:bg-red-200 transition-all"
                        data-status="refus">
                        Refusés
                    </button>
                </div>
            </div>
        </div>

        <!-- Requests List -->
        <div class="divide-y divide-slate-200">
            @foreach ($demandes as $demande)
                <div class="request-item p-6 hover:bg-slate-50/30 transition-colors"
                    data-status="{{ $demande->etat_demande }}" data-filiere="{{ $demande->etudiant->filiere_id }}"
                    data-formation="{{ $demande->etudiant->formation_id }}"
                    data-classe="{{ $demande->etudiant->classe_id }}">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <!-- Main Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-lg font-semibold text-slate-800">#{{ $demande->id }}</span>
                                <span
                                    class="status-badge px-3 py-1 rounded-full text-xs font-medium
                                @if ($demande->etat_demande == 'demande-recue') bg-amber-100 text-amber-800 ring-1 ring-amber-300
                                @elseif($demande->etat_demande == 'en-preparation') bg-blue-100 text-blue-800 ring-1 ring-blue-300
                                @elseif($demande->etat_demande == 'document-pret') bg-purple-100 text-purple-800 ring-1 ring-purple-300
                                @elseif($demande->etat_demande == 'termine') bg-emerald-100 text-emerald-800 ring-1 ring-emerald-300
                                @elseif($demande->etat_demande == 'refus') bg-red-100 text-red-800 ring-1 ring-red-300 @endif">
                                    {{ ucfirst(str_replace('-', ' ', $demande->etat_demande)) }}
                                </span>
                            </div>

                            <div class="text-sm text-slate-600 mb-1">
                                <span class="font-medium text-slate-800">{{ $demande->etudiant->etudiant_nom }}
                                    {{ $demande->etudiant->etudiant_prenom }}</span> •
                                {{ $demande->etudiant->email_ecole }}
                            </div>

                            <div class="text-sm text-slate-500">
                                {{ $demande->document->nom_document }} •
                                {{ $demande->etudiant->formation->nom_formation }}
                            </div>
                        </div>

                        <!-- Actions - Boutons icônes circulaires -->
                        <div class="flex items-center gap-2">
                            <button
                                class="edit-btn p-2 bg-white hover:bg-slate-100 text-slate-600 rounded-full transition-colors shadow border border-slate-200"
                                data-id="{{ $demande->id }}" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>

                            <!-- @if ($demande->etat_demande == 'document-pret')
<form action="{{ route('responsable.demande.terminer', $demande->id) }}" method="POST" class="inline">
        @csrf
        <button type="submit"
                class="p-2 bg-white hover:bg-green-100 text-green-600 rounded-full transition-colors shadow border border-slate-200"
                title="Terminer la demande">
            <i class="fas fa-check-circle"></i>
        </button>
    </form>
@endif -->

                            @if ($demande->etat_demande == 'termine')
                                <form action="{{ route('responsable.demande.supprimer', $demande->id) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 bg-white hover:bg-slate-100 text-rose-500 rounded-full transition-colors shadow border border-slate-200"
                                        title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Expanded Details (hidden by default) -->
                    <div class="request-details mt-6 pt-6 border-t border-slate-100 hidden"
                        id="details-{{ $demande->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Student Info -->
                            <div>
                                <h3 class="text-sm font-medium text-slate-500 mb-2">Informations étudiant</h3>
                                <div class="space-y-1">
                                    <p class="text-sm text-slate-800"><span class="font-medium">Nom:</span>
                                        {{ $demande->etudiant->etudiant_nom }}
                                        {{ $demande->etudiant->etudiant_prenom }}</p>
                                    <p class="text-sm text-slate-800"><span class="font-medium">Email:</span>
                                        {{ $demande->etudiant->email_ecole }}</p>
                                    <p class="text-sm text-slate-800"><span class="font-medium">Filière:</span>
                                        {{ $demande->etudiant->filiere->nom_filiere }}</p>
                                    <p class="text-sm text-slate-800"><span class="font-medium">Classe:</span>
                                        {{ $demande->etudiant->classe->nom_classe }}</p>
                                    <p class="text-sm text-slate-800"><span class="font-medium">Numero
                                            telephone:</span> {{ $demande->etudiant->etudiant_tel }}</p>
                                </div>
                            </div>

                            <!-- Request Info -->
                            <div>
                                <h3 class="text-sm font-medium text-slate-500 mb-2">Détails de la demande</h3>
                                <div class="space-y-1">
                                    <p class="text-sm text-slate-800"><span class="font-medium">Document:</span>
                                        {{ $demande->document->nom_document }}</p>
                                    <p class="text-sm text-slate-800"><span class="font-medium">Formation:</span>
                                        {{ $demande->etudiant->formation->nom_formation }}</p>
                                    <p class="text-sm text-slate-800"><span class="font-medium">Année
                                            académique:</span> {{ $demande->annee_academique }}</p>
                                    @if ($demande->etat_demande == 'refus')
                                        <p class="text-sm text-slate-800"><span class="font-medium">Justification du
                                                refus:</span> {{ $demande->justif_refus }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Status Update Form -->
                            <div>
                                <h3 class="text-sm font-medium text-slate-500 mb-2">Mise à jour du statut</h3>
                                <form action="{{ route('responsable.demande.updateEtat', $demande->id) }}"
                                    method="POST" enctype="multipart/form-data" class="space-y-4"
                                    id="update-form-{{ $demande->id }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="relative w-full">
                                        <select name="etat_demande" id="etat_demande-{{ $demande->id }}"
                                            class="status-select w-full appearance-none rounded-lg border border-slate-300 bg-white px-4 py-2 pr-10 text-sm text-slate-700 shadow-sm transition duration-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                            data-id="{{ $demande->id }}">
                                            <option value="demande-recue"
                                                {{ $demande->etat_demande == 'demande-recue' ? 'selected' : '' }}>
                                                Demande reçue</option>
                                            <option value="en-preparation"
                                                {{ $demande->etat_demande == 'en-preparation' ? 'selected' : '' }}>En
                                                préparation</option>
                                            <option value="document-pret"
                                                {{ $demande->etat_demande == 'document-pret' ? 'selected' : '' }}>
                                                Document prêt</option>
                                            <option value="termine"
                                                {{ $demande->etat_demande == 'termine' ? 'selected' : '' }}>Terminé
                                            </option>
                                            <option value="refus"
                                                {{ $demande->etat_demande == 'refus' ? 'selected' : '' }}>Refusé
                                            </option>
                                        </select>

                                        <!-- Icône flèche (chevron) -->
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-500">
                                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.656a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Justification de refus -->
                                    <div id="justif-refus-container-{{ $demande->id }}"
                                        class="{{ $demande->etat_demande == 'refus' ? 'block' : 'hidden' }}">
                                        <label for="justif_refus-{{ $demande->id }}"
                                            class="block text-sm font-medium text-slate-600 mb-1">Justification du
                                            refus</label>
                                        <textarea name="justif_refus" id="justif_refus-{{ $demande->id }}" rows="3"
                                            class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-700 shadow-sm transition duration-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                            placeholder="Veuillez indiquer la raison du refus...">{{ old('justif_refus', $demande->justif_refus) }}</textarea>
                                    </div>

                                    <!-- Upload de document -->
                                    <div id="upload-container-{{ $demande->id }}"
                                        class="{{ $demande->etat_demande == 'termine' ? 'block' : 'hidden' }}">
                                        <label class="block text-sm font-medium text-slate-600 mb-1">Joindre le
                                            document</label>
                                        <input type="file" name="document" id="document-{{ $demande->id }}"
                                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"
                                            {{ $demande->etat_demande == 'termine' && !$demande->fichier ? 'required' : '' }}>

                                        @if ($demande->fichier)
                                            <div class="mt-2">
                                                <p class="text-sm text-slate-500">Fichier existant :</p>
                                                <a href="{{ asset('storage/documents/' . $demande->fichier) }}"
                                                    target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-sm underline">Télécharger</a>
                                            </div>
                                        @endif
                                    </div>

                                    <button type="submit"
                                        class="w-full md:w-auto px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors shadow-sm flex items-center justify-center gap-2 update-btn"
                                        data-id="{{ $demande->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7l-1.5-1.5L9 15l-2-2-1.5 1.5z" />
                                        </svg>
                                        Mettre à jour
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Status Timeline -->
                        <div class="mt-8">
                            <h3 class="text-sm font-medium text-slate-500 mb-4">Progression de la demande</h3>
                            <div class="relative">
                                <!-- Timeline -->
                                <div class="flex flex-col space-y-2">
                                    <div class="flex items-center">
                                        <!-- Demande reçue -->
                                        <div class="flex flex-col items-center mr-4">
                                            <div
                                                class="flex items-center justify-center w-8 h-8 rounded-full bg-amber-500 text-white z-10">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <div class="w-0.5 h-8 bg-slate-200"></div>
                                        </div>
                                        <div class="py-2">
                                            <p class="text-sm font-medium text-slate-800">Demande reçue</p>
                                            @if ($demande->created_at)
                                                <p class="text-xs text-slate-400 mt-1">
                                                    {{ $demande->created_at->format('d/m/Y H:i') }}</p>
                                            @else
                                                <p class="text-xs text-slate-400 mt-1">Date inconnue</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- En préparation -->
                                    <div class="flex items-center">
                                        <div class="flex flex-col items-center mr-4">
                                            <div
                                                class="flex items-center justify-center w-8 h-8 rounded-full {{ $demande->etat_demande == 'en-preparation' || $demande->etat_demande == 'document-pret' || $demande->etat_demande == 'termine' || $demande->etat_demande == 'refus' ? 'bg-blue-500 text-white' : 'bg-slate-200 text-slate-400' }} z-10">
                                                @if (
                                                    $demande->etat_demande == 'en-preparation' ||
                                                        $demande->etat_demande == 'document-pret' ||
                                                        $demande->etat_demande == 'termine' ||
                                                        $demande->etat_demande == 'refus')
                                                    <svg class="w-4 w-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="w-0.5 h-8 bg-slate-200"></div>
                                        </div>
                                        <div class="py-2">
                                            <p class="text-sm font-medium text-slate-800">En préparation</p>
                                            @if (
                                                $demande->etat_demande == 'en-preparation' ||
                                                    $demande->etat_demande == 'document-pret' ||
                                                    $demande->etat_demande == 'termine' ||
                                                    $demande->etat_demande == 'refus')
                                                <p class="text-xs text-slate-500">
                                                    {{ $demande->updated_at->format('d/m/Y H:i') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Document prêt -->
                                    <div class="flex items-center">
                                        <div class="flex flex-col items-center mr-4">
                                            <div
                                                class="flex items-center justify-center w-8 h-8 rounded-full {{ $demande->etat_demande == 'document-pret' || $demande->etat_demande == 'termine' ? 'bg-purple-500 text-white' : 'bg-slate-200 text-slate-400' }} z-10">
                                                @if ($demande->etat_demande == 'document-pret' || $demande->etat_demande == 'termine')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="w-0.5 h-8 bg-slate-200"></div>
                                        </div>
                                        <div class="py-2">
                                            <p class="text-sm font-medium text-slate-800">Document prêt</p>
                                            @if ($demande->etat_demande == 'document-pret' || $demande->etat_demande == 'termine')
                                                <p class="text-xs text-slate-500">
                                                    {{ $demande->updated_at->format('d/m/Y H:i') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Terminé ou Refusé -->
                                    <div class="flex items-center">
                                        <div class="flex flex-col items-center mr-4">
                                            <div
                                                class="flex items-center justify-center w-8 h-8 rounded-full {{ $demande->etat_demande == 'termine' ? 'bg-emerald-500 text-white' : ($demande->etat_demande == 'refus' ? 'bg-red-500 text-white' : 'bg-slate-200 text-slate-400') }} z-10">
                                                @if ($demande->etat_demande == 'termine' || $demande->etat_demande == 'refus')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="py-2">
                                            <p class="text-sm font-medium text-slate-800">
                                                {{ $demande->etat_demande == 'refus' ? 'Refusé' : 'Terminé' }}
                                            </p>
                                            @if ($demande->etat_demande == 'termine' || $demande->etat_demande == 'refus')
                                                <p class="text-xs text-slate-500">
                                                    {{ $demande->updated_at->format('d/m/Y H:i') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Empty State (hidden by default) -->
            <div id="no-requests-message" class="hidden p-12 text-center">
                <div class="mx-auto max-w-md">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-slate-900">Aucune demande trouvée</h3>
                    <p class="mt-1 text-sm text-slate-500">Aucune demande ne correspond aux critères de filtrage
                        sélectionnés.</p>
                    <div class="mt-6">
                        <button id="reset-filters"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Réinitialiser les filtres
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle request details
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const details = document.getElementById(`details-${id}`);
                    details.classList.toggle('hidden');

                    // Scroll to the details if opening
                    if (!details.classList.contains('hidden')) {
                        details.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });
                    }
                });
            });

            // Show/hide file upload or justification based on status
            document.querySelectorAll('.status-select').forEach(select => {
                select.addEventListener('change', function() {
                    const id = this.getAttribute('data-id');
                    const uploadContainer = document.getElementById(`upload-container-${id}`);
                    const justifContainer = document.getElementById(`justif-refus-container-${id}`);

                    if (this.value === 'termine') {
                        uploadContainer.classList.remove('hidden');
                        justifContainer.classList.add('hidden');
                    } else if (this.value === 'refus') {
                        justifContainer.classList.remove('hidden');
                        uploadContainer.classList.add('hidden');
                    } else {
                        uploadContainer.classList.add('hidden');
                        justifContainer.classList.add('hidden');
                    }
                });

                // Initialize visibility on page load
                const id = select.getAttribute('data-id');
                const currentValue = select.value;
                const uploadContainer = document.getElementById(`upload-container-${id}`);
                const justifContainer = document.getElementById(`justif-refus-container-${id}`);

                if (currentValue === 'termine') {
                    uploadContainer.classList.remove('hidden');
                    justifContainer.classList.add('hidden');
                } else if (currentValue === 'refus') {
                    justifContainer.classList.remove('hidden');
                    uploadContainer.classList.add('hidden');
                } else {
                    uploadContainer.classList.add('hidden');
                    justifContainer.classList.add('hidden');
                }
            });

            // Status filter
            document.querySelectorAll('.status-filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const status = this.getAttribute('data-status');

                    // Update active button
                    document.querySelectorAll('.status-filter-btn').forEach(b => {
                        b.classList.remove('bg-blue-500', 'text-white',
                            'border-transparent', 'bg-amber-500', 'bg-purple-500',
                            'bg-emerald-500', 'bg-red-500');
                        b.classList.add('bg-white', 'border');
                    });

                    if (status !== 'all') {
                        const colorMap = {
                            'demande-recue': 'amber',
                            'en-preparation': 'blue',
                            'document-pret': 'purple',
                            'termine': 'emerald',
                            'refus': 'red'
                        };
                        const color = colorMap[status];
                        this.classList.add(`bg-${color}-500`, 'text-white', 'border-transparent');
                        this.classList.remove('bg-white', 'border');
                    }

                    // Filter requests
                    let visibleItems = 0;
                    document.querySelectorAll('.request-item').forEach(item => {
                        if (status === 'all' || item.getAttribute('data-status') ===
                            status) {
                            item.classList.remove('hidden');
                            visibleItems++;
                        } else {
                            item.classList.add('hidden');
                        }
                    });

                    // Show/hide no requests message
                    const noRequestsMessage = document.getElementById('no-requests-message');
                    if (visibleItems === 0) {
                        noRequestsMessage.classList.remove('hidden');
                    } else {
                        noRequestsMessage.classList.add('hidden');
                    }
                });
            });

            // Student search functionality
            document.getElementById('student-search').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const activeStatus = document.querySelector(
                    '.status-filter-btn.bg-blue-500, .status-filter-btn.bg-amber-500, .status-filter-btn.bg-purple-500, .status-filter-btn.bg-emerald-500, .status-filter-btn.bg-red-500'
                    )?.getAttribute('data-status') || 'all';

                // Show/hide clear button
                const clearSearchBtn = document.getElementById('clear-search');
                if (searchTerm.length > 0) {
                    clearSearchBtn.classList.remove('hidden');
                } else {
                    clearSearchBtn.classList.add('hidden');
                }

                let visibleItems = 0;

                document.querySelectorAll('.request-item').forEach(item => {
                    const studentName = item.querySelector('.text-slate-800').textContent
                        .toLowerCase();
                    const studentEmail = item.querySelector('.text-slate-600').textContent
                        .toLowerCase();
                    const itemStatus = item.getAttribute('data-status');

                    const nameMatch = studentName.includes(searchTerm);
                    const emailMatch = studentEmail.includes(searchTerm);
                    const statusMatch = activeStatus === 'all' || itemStatus === activeStatus;

                    if ((nameMatch || emailMatch) && statusMatch) {
                        item.classList.remove('hidden');
                        visibleItems++;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                // Show/hide no requests message
                const noRequestsMessage = document.getElementById('no-requests-message');
                if (visibleItems === 0) {
                    noRequestsMessage.classList.remove('hidden');
                } else {
                    noRequestsMessage.classList.add('hidden');
                }
            });

            // Clear search
            document.getElementById('clear-search').addEventListener('click', function() {
                document.getElementById('student-search').value = '';
                this.classList.add('hidden');
                document.getElementById('student-search').dispatchEvent(new Event('input'));
            });

            // Reset filters
            document.getElementById('reset-filters').addEventListener('click', function() {
                // Reset status filter
                document.querySelector('.status-filter-btn[data-status="all"]').click();

                // Reset search
                document.getElementById('student-search').value = '';
                document.getElementById('clear-search').classList.add('hidden');

                // Show all requests
                document.querySelectorAll('.request-item').forEach(item => {
                    item.classList.remove('hidden');
                });

                // Hide no requests message
                document.getElementById('no-requests-message').classList.add('hidden');
            });
        });
    </script>
</x-admin>
