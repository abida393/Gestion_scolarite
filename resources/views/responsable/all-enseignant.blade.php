<x-admin titre="ajouter-etudiant" page_titre="ajouter-etudiant"
    :nom_complete="Auth::guard('responsable')->user()->respo_nom . ', ' . Auth::guard('responsable')->user()->respo_prenom">

    <div class="container py-10">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                <span class="text-blue-600">{{ $enseignant->enseignant_prenom }}</span> {{ $enseignant->enseignant_nom }}
            </h1>
            <p class="text-gray-500 text-lg">
                <i class="fas fa-user-tie mr-2 text-blue-500"></i> Enseignant · {{ $enseignant->enseignant_specialite }}
            </p>
        </div>

        <!-- Card Container -->
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden divide-y divide-gray-200">
            <!-- Section: Personal Info -->
            <section class="p-8">
                <h2 class="text-xl font-semibold text-blue-600 mb-6 flex items-center">
                    <i class="fas fa-id-card mr-2"></i> Informations Personnelles
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-info label="CIN" :value="$enseignant->enseignant_cin" />
                    <x-info label="Sexe" :value="$enseignant->enseignant_sexe" />
                    <x-info label="Nationalité" :value="$enseignant->enseignant_nationalite" />
                    <x-info label="Date de Naissance" :value="$enseignant->enseignant_date_naissance" />
                    <x-info label="Lieu de Naissance" :value="$enseignant->enseignant_lieu_naissance" />
                </div>
            </section>

            <!-- Section: Contact Info -->
            <section class="p-8 bg-gray-50">
                <h2 class="text-xl font-semibold text-blue-600 mb-6 flex items-center">
                    <i class="fas fa-address-book mr-2"></i> Informations de Contact
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-info label="Téléphone" :value="$enseignant->enseignant_tel" />
                    <x-info label="Email" :value="$enseignant->enseignant_email" />
                    <x-info label="Adresse" :value="$enseignant->enseignant_adresse_postale" />
                    <x-info label="CNSS" :value="$enseignant->enseignant_cnss" />
                </div>
            </section>

            <!-- Section: Career Info -->
            <section class="p-8">
                <h2 class="text-xl font-semibold text-blue-600 mb-6 flex items-center">
                    <i class="fas fa-briefcase mr-2"></i> Carrière
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-info label="Contrat" :value="$enseignant->enseignant_contrat" />
                    <x-info label="Date d'Embauche" :value="$enseignant->enseignant_date_embauche" />
                    <x-info label="Statut" :value="$enseignant->enseignant_permanent_vacataire" />
                    <x-info label="Fonction" :value="$enseignant->enseignant_fonction_principale" />
                </div>
            </section>

            <!-- Section: Diplômes + Employeur -->
            <section class="p-8 bg-gray-50">
                <h2 class="text-xl font-semibold text-blue-600 mb-6 flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i> Diplômes
                </h2>
                <p class="text-gray-700 mb-6">{{ $enseignant->enseignant_diplomes }}</p>

                <h2 class="text-xl font-semibold text-blue-600 mb-4 flex items-center">
                    <i class="fas fa-building mr-2"></i> Employeur
                </h2>
                <p class="text-gray-700">{{ $enseignant->enseignant_employeur_principal }}</p>
            </section>

            <!-- Section: Financial Info -->
            <section class="p-8">
                <h2 class="text-xl font-semibold text-blue-600 mb-6 flex items-center">
                    <i class="fas fa-money-bill-wave mr-2"></i> Informations Financières
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-info label="Salaire" :value="$enseignant->enseignant_salaire . ' MAD'" />
                    <x-info label="Type de Paiement" :value="$enseignant->enseignant_type_paiement" />
                    <x-info label="Banque" :value="$enseignant->enseignant_banque" />
                    <x-info label="RIB" :value="$enseignant->enseignant_rib" />
                </div>
            </section>
        </div>
    </div>

</x-admin>
