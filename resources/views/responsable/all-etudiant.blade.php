<x-admin titre="ajouter-etudiant" page_titre="ajouter-etudiant" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ', ' . Auth::guard('responsable')->user()->respo_prenom">

    <div class="container py-10">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                <span class="text-blue-600">{{ $etudiant->etudiant_prenom }}</span> {{ $etudiant->etudiant_nom }}
            </h1>
            <p class="text-gray-500 text-lg">
                <i class="fas fa-user-graduate mr-2 text-blue-500"></i> Étudiant · {{ $etudiant->type_profile }}
            </p>
        </div>

        <!-- Card Container -->
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden divide-y divide-gray-200">
            <!-- Section: Informations personnelles -->
            <section class="p-8">
                <h2 class="text-xl font-semibold text-blue-600 mb-6 flex items-center">
                    <i class="fas fa-id-card mr-2"></i> Informations Personnelles
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-info label="CIN" :value="$etudiant->etudiant_cin" />
                    <x-info label="Sexe" :value="$etudiant->etudiant_sexe" />
                    <x-info label="Nationalité" :value="$etudiant->etudiant_nationalite" />
                    <x-info label="Date de Naissance" :value="$etudiant->etudiant_date_naissance" />
                    <x-info label="Lieu de Naissance" :value="$etudiant->etudiant_lieu_naissance" />
                    <x-info label="Adresse" :value="$etudiant->etudiant_adresse" />
                    <x-info label="Code Postal" :value="$etudiant->etudiant_code_postal" />
                    <x-info label="Ville" :value="$etudiant->ville" />
                    <x-info label="Photo" :value="$etudiant->PHOTOS" />
                </div>
            </section>

            <!-- Section: Contact -->
            <section class="p-8 bg-gray-50">
                <h2 class="text-xl font-semibold text-blue-600 mb-6 flex items-center">
                    <i class="fas fa-address-book mr-2"></i> Coordonnées
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-info label="Téléphone" :value="$etudiant->etudiant_tel" />
                    <x-info label="Email Personnel" :value="$etudiant->etudiant_email" />
                    <x-info label="Email École" :value="$etudiant->email_ecole" />
                    <x-info label="Identifiant" :value="$etudiant->identifiant" />
                </div>
            </section>

            <!-- Section: Informations Familiales -->
            <section class="p-8">
                <h2 class="text-xl font-semibold text-blue-600 mb-6 flex items-center">
                    <i class="fas fa-users mr-2"></i> Informations Familiales
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-info label="Nom du Père" :value="$etudiant->nom_pere" />
                    <x-info label="Prénom du Père" :value="$etudiant->prenom_pere" />
                    <x-info label="Fonction du Père" :value="$etudiant->fonction_pere" />
                    <x-info label="Téléphone du Père" :value="$etudiant->telephone_pere" />
                    <x-info label="Nom de la Mère" :value="$etudiant->nom_mere" />
                    <x-info label="Prénom de la Mère" :value="$etudiant->prenom_mere" />
                    <x-info label="Fonction de la Mère" :value="$etudiant->fonction_mere" />
                    <x-info label="Téléphone de la Mère" :value="$etudiant->telephone_mere" />
                    <x-info label="CNSS" :value="$etudiant->cnss" />
                </div>
            </section>

            <!-- Section: Informations Académiques -->
            <section class="p-8 bg-gray-50">
                <h2 class="text-xl font-semibold text-blue-600 mb-6 flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i> Parcours Académique
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-info label="CNE" :value="$etudiant->etudiant_cne" />
                    <x-info label="Série du Bac" :value="$etudiant->etudiant_serie_bac" />
                    <x-info label="Mention Bac" :value="$etudiant->etudiant_mention_bac" />
                    <x-info label="Session Bac" :value="$etudiant->etudiant_session_bac" />
                    <x-info label="Année Obtention Bac" :value="$etudiant->annee_obtention_bac" />
                    <x-info label="Formation" :value="$etudiant->formation->nom ?? 'Non spécifiée'" />
                    <x-info label="Classe" :value="$etudiant->classe->nom ?? 'Non spécifiée'" />
                    <x-info label="Filière" :value="$etudiant->filiere->nom ?? 'Non spécifiée'" />
                    <x-info label="Dossier Complet" :value="$etudiant->DOSSIERCOMPLET ? 'Oui' : 'Non'" />
                </div>
            </section>
        </div>
    </div>

</x-admin>
