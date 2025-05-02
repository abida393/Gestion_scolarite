<x-home titre="Bulletin Scolaire" page_titre="Mon Bulletin" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ' ' . Auth::guard('etudiant')->user()->etudiant_prenom">

    <!-- Conteneur principal avec padding adaptatif -->
    <div class="container mx-auto px-3 sm:px-4 py-5 sm:py-8">
        <!-- En-tête adaptatif -->
        <header class="mb-6 sm:mb-10 text-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary mb-1 sm:mb-2">Mon Bulletin Scolaire</h1>
            <p class="text-dark/80 text-sm sm:text-base">Année académique {{ now()->format('Y') }}</p>
        </header>

        <!-- Profile Card - Redesigned -->
        <div class="bg-white shadow-lg rounded-2xl p-5 sm:p-8 mb-8 mx-3 sm:mx-auto max-w-4xl">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <!-- Avatar -->
                <div
                    class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <span class="text-2xl sm:text-3xl font-bold">
                        {{ substr(Auth::guard('etudiant')->user()->etudiant_nom, 0, 1) }}
                        {{ substr(Auth::guard('etudiant')->user()->etudiant_prenom, 0, 1) }}
                    </span>
                </div>

                <!-- Student Info -->
                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-2xl font-semibold text-dark mb-2">
                        {{ Auth::guard('etudiant')->user()->etudiant_prenom }}
                        {{ Auth::guard('etudiant')->user()->etudiant_nom }}
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">
                        <!-- ID -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-center sm:text-left">
                            <p class="text-xs text-gray-500">N° Étudiant</p>
                            <p class="text-sm font-medium text-dark">{{ Auth::guard('etudiant')->user()->id }}</p>
                        </div>

                        <!-- Filière -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-center sm:text-left">
                            <p class="text-xs text-gray-500">Filière</p>
                            <p class="text-sm font-medium text-dark">
                                {{ $etudiant->filiere->nom_filiere ?? 'Non spécifié' }}</p>
                        </div>

                        <!-- Niveau -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-center sm:text-left">
                            <p class="text-xs text-gray-500">Niveau</p>
                            <p class="text-sm font-medium text-dark">{{ $etudiant->classe->nom_classe }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modules - grille adaptative -->
        <div class="grid grid-cols-1 lg:grid-cols-1  gap-4 sm:gap-6 mb-8 sm:mb-10 px-2 sm:px-0">
            @foreach ($etudiant->notes->groupBy(function ($note) {
        return $note->matiere->module->id;
    }) as $moduleId => $notesModule)
                @php
                    $module = $notesModule->first()->matiere->module;
                    $totalCoefficient = 0;
                    $sommeNotes = 0;
                    $moduleColors = [
                        ['bg-primary', 'text-primary'],
                        ['bg-secondary', 'text-secondary'],
                        ['bg-purple-600', 'text-purple-600'],
                        ['bg-amber-600', 'text-amber-600'],
                    ];
                    $moduleColor = $moduleColors[$loop->index % 4];
                @endphp
                <!-- Carte module - version compacte sur mobile -->
                <div class="bg-white rounded-lg sm:rounded-xl shadow-md sm:shadow-lg overflow-hidden">
                    <!-- En-tête module avec couleur dynamique -->
                    <div class="{{ $moduleColor[0] }} px-4 sm:px-6 py-3 sm:py-4">
                        <h3 class="text-lg sm:text-xl font-bold text-white">{{ $module->nom_module }}</h3>
                    </div>

                    <!-- Contenu module -->
                    <div class="p-3 sm:p-4 md:p-6">
                        <div class="space-y-3 sm:space-y-4">
                            @foreach ($notesModule as $note)
                                @php
                                    $totalCoefficient += $note->matiere->coefficient;
                                    $sommeNotes += $note->note_finale * $note->matiere->coefficient;
                                @endphp

                                <!-- Matière - version compacte sur mobile -->
                                <div class="border-b border-gray-100 sm:border-gray-200 pb-3 sm:pb-4 last:border-0">
                                    <div class="flex justify-between items-start mb-1 sm:mb-2">
                                        <h4 class="font-medium text-dark text-sm sm:text-base">
                                            {{ $note->matiere->nom_matiere }}</h4>
                                        <span
                                            class="px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-medium {{ number_format($note->note_finale,2) >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ number_format($note->note_finale,2) >= 10 ? 'Validé' : 'Non validé' }}
                                        </span>
                                    </div>

                                    <!-- Notes - grille adaptative -->
                                    <div
                                        class="grid grid-cols-{{ $note->matiere->nbre_examen == 2 ? '3' : '2' }} gap-1 sm:gap-2 text-xs sm:text-sm">
                                        <div>
                                            <p class="text-dark/60 text-xs">Exam 1</p>
                                            <p>{{ number_format($note->note1,2) ?? '-' }}</p>
                                        </div>

                                        @if ($note->matiere->nbre_examen == 2)
                                            <div>
                                                <p class="text-dark/60 text-xs">Exam 2</p>
                                                <p>{{ number_format($note->note2,2) ?? '-' }}</p>
                                            </div>
                                        @endif

                                        <div>
                                            <p class="text-dark/60 text-xs">Finale</p>
                                            <p class="font-bold">{{ number_format($note->note_finale,2) }}</p>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <!-- Résumé module -->
                        @php
                            $moyenneModule = $totalCoefficient > 0 ? $sommeNotes / $totalCoefficient : 0;
                        @endphp

                        <div class="mt-4 sm:mt-6 pt-3 sm:pt-4 border-t border-gray-100 sm:border-gray-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-dark/60 text-xs sm:text-sm">Moyenne module</p>
                                    <p class="text-lg sm:text-xl font-bold {{ $moduleColor[1] }}">
                                        {{ number_format($moyenneModule, 2) }}</p>
                                </div>
                                <span
                                    class="px-3 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm font-medium {{ $moyenneModule >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $moyenneModule >= 10 ? 'Validé' : 'Non validé' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Moyenne générale - version compacte sur mobile -->
        @php
            $totalGeneralCoeff = $etudiant->notes->sum(fn($n) => $n->matiere->coefficient);
            $totalGeneralNote = $etudiant->notes->sum(fn($n) => $n->note_finale * $n->matiere->coefficient);
            $moyenneGenerale = $totalGeneralCoeff > 0 ? $totalGeneralNote / $totalGeneralCoeff : 0;

            $progressPercentage = ($moyenneGenerale / 20) * 100;
            $mention = '';
            if ($moyenneGenerale >= 16) {
                $mention = 'Très Bien';
            } elseif ($moyenneGenerale >= 14) {
                $mention = 'Bien';
            } elseif ($moyenneGenerale >= 12) {
                $mention = 'Assez Bien';
            } elseif ($moyenneGenerale >= 10) {
                $mention = 'Admis';
            }
        @endphp

        <div class="bg-white rounded-lg sm:rounded-xl shadow-md sm:shadow-lg p-4 sm:p-6 mx-2 sm:mx-auto max-w-3xl">
            <div class="flex flex-col items-center text-center">
                <p class="text-dark/60 mb-1 sm:mb-2 text-sm sm:text-base">Moyenne générale</p>

                <!-- Graphique circulaire responsive -->
                <div class="relative w-32 h-32 sm:w-40 sm:h-40 mb-3 sm:mb-4">
                    <svg class="w-full h-full" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="45" fill="none" stroke="#E5E7EB" stroke-width="8" />
                        <circle cx="50" cy="50" r="45" fill="none" stroke="#4F46E5" stroke-width="8"
                            stroke-dasharray="283" stroke-dashoffset="283" stroke-linecap="round"
                            style="stroke-dashoffset: calc(283 - (283 * {{ $progressPercentage }}) / 100);" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center flex-col">
                        <span
                            class="text-2xl sm:text-3xl font-bold text-primary">{{ number_format($moyenneGenerale, 2) }}</span>
                        <span class="text-xs sm:text-sm text-dark/60">sur 20</span>
                    </div>
                </div>

                <!-- Mention - taille adaptative -->
                @if ($moyenneGenerale >= 10)
                    <div
                        class="px-4 sm:px-6 py-1 sm:py-2 rounded-full bg-green-100 text-green-800 font-medium text-sm sm:text-base">
                        {{ $mention ?: 'Admis' }}
                    </div>
                    <p class="mt-3 sm:mt-4 text-dark/80 text-xs sm:text-sm">Félicitations pour votre travail cette année
                        !</p>
                @else
                    <div
                        class="px-4 sm:px-6 py-1 sm:py-2 rounded-full bg-red-100 text-red-800 font-medium text-sm sm:text-base">
                        Non admis
                    </div>
                    <p class="mt-3 sm:mt-4 text-dark/80 text-xs sm:text-sm">Nous vous encourageons à persévérer l'année
                        prochaine.</p>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            circle {
                transform: rotate(-90deg);
                transform-origin: 50% 50%;
            }

            /* Optimisation pour très petits écrans */
            @media (max-width: 360px) {
                .container {
                    padding-left: 0.5rem;
                    padding-right: 0.5rem;
                }
            }
        </style>
    @endpush

</x-home>
