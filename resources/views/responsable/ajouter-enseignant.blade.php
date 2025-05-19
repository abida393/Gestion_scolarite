<x-admin titre="ajouter-etudiant" page_titre="ajouter-etudiant" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ',' . Auth::guard('responsable')->user()->respo_prenom">
    <div class="container mx-auto">
        <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <!-- En-tête du formulaire -->
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">Ajouter un Nouvel Enseignant</h2>
            </div>

            <!-- Contenu du formulaire -->
            <form action="{{ route('admin.enseignants.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf

                <!-- Section Informations Personnelles -->
                <div class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50">
                    <h3 class="text-lg font-semibold text-blue-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                        Informations Personnelles
                    </h3>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Ligne 1 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Nom -->
                            <div>
                                <label for="enseignant_nom" class="block text-sm font-medium text-gray-700 ">Nom</label>
                                <input type="text" id="enseignant_nom" name="enseignant_nom"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_nom') }}">
                                @error('enseignant_nom')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Prénom -->
                            <div>
                                <label for="enseignant_prenom"
                                    class="block text-sm font-medium text-gray-700 ">Prénom</label>
                                <input type="text" id="enseignant_prenom" name="enseignant_prenom"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_prenom') }}">
                                @error('enseignant_prenom')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Sexe -->
                            <div>
                                <label for="enseignant_sexe"
                                    class="block text-sm font-medium text-gray-700 ">Sexe</label>
                                <select id="enseignant_sexe" name="enseignant_sexe"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_sexe') }}">
                                    <option value="">Sélectionner</option>
                                    <option value="Masculin">Masculin</option>
                                    <option value="Féminin">Féminin</option>
                                </select>
                                @error('enseignant_sexe')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Ligne 2 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Nationalité -->
                            <div>
                                <label for="enseignant_nationalite"
                                    class="block text-sm font-medium text-gray-700 ">Nationalité</label>
                                <input type="text" id="enseignant_nationalite" name="enseignant_nationalite"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_nationalite') }}">
                                @error('enseignant_nationalite')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- CIN -->
                            <div>
                                <label for="enseignant_cin" class="block text-sm font-medium text-gray-700 ">CIN</label>
                                <input type="text" id="enseignant_cin" name="enseignant_cin"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_cin') }}">
                                @error('enseignant_cin')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- CNSS -->
                            <div>
                                <label for="enseignant_cnss" class="block text-sm font-medium text-gray-700">Numéro
                                    CNSS</label>
                                <input type="text" id="enseignant_cnss" name="enseignant_cnss"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_cnss') }}">
                                @error('enseignant_cnss')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Ligne 3 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Date de naissance -->
                            <div>
                                <label for="enseignant_date_naissance"
                                    class="block text-sm font-medium text-gray-700 ">Date de naissance</label>
                                <input type="date" id="enseignant_date_naissance" name="enseignant_date_naissance"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_date_naissance') }}">
                                @error('enseignant_date_naissance')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Lieu de naissance -->
                            <div>
                                <label for="enseignant_lieu_naissance"
                                    class="block text-sm font-medium text-gray-700 ">Lieu de naissance</label>
                                <input type="text" id="enseignant_lieu_naissance" name="enseignant_lieu_naissance"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_lieu_naissance') }}">
                                @error('enseignant_lieu_naissance')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Diplômes et Spécialité -->
                <div class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50">
                    <h3 class="text-lg font-semibold text-blue-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                        Diplômes et Spécialité
                    </h3>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Diplômes -->
                        <div>
                            <label for="enseignant_diplomes"
                                class="block text-sm font-medium text-gray-700 ">Diplômes</label>
                            <textarea id="enseignant_diplomes" name="enseignant_diplomes" rows="3"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('enseignant_diplomes') }}</textarea>
                            @error('enseignant_diplomes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Spécialité -->
                        <div>
                            <label for="enseignant_specialite"
                                class="block text-sm font-medium text-gray-700 ">Spécialité</label>
                            <input type="text" id="enseignant_specialite" name="enseignant_specialite"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_specialite') }}">
                            @error('enseignant_specialite')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Informations de Contact -->
                <div class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50">
                    <h3 class="text-lg font-semibold text-blue-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        Informations de Contact
                    </h3>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Téléphone -->
                        <div>
                            <label for="enseignant_tel"
                                class="block text-sm font-medium text-gray-700 ">Téléphone</label>
                            <input type="tel" id="enseignant_tel" name="enseignant_tel"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_tel') }}">
                            @error('enseignant_tel')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Adresse -->
                        <div>
                            <label for="enseignant_adresse_postale"
                                class="block text-sm font-medium text-gray-700 ">Adresse Postale</label>
                            <input type="text" id="enseignant_adresse_postale" name="enseignant_adresse_postale"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_adresse_postale') }}">
                            @error('enseignant_adresse_postale')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="enseignant_email"
                                class="block text-sm font-medium text-gray-700 ">Email</label>
                            <input type="email" id="enseignant_email" name="enseignant_email"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_email') }}">
                            @error('enseignant_email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Informations Professionnelles -->
                <div class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50">
                    <h3 class="text-lg font-semibold text-blue-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                clip-rule="evenodd" />
                            <path
                                d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                        </svg>
                        Informations Professionnelles
                    </h3>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Ligne 1 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Type de contrat -->
                            <div>
                                <label for="enseignant_contrat" class="block text-sm font-medium text-gray-700 ">Type
                                    de Contrat</label>
                                <select id="enseignant_contrat" name="enseignant_contrat"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_contrat') }}">
                                    <option value="">Sélectionner</option>
                                    <option value="CDI">CDI</option>
                                    <option value="CDD">CDD</option>
                                </select>
                                @error('enseignant_contrat')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Date d'embauche -->
                            <div>
                                <label for="enseignant_date_embauche"
                                    class="block text-sm font-medium text-gray-700 ">Date d'embauche</label>
                                <input type="date" id="enseignant_date_embauche" name="enseignant_date_embauche"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_date_embauche') }}">
                                @error('enseignant_date_embauche')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Salaire -->
                            <div>
                                <label for="enseignant_salaire"
                                    class="block text-sm font-medium text-gray-700 ">Salaire</label>
                                <input type="text" id="enseignant_salaire" name="enseignant_salaire"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_salaire') }}">
                                @error('enseignant_salaire')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Ligne 2 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Statut -->
                            <div>
                                <label for="enseignant_permanent_vacataire"
                                    class="block text-sm font-medium text-gray-700 ">Statut</label>
                                <select id="enseignant_permanent_vacataire" name="enseignant_permanent_vacataire"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_permanent_vacataire') }}">
                                    <option value="">Sélectionner</option>
                                    <option value="Permanent">Permanent</option>
                                    <option value="Vacataire">Vacataire</option>
                                </select>
                                @error('enseignant_permanent_vacataire')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Fonction principale -->
                            <div>
                                <label for="enseignant_fonction_principale"
                                    class="block text-sm font-medium text-gray-700 ">Fonction Principale</label>
                                <input type="text" id="enseignant_fonction_principale"
                                    name="enseignant_fonction_principale"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_fonction_principale') }}">
                                @error('enseignant_fonction_principale')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Employeur principal -->
                        <div>
                            <label for="enseignant_employeur_principal"
                                class="block text-sm font-medium text-gray-700">Employeur Principal</label>
                            <input type="text" id="enseignant_employeur_principal"
                                name="enseignant_employeur_principal"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_employeur_principal') }}">
                            @error('enseignant_employeur_principal')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Informations Bancaires -->
                <div class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50">
                    <h3 class="text-lg font-semibold text-blue-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                            <path fill-rule="evenodd"
                                d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Informations Bancaires
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Type de paiement -->
                        <div>
                            <label for="enseignant_type_paiement" class="block text-sm font-medium text-gray-700">Type
                                de Paiement</label>
                            <input type="text" id="enseignant_type_paiement" name="enseignant_type_paiement"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_type_paiement') }}">
                            @error('enseignant_type_paiement')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Banque -->
                        <div>
                            <label for="enseignant_banque"
                                class="block text-sm font-medium text-gray-700">Banque</label>
                            <input type="text" id="enseignant_banque" name="enseignant_banque"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_banque') }}">
                            @error('enseignant_banque')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- RIB -->
                        <div>
                            <label for="enseignant_rib" class="block text-sm font-medium text-gray-700">RIB</label>
                            <input type="text" id="enseignant_rib" name="enseignant_rib"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" value="{{ old('enseignant_rib') }}">
                            @error('enseignant_rib')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions du formulaire -->
                <div class="flex justify-end space-x-4 mt-8">
                    <button type="reset"
                        class="px-6 py-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Réinitialiser
                    </button>
                    <button type="submit"
                        class="px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Enregistrer l'Enseignant
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin>
