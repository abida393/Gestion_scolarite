<x-admin titre="Gestion des Enseignants" page_titre="Modifier Enseignant" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom">
    <div class="container mx-auto px-4 py-6">
        <!-- Header with back button -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Modifier Enseignant</h1>
                <p class="text-sm text-gray-600">Mettez à jour les informations de {{ $enseignant->enseignant_prenom }}
                    {{ $enseignant->enseignant_nom }}</p>
            </div>
            <a href="{{ route('responsable.afficher_enseignant') }}"
                class="flex items-center text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Retour
            </a>
        </div>

        <!-- Main form card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <form action="{{ route('responsable.update_enseignant', $enseignant->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Form tabs for better organization -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button type="button" onclick="switchTab('personal')" id="personal-tab"
                            class="tab-button active py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                            Informations Personnelles
                        </button>
                        <button type="button" onclick="switchTab('professional')" id="professional-tab"
                            class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Informations Professionnelles
                        </button>
                        <button type="button" onclick="switchTab('contact')" id="contact-tab"
                            class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                            Coordonnées & Bancaires
                        </button>
                    </nav>
                </div>

                <div class="p-6">
                    <!-- Personal Information Tab -->
                    <div id="personal-tab-content" class="tab-content active">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Name Fields -->
                            <div>
                                <label for="enseignant_nom"
                                    class="block text-sm font-medium text-gray-700 mb-1">Nom*</label>
                                <input type="text" name="enseignant_nom" id="enseignant_nom"
                                    value="{{ old('enseignant_nom', $enseignant->enseignant_nom) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                @error('enseignant_nom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="enseignant_prenom"
                                    class="block text-sm font-medium text-gray-700 mb-1">Prénom*</label>
                                <input type="text" name="enseignant_prenom" id="enseignant_prenom"
                                    value="{{ old('enseignant_prenom', $enseignant->enseignant_prenom) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                @error('enseignant_prenom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="enseignant_sexe"
                                    class="block text-sm font-medium text-gray-700 mb-1">Sexe*</label>
                                <select name="enseignant_sexe" id="enseignant_sexe"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                    <option value="Masculin"
                                        {{ old('enseignant_sexe', $enseignant->enseignant_sexe) == 'Masculin' ? 'selected' : '' }}>
                                        Masculin</option>
                                    <option value="Féminin"
                                        {{ old('enseignant_sexe', $enseignant->enseignant_sexe) == 'Féminin' ? 'selected' : '' }}>
                                        Féminin</option>
                                </select>
                                @error('enseignant_sexe')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nationality and CIN -->
                            <div>
                                <label for="enseignant_nationalite"
                                    class="block text-sm font-medium text-gray-700 mb-1">Nationalité*</label>
                                <input type="text" name="enseignant_nationalite" id="enseignant_nationalite"
                                    value="{{ old('enseignant_nationalite', $enseignant->enseignant_nationalite) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                @error('enseignant_nationalite')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="enseignant_cin"
                                    class="block text-sm font-medium text-gray-700 mb-1">CIN*</label>
                                <input type="text" name="enseignant_cin" id="enseignant_cin"
                                    value="{{ old('enseignant_cin', $enseignant->enseignant_cin) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                @error('enseignant_cin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="enseignant_cnss"
                                    class="block text-sm font-medium text-gray-700 mb-1">CNSS</label>
                                <input type="text" name="enseignant_cnss" id="enseignant_cnss"
                                    value="{{ old('enseignant_cnss', $enseignant->enseignant_cnss) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200">
                                @error('enseignant_cnss')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Birth Information -->
                            <div>
                                <label for="enseignant_date_naissance"
                                    class="block text-sm font-medium text-gray-700 mb-1">Date Naissance*</label>
                                <input type="date" name="enseignant_date_naissance" id="enseignant_date_naissance"
                                    value="{{ old('enseignant_date_naissance', $enseignant->enseignant_date_naissance) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                @error('enseignant_date_naissance')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="enseignant_lieu_naissance"
                                    class="block text-sm font-medium text-gray-700 mb-1">Lieu Naissance*</label>
                                <input type="text" name="enseignant_lieu_naissance" id="enseignant_lieu_naissance"
                                    value="{{ old('enseignant_lieu_naissance', $enseignant->enseignant_lieu_naissance) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                @error('enseignant_lieu_naissance')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information Tab -->
                    <div id="professional-tab-content" class="tab-content hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Diplomas and Specialty -->
                            <div>
                                <label for="enseignant_diplomes"
                                    class="block text-sm font-medium text-gray-700 mb-1">Diplômes*</label>
                                <input type="text" name="enseignant_diplomes" id="enseignant_diplomes"
                                    value="{{ old('enseignant_diplomes', $enseignant->enseignant_diplomes) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                @error('enseignant_diplomes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="enseignant_specialite"
                                    class="block text-sm font-medium text-gray-700 mb-1">Spécialité*</label>
                                <input type="text" name="enseignant_specialite" id="enseignant_specialite"
                                    value="{{ old('enseignant_specialite', $enseignant->enseignant_specialite) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                @error('enseignant_specialite')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contract Information -->
                            <div>
                                <label for="enseignant_contrat"
                                    class="block text-sm font-medium text-gray-700 mb-1">Type de Contrat*</label>
                                <select name="enseignant_contrat" id="enseignant_contrat"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                    <option value="CDI"
                                        {{ old('enseignant_contrat', $enseignant->enseignant_contrat) == 'CDI' ? 'selected' : '' }}>
                                        CDI</option>
                                    <option value="CDD"
                                        {{ old('enseignant_contrat', $enseignant->enseignant_contrat) == 'CDD' ? 'selected' : '' }}>
                                        CDD</option>
                                </select>
                                @error('enseignant_contrat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="enseignant_date_embauche"
                                    class="block text-sm font-medium text-gray-700 mb-1">Date d'Embauche*</label>
                                <input type="date" name="enseignant_date_embauche" id="enseignant_date_embauche"
                                    value="{{ old('enseignant_date_embauche', $enseignant->enseignant_date_embauche) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                @error('enseignant_date_embauche')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Salary and Status -->
                            <div>
                                <label for="enseignant_salaire"
                                    class="block text-sm font-medium text-gray-700 mb-1">Salaire*</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">MAD</span>
                                    </div>
                                    <input type="text" name="enseignant_salaire" id="enseignant_salaire"
                                        value="{{ old('enseignant_salaire', $enseignant->enseignant_salaire) }}"
                                        class="block w-full pl-12 pr-12 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                        required>
                                </div>
                                @error('enseignant_salaire')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="enseignant_permanent_vacataire"
                                    class="block text-sm font-medium text-gray-700 mb-1">Statut*</label>
                                <select name="enseignant_permanent_vacataire" id="enseignant_permanent_vacataire"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                    <option value="Permanent"
                                        {{ old('enseignant_permanent_vacataire', $enseignant->enseignant_permanent_vacataire) == 'Permanent' ? 'selected' : '' }}>
                                        Permanent</option>
                                    <option value="Vacataire"
                                        {{ old('enseignant_permanent_vacataire', $enseignant->enseignant_permanent_vacataire) == 'Vacataire' ? 'selected' : '' }}>
                                        Vacataire</option>
                                </select>
                                @error('enseignant_permanent_vacataire')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Function and Employer -->
                            <div class="md:col-span-2">
                                <label for="enseignant_fonction_principale"
                                    class="block text-sm font-medium text-gray-700 mb-1">Fonction Principale*</label>
                                <input type="text" name="enseignant_fonction_principale"
                                    id="enseignant_fonction_principale"
                                    value="{{ old('enseignant_fonction_principale', $enseignant->enseignant_fonction_principale) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                @error('enseignant_fonction_principale')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="enseignant_employeur_principal"
                                    class="block text-sm font-medium text-gray-700 mb-1">Employeur Principal*</label>
                                <input type="text" name="enseignant_employeur_principal"
                                    id="enseignant_employeur_principal"
                                    value="{{ old('enseignant_employeur_principal', $enseignant->enseignant_employeur_principal) }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                    required>
                                @error('enseignant_employeur_principal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact and Banking Tab -->
                    <div id="contact-tab-content" class="tab-content hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Contact Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Coordonnées</h3>

                                <div>
                                    <label for="enseignant_tel"
                                        class="block text-sm font-medium text-gray-700 mb-1">Téléphone*</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 flex items-center">
                                            <select name="country_code"
                                                class="h-full py-0 pl-3 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-l-md">
                                                <option>+212</option>
                                            </select>
                                        </div>
                                        <input type="text" name="enseignant_tel" id="enseignant_tel"
                                            value="{{ old('enseignant_tel', $enseignant->enseignant_tel) }}"
                                            class="block w-full pl-16 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                            required>
                                    </div>
                                    @error('enseignant_tel')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="enseignant_adresse_postale"
                                        class="block text-sm font-medium text-gray-700 mb-1">Adresse Postale*</label>
                                    <textarea name="enseignant_adresse_postale" id="enseignant_adresse_postale" rows="3"
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                        required>{{ old('enseignant_adresse_postale', $enseignant->enseignant_adresse_postale) }}</textarea>
                                    @error('enseignant_adresse_postale')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="enseignant_email"
                                        class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                                    <input type="email" name="enseignant_email" id="enseignant_email"
                                        value="{{ old('enseignant_email', $enseignant->enseignant_email) }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                        required>
                                    @error('enseignant_email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Banking Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informations Bancaires
                                </h3>

                                <div>
                                    <label for="enseignant_type_paiement"
                                        class="block text-sm font-medium text-gray-700 mb-1">Mode de Paiement*</label>
                                    <select name="enseignant_type_paiement" id="enseignant_type_paiement"
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200"
                                        required>
                                        <option value="Virement"
                                            {{ old('enseignant_type_paiement', $enseignant->enseignant_type_paiement) == 'Virement' ? 'selected' : '' }}>
                                            Virement Bancaire</option>
                                        <option value="Chèque"
                                            {{ old('enseignant_type_paiement', $enseignant->enseignant_type_paiement) == 'Chèque' ? 'selected' : '' }}>
                                            Chèque</option>
                                        <option value="Espèces"
                                            {{ old('enseignant_type_paiement', $enseignant->enseignant_type_paiement) == 'Espèces' ? 'selected' : '' }}>
                                            Espèces</option>
                                    </select>
                                    @error('enseignant_type_paiement')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="enseignant_banque"
                                        class="block text-sm font-medium text-gray-700 mb-1">Banque</label>
                                    <input type="text" name="enseignant_banque" id="enseignant_banque"
                                        value="{{ old('enseignant_banque', $enseignant->enseignant_banque) }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200">
                                    @error('enseignant_banque')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="enseignant_rib"
                                        class="block text-sm font-medium text-gray-700 mb-1">RIB</label>
                                    <input type="text" name="enseignant_rib" id="enseignant_rib"
                                        value="{{ old('enseignant_rib', $enseignant->enseignant_rib) }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200">
                                    @error('enseignant_rib')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form actions -->
                    <div class="flex justify-end mt-8 space-x-3">
                        <a href="{{ route('responsable.afficher_enseignant') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            Annuler
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab switching functionality
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('active');
            });

            // Deactivate all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected tab content
            document.getElementById(`${tabName}-tab-content`).classList.remove('hidden');
            document.getElementById(`${tabName}-tab-content`).classList.add('active');

            // Activate selected tab button
            document.getElementById(`${tabName}-tab`).classList.add('active', 'border-blue-500', 'text-blue-600');
            document.getElementById(`${tabName}-tab`).classList.remove('border-transparent', 'text-gray-500');
        }
    </script>

    <style>
        /* Smooth transitions for better UX */
        .tab-content {
            transition: opacity 0.3s ease;
        }

        /* Improved input focus states */
        input:focus,
        select:focus,
        textarea:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
    </style>
</x-admin>
