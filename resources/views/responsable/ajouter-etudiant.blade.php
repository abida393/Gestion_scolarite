<x-admin titre="ajouter-etudiant" page_titre="ajouter-etudiant" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ',' . Auth::guard('responsable')->user()->respo_prenom">
    <div class="container mx-auto">
        <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <!-- En-tête du formulaire -->
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">Enregistrer un Nouvel Étudiant</h2>
            </div>

            <!-- Contenu du formulaire -->
            <form action="{{ route('admin.etudiants.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
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
                                <label for="etudiant_nom" class="block text-sm font-medium text-gray-700 ">Nom</label>
                                <input type="text" id="etudiant_nom" name="etudiant_nom"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('etudiant_nom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prénom -->
                            <div>
                                <label for="etudiant_prenom"
                                    class="block text-sm font-medium text-gray-700 ">Prénom</label>
                                <input type="text" id="etudiant_prenom" name="etudiant_prenom"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('etudiant_prenom')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CIN -->
                            <div>
                                <label for="etudiant_cin" class="block text-sm font-medium text-gray-700 ">CIN</label>
                                <input type="text" id="etudiant_cin" name="etudiant_cin"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('etudiant_cin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Ligne 2 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Date de naissance -->
                            <div>
                                <label for="etudiant_date_naissance"
                                    class="block text-sm font-medium text-gray-700 ">Date de Naissance</label>
                                <input type="date" id="etudiant_date_naissance" name="etudiant_date_naissance"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('etudiant_date_naissance')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lieu de naissance -->
                            <div>
                                <label for="etudiant_lieu_naissance"
                                    class="block text-sm font-medium text-gray-700 ">Lieu de Naissance</label>
                                <input type="text" id="etudiant_lieu_naissance" name="etudiant_lieu_naissance"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('etudiant_lieu_naissance')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sexe -->
                            <div>
                                <label for="etudiant_sexe" class="block text-sm font-medium text-gray-700 ">Sexe</label>
                                <select id="etudiant_sexe" name="etudiant_sexe"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Sélectionner le sexe</option>
                                    <option value="Male">Masculin</option>
                                    <option value="Female">Féminin</option>
                                </select>
                                @error('etudiant_sexe')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Ligne 3 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Nationalité -->
                            <div>
                                <label for="etudiant_nationalite"
                                    class="block text-sm font-medium text-gray-700 ">Nationalité</label>
                                <input type="text" id="etudiant_nationalite" name="etudiant_nationalite"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('etudiant_nationalite')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Photo -->
                            <div>
                                <label for="PHOTOS" class="block text-sm font-medium text-gray-700">Photo</label>
                                <input type="file" id="PHOTOS" name="PHOTOS"
                                    class="mt-1 block w-full px-4 py-2 text-sm text-gray-500 rounded-md border border-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @error('PHOTOS')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
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
                        <!-- Adresse -->
                        <div>
                            <label for="etudiant_adresse"
                                class="block text-sm font-medium text-gray-700 ">Adresse</label>
                            <input type="text" id="etudiant_adresse" name="etudiant_adresse"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('etudiant_adresse')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ville et Code Postal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Ville -->
                            <div>
                                <label for="ville" class="block text-sm font-medium text-gray-700 ">Ville</label>
                                <input type="text" id="ville" name="ville"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('ville')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Code Postal -->
                            <div>
                                <label for="etudiant_code_postal" class="block text-sm font-medium text-gray-700">Code
                                    Postal</label>
                                <input type="text" id="etudiant_code_postal" name="etudiant_code_postal"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('etudiant_code_postal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Téléphone et Emails -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Téléphone -->
                            <div>
                                <label for="etudiant_tel" class="block text-sm font-medium text-gray-700 ">Numéro de
                                    Téléphone</label>
                                <input type="tel" id="etudiant_tel" name="etudiant_tel"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('etudiant_tel')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Personnel -->
                            <div>
                                <label for="etudiant_email" class="block text-sm font-medium text-gray-700">Email
                                    Personnel</label>
                                <input type="email" id="etudiant_email" name="etudiant_email"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('etudiant_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Scolaire -->
                            <div>
                                <label for="email_ecole" class="block text-sm font-medium text-gray-700 ">Email
                                    Scolaire</label>
                                <input type="email" id="email_ecole" name="email_ecole"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('email_ecole')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Informations Académiques -->
                <div class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50">
                    <h3 class="text-lg font-semibold text-blue-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                        Informations Académiques
                    </h3>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Formation, Classe, Filière -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Formation -->
                            <div>
                                <label for="formation_id"
                                    class="block text-sm font-medium text-gray-700 ">Formation</label>
                                <select id="formation_id" name="formation_id"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Sélectionner une formation</option>
                                    @foreach ($formations as $formation)
                                        <option value="{{ $formation->id }}">{{ $formation->nom_formation }}</option>
                                    @endforeach
                                </select>
                                @error('formation_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Classe -->
                            <div>
                                <label for="classes_id"
                                    class="block text-sm font-medium text-gray-700 ">Classe</label>
                                <select id="classes_id" name="classes_id"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Sélectionner une classe</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('classes_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Filière -->
                            <div>
                                <label for="filiere_id"
                                    class="block text-sm font-medium text-gray-700 ">Filière</label>
                                <select id="filiere_id" name="filiere_id"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Sélectionner une filière</option>
                                    @foreach ($filieres as $filiere)
                                        <option value="{{ $filiere->id }}">{{ $filiere->nom_filiere }}</option>
                                    @endforeach
                                </select>
                                @error('filiere_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Identifiant, CNE, Mot de passe -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Identifiant Étudiant -->
                            <div>
                                <label for="identifiant" class="block text-sm font-medium text-gray-700 ">Identifiant
                                    Étudiant</label>
                                <input type="text" id="identifiant" name="identifiant"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('identifiant')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CNE -->
                            <div>
                                <label for="etudiant_cne" class="block text-sm font-medium text-gray-700 ">CNE</label>
                                <input type="text" id="etudiant_cne" name="etudiant_cne"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('etudiant_cne')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 ">Mot de
                                    Passe</label>
                                <input type="password" id="password" name="password"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Dossier Complet -->
                        <div class="w-full md:w-1/3">
                            <label for="DOSSIERCOMPLET" class="block text-sm font-medium text-gray-700">Dossier
                                Complet</label>
                            <select id="DOSSIERCOMPLET" name="DOSSIERCOMPLET"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="0">Non</option>
                                <option value="1">Oui</option>
                            </select>
                            @error('DOSSIERCOMPLET')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Informations Baccalauréat -->
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
                        Informations Baccalauréat
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Série Bac -->
                        <div>
                            <label for="etudiant_serie_bac" class="block text-sm font-medium text-gray-700 ">Série
                                Bac</label>
                            <input type="text" id="etudiant_serie_bac" name="etudiant_serie_bac"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('etudiant_serie_bac')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Session Bac -->
                        <div>
                            <label for="etudiant_session_bac" class="block text-sm font-medium text-gray-700 ">Session
                                Bac</label>
                            <input type="text" id="etudiant_session_bac" name="etudiant_session_bac"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('etudiant_session_bac')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mention Bac -->
                        <div>
                            <label for="etudiant_mention_bac" class="block text-sm font-medium text-gray-700 ">Mention
                                Bac</label>
                            <input type="text" id="etudiant_mention_bac" name="etudiant_mention_bac"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('etudiant_mention_bac')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Année Bac -->
                        <div>
                            <label for="annee_obtention_bac" class="block text-sm font-medium text-gray-700 ">Année
                                d'Obtention</label>
                            <input type="date" id="annee_obtention_bac" name="annee_obtention_bac"
                                class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('annee_obtention_bac')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Informations Père -->
                <div class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50">
                    <h3 class="text-lg font-semibold text-blue-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                        Informations du Père
                    </h3>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Nom du Père -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom -->
                            <div>
                                <label for="nom_pere" class="block text-sm font-medium text-gray-700 ">Nom</label>
                                <input type="text" id="nom_pere" name="nom_pere"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('nom_pere')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prénom -->
                            <div>
                                <label for="prenom_pere"
                                    class="block text-sm font-medium text-gray-700 ">Prénom</label>
                                <input type="text" id="prenom_pere" name="prenom_pere"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('prenom_pere')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Détails Père -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Profession -->
                            <div>
                                <label for="fonction_pere"
                                    class="block text-sm font-medium text-gray-700">Profession</label>
                                <input type="text" id="fonction_pere" name="fonction_pere"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('fonction_pere')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div>
                                <label for="telephone_pere" class="block text-sm font-medium text-gray-700 ">Numéro de
                                    Téléphone</label>
                                <input type="tel" id="telephone_pere" name="telephone_pere"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('telephone_pere')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CNSS -->
                            <div>
                                <label for="cnss" class="block text-sm font-medium text-gray-700">Numéro
                                    CNSS</label>
                                <input type="text" id="cnss" name="cnss"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('cnss')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Informations Mère -->
                <div class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50">
                    <h3 class="text-lg font-semibold text-blue-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                        Informations de la Mère
                    </h3>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Nom de la Mère -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom -->
                            <div>
                                <label for="nom_mere" class="block text-sm font-medium text-gray-700 ">Nom</label>
                                <input type="text" id="nom_mere" name="nom_mere"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('nom_mere')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prénom -->
                            <div>
                                <label for="prenom_mere"
                                    class="block text-sm font-medium text-gray-700 ">Prénom</label>
                                <input type="text" id="prenom_mere" name="prenom_mere"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('prenom_mere')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Détails Mère -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Profession -->
                            <div>
                                <label for="fonction_mere"
                                    class="block text-sm font-medium text-gray-700">Profession</label>
                                <input type="text" id="fonction_mere" name="fonction_mere"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('fonction_mere')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Téléphone -->
                            <div>
                                <label for="telephone_mere" class="block text-sm font-medium text-gray-700 ">Numéro de
                                    Téléphone</label>
                                <input type="tel" id="telephone_mere" name="telephone_mere"
                                    class="mt-1 block w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('telephone_mere')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
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
                        Enregistrer l'Étudiant
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin>
