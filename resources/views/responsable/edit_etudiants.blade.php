<x-admin titre="Gestion des Absences" page_titre="Tableau de Bord des Absences" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Modifier Étudiant</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('responsable.update_etudiant', $etudiant->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Informations Personnelles</h2>

                        <div>
                            <label for="etudiant_nom" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" name="etudiant_nom" id="etudiant_nom"
                                value="{{ old('etudiant_nom', $etudiant->etudiant_nom) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('etudiant_nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="etudiant_prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                            <input type="text" name="etudiant_prenom" id="etudiant_prenom"
                                value="{{ old('etudiant_prenom', $etudiant->etudiant_prenom) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('etudiant_prenom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="etudiant_cin" class="block text-sm font-medium text-gray-700">CIN</label>
                            <input type="text" name="etudiant_cin" id="etudiant_cin"
                                value="{{ old('etudiant_cin', $etudiant->etudiant_cin) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('etudiant_cin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="etudiant_cne" class="block text-sm font-medium text-gray-700">CNE</label>
                            <input type="text" name="etudiant_cne" id="etudiant_cne"
                                value="{{ old('etudiant_cne', $etudiant->etudiant_cne) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('etudiant_cne')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="etudiant_date_naissance" class="block text-sm font-medium text-gray-700">Date de
                                Naissance</label>
                            <input type="date" name="etudiant_date_naissance" id="etudiant_date_naissance"
                                value="{{ old('etudiant_date_naissance', $etudiant->etudiant_date_naissance) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('etudiant_date_naissance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="etudiant_sexe" class="block text-sm font-medium text-gray-700">Sexe</label>
                            <select name="etudiant_sexe" id="etudiant_sexe"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="Masculin"
                                    {{ old('etudiant_sexe', $etudiant->etudiant_sexe) == 'Masculin' ? 'selected' : '' }}>
                                    Masculin</option>
                                <option value="Féminin"
                                    {{ old('etudiant_sexe', $etudiant->etudiant_sexe) == 'Féminin' ? 'selected' : '' }}>
                                    Féminin</option>
                            </select>
                            @error('etudiant_sexe')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="PHOTOS" class="block text-sm font-medium text-gray-700">Photo</label>
                            <input type="file" name="PHOTOS" id="PHOTOS"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @if ($etudiant->PHOTOS)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $etudiant->PHOTOS) }}" alt="Photo actuelle"
                                        class="h-20 w-20 rounded-full object-cover">
                                </div>
                            @endif
                            @error('PHOTOS')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Informations Académiques</h2>

                        <div>
                            <label for="formation_id" class="block text-sm font-medium text-gray-700">Formation</label>
                            <select name="formation_id" id="formation_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @foreach ($formations as $formation)
                                    <option value="{{ $formation->id }}"
                                        {{ old('formation_id', $etudiant->formation_id) == $formation->id ? 'selected' : '' }}>
                                        {{ $formation->nom_formation }}
                                    </option>
                                @endforeach
                            </select>
                            @error('formation_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="classes_id" class="block text-sm font-medium text-gray-700">Classe</label>
                            <select name="classes_id" id="classes_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ old('classes_id', $etudiant->classes_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->nom_classe }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classes_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="etudiant_serie_bac" class="block text-sm font-medium text-gray-700">Série
                                Bac</label>
                            <input type="text" name="etudiant_serie_bac" id="etudiant_serie_bac"
                                value="{{ old('etudiant_serie_bac', $etudiant->etudiant_serie_bac) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('etudiant_serie_bac')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="etudiant_session_bac" class="block text-sm font-medium text-gray-700">Session
                                Bac</label>
                            <input type="text" name="etudiant_session_bac" id="etudiant_session_bac"
                                value="{{ old('etudiant_session_bac', $etudiant->etudiant_session_bac) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('etudiant_session_bac')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="etudiant_mention_bac" class="block text-sm font-medium text-gray-700">Mention
                                Bac</label>
                            <input type="text" name="etudiant_mention_bac" id="etudiant_mention_bac"
                                value="{{ old('etudiant_mention_bac', $etudiant->etudiant_mention_bac) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('etudiant_mention_bac')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="annee_obtention_bac" class="block text-sm font-medium text-gray-700">Année
                                Obtention Bac</label>
                            <input type="date" name="annee_obtention_bac" id="annee_obtention_bac"
                                value="{{ old('annee_obtention_bac', $etudiant->annee_obtention_bac) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('annee_obtention_bac')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Coordonnées</h2>

                        <div>
                            <label for="etudiant_email" class="block text-sm font-medium text-gray-700">Email
                                Personnel</label>
                            <input type="email" name="etudiant_email" id="etudiant_email"
                                value="{{ old('etudiant_email', $etudiant->etudiant_email) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('etudiant_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="etudiant_tel"
                                class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="text" name="etudiant_tel" id="etudiant_tel"
                                value="{{ old('etudiant_tel', $etudiant->etudiant_tel) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('etudiant_tel')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="etudiant_adresse"
                                class="block text-sm font-medium text-gray-700">Adresse</label>
                            <input type="text" name="etudiant_adresse" id="etudiant_adresse"
                                value="{{ old('etudiant_adresse', $etudiant->etudiant_adresse) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('etudiant_adresse')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ville" class="block text-sm font-medium text-gray-700">Ville</label>
                            <input type="text" name="ville" id="ville"
                                value="{{ old('ville', $etudiant->ville) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('ville')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Parent Information -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Informations Parents</h2>

                        <div>
                            <label for="nom_pere" class="block text-sm font-medium text-gray-700">Nom Père</label>
                            <input type="text" name="nom_pere" id="nom_pere"
                                value="{{ old('nom_pere', $etudiant->nom_pere) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('nom_pere')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telephone_pere" class="block text-sm font-medium text-gray-700">Téléphone
                                Père</label>
                            <input type="text" name="telephone_pere" id="telephone_pere"
                                value="{{ old('telephone_pere', $etudiant->telephone_pere) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('telephone_pere')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nom_mere" class="block text-sm font-medium text-gray-700">Nom Mère</label>
                            <input type="text" name="nom_mere" id="nom_mere"
                                value="{{ old('nom_mere', $etudiant->nom_mere) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('nom_mere')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telephone_mere" class="block text-sm font-medium text-gray-700">Téléphone
                                Mère</label>
                            <input type="text" name="telephone_mere" id="telephone_mere"
                                value="{{ old('telephone_mere', $etudiant->telephone_mere) }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('telephone_mere')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6 space-x-4">
                    <a href="{{ route('responsable.afficher_etudiant') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded"
                        onclick="return confirm('Êtes-vous sûr de vouloir annuler ?')">
                        Annuler
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin>
