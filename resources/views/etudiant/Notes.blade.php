<x-home titre="Bulletin Scolaire" page_titre="Mon Bulletin" 
         :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ' ' . Auth::guard('etudiant')->user()->etudiant_prenom">

    <!-- Conteneur principal avec padding adaptatif -->
    <div class="container mx-auto px-3 sm:px-4 py-5 sm:py-8">
        <!-- En-tête adaptatif -->
        <header class="mb-6 sm:mb-10 text-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-primary mb-1 sm:mb-2">Mon Bulletin Scolaire</h1>
            <p class="text-dark/80 text-sm sm:text-base">Année académique {{ now()->format('Y') }}</p>
        </header>

        <!-- Carte profil étudiante - version mobile compacte -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-md sm:shadow-lg p-4 sm:p-6 mb-6 sm:mb-10 mx-2 sm:mx-auto max-w-3xl">
            <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                <!-- Avatar - taille réduite sur mobile -->
                <div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-full bg-primary/10 flex items-center justify-center">
                    <span class="text-xl sm:text-2xl md:text-3xl font-bold text-primary">
                        {{ substr(Auth::guard('etudiant')->user()->etudiant_nom, 0, 1) }}{{ substr(Auth::guard('etudiant')->user()->etudiant_prenom, 0, 1) }}
                    </span>
                </div>
                
                <!-- Infos étudiant - empilement vertical sur mobile -->
                <div class="text-center sm:text-left">
                    <h2 class="text-xl sm:text-2xl font-bold text-dark mb-1">
                        {{ Auth::guard('etudiant')->user()->etudiant_prenom }} {{ Auth::guard('etudiant')->user()->etudiant_nom }}
                    </h2>
                    
                    <!-- Grille d'informations responsive -->
                    <div class="grid grid-cols-2 sm:flex flex-wrap justify-center sm:justify-start gap-2 sm:gap-3 mt-2 sm:mt-3">
                        <div class="bg-light rounded-md sm:rounded-lg px-2 sm:px-3 py-1 sm:py-2">
                            <p class="text-xs text-dark/60">N° Étudiant</p>
                            <p class="font-medium text-sm sm:text-base">{{ Auth::guard('etudiant')->user()->id }}</p>
                        </div>
                        <div class="bg-light rounded-md sm:rounded-lg px-2 sm:px-3 py-1 sm:py-2">
                            <p class="text-xs text-dark/60">Filière</p>
                            <p class="font-medium text-sm sm:text-base">{{ $etudiant->filiere->nom_filiere ?? 'Non spécifié' }}</p>
                        </div>
                        <div class="bg-light rounded-md sm:rounded-lg px-2 sm:px-3 py-1 sm:py-2">
                            <p class="text-xs text-dark/60">Niveau</p>
                            <p class="font-medium text-sm sm:text-base">{{ $etudiant->niveau }}</p>
                        </div>
                    </div>
                </div>
            </div>
        <div class="student-info">
            <div><strong>Nom:</strong> {{ $etudiant->etudiant_nom }}</div>
            <div><strong>Prénom:</strong> {{ $etudiant->etudiant_prenom }}</div>
            <div><strong>N° Étudiant:</strong> {{ $etudiant->id }}</div>
            <div><strong>Filière:</strong> {{ $filiere->nom_filiere }}</div>
            <div><strong>Année:</strong> {{ $etudiant->annee }}</div>
        </div>

        <!-- Modules - grille adaptative -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-8 sm:mb-10 px-2 sm:px-0">
            @foreach($etudiant->notes->groupBy(function($note) {
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
                    ['bg-amber-600', 'text-amber-600']
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
                        @foreach($notesModule as $note)
                        @php
                            $totalCoefficient += $note->matiere->coefficient;
                            $sommeNotes += $note->note_finale * $note->matiere->coefficient;
                        @endphp
                        
                        <!-- Matière - version compacte sur mobile -->
                        <div class="border-b border-gray-100 sm:border-gray-200 pb-3 sm:pb-4 last:border-0">
                            <div class="flex justify-between items-start mb-1 sm:mb-2">
                                <h4 class="font-medium text-dark text-sm sm:text-base">{{ $note->matiere->nom_matiere }}</h4>
                                <span class="px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-medium {{ $note->note_finale >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $note->note_finale >= 10 ? 'Validé' : 'Non validé' }}
                                </span>
                            </div>
                            
                            <!-- Notes - grille adaptative -->
                            <div class="grid grid-cols-3 gap-1 sm:gap-2 text-xs sm:text-sm">
                                <div>
                                    <p class="text-dark/60 text-xs">Exam 1</p>
                                    <p>{{ $note->note_exam1 ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-dark/60 text-xs">Exam 2</p>
                                    <p>{{ $note->note_exam2 ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-dark/60 text-xs">Finale</p>
                                    <p class="font-bold">{{ $note->note_finale }}</p>
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
                                <p class="text-lg sm:text-xl font-bold {{ $moduleColor[1] }}">{{ number_format($moyenneModule, 2) }}</p>
                            </div>
                            <span class="px-3 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm font-medium {{ $moyenneModule >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
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
            if ($moyenneGenerale >= 16) $mention = 'Très Bien';
            elseif ($moyenneGenerale >= 14) $mention = 'Bien';
            elseif ($moyenneGenerale >= 12) $mention = 'Assez Bien';
            elseif ($moyenneGenerale >= 10) $mention = 'Admis';
        @endphp

        <div class="bg-white rounded-lg sm:rounded-xl shadow-md sm:shadow-lg p-4 sm:p-6 mx-2 sm:mx-auto max-w-3xl">
            <div class="flex flex-col items-center text-center">
                <p class="text-dark/60 mb-1 sm:mb-2 text-sm sm:text-base">Moyenne générale</p>
                
                <!-- Graphique circulaire responsive -->
                <div class="relative w-32 h-32 sm:w-40 sm:h-40 mb-3 sm:mb-4">
                    <svg class="w-full h-full" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="45" fill="none" stroke="#E5E7EB" stroke-width="8"/>
                        <circle cx="50" cy="50" r="45" fill="none" stroke="#4F46E5" stroke-width="8" 
                                stroke-dasharray="283" stroke-dashoffset="283" stroke-linecap="round"
                                style="stroke-dashoffset: calc(283 - (283 * {{ $progressPercentage }}) / 100);"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center flex-col">
                        <span class="text-2xl sm:text-3xl font-bold text-primary">{{ number_format($moyenneGenerale, 2) }}</span>
                        <span class="text-xs sm:text-sm text-dark/60">sur 20</span>
                    </div>
                </div>
                
                <!-- Mention - taille adaptative -->
                @if($moyenneGenerale >= 10)
                <div class="px-4 sm:px-6 py-1 sm:py-2 rounded-full bg-green-100 text-green-800 font-medium text-sm sm:text-base">
                    {{ $mention ?: 'Admis' }}
                </div>
                <p class="mt-3 sm:mt-4 text-dark/80 text-xs sm:text-sm">Félicitations pour votre travail cette année !</p>
                @else
                <div class="px-4 sm:px-6 py-1 sm:py-2 rounded-full bg-red-100 text-red-800 font-medium text-sm sm:text-base">
                    Non admis
                </div>
                <p class="mt-3 sm:mt-4 text-dark/80 text-xs sm:text-sm">Nous vous encourageons à persévérer l'année prochaine.</p>
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