<x-home titre="Page d'aide" page_titre="Page d'aide" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
    <div class="max-w-4xl mx-auto px-4 py-10">
        <!-- Intro -->
        <div class="text-center mb-12">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-indigo-700">
                🎓 Centre d’Aide Universitaire
            </h1>
            <p class="mt-6 text-xl text-gray-700 font-medium leading-relaxed">
                Le service scolarité vous guide à chaque étape de vos démarches administratives et académiques. Nous
                sommes là pour vous aider !
            </p>
        </div>

        <!-- FAQ Section -->
        <div class="space-y-8">
            <h2 class="text-3xl font-semibold text-gray-900 mb-8 text-center animate_animated animate_fadeIn">
                Questions fréquentes ❓
            </h2>
            <div class="space-y-4">

                <!-- FAQ Item Template -->
                <!-- Début de la boucle FAQ -->

                <!-- 1 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Comment modifier mes informations
                            personnelles ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Pour modifier vos informations personnelles (adresse, téléphone, etc.), connectez-vous à votre
                        espace étudiant, accédez à l'onglet "Mon profil" et cliquez sur "Modifier". Les changements
                        seront automatiquement enregistrés après validation. Pour les modifications sensibles (nom, date
                        de naissance), contactez directement la scolarité avec un justificatif.
                    </div>
                </div>

                <!-- 2 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Comment obtenir mon certificat de scolarité
                            ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Votre certificat de scolarité est disponible en format PDF dans la rubrique "Documents
                        administratifs" de votre espace personnel. Il est généré automatiquement et contient le cachet
                        électronique de l'établissement. Pour une version papier officielle, faites la demande via le
                        service "Demandes de documents" en précisant si vous avez besoin d'une version tamponnée
                        manuellement.
                    </div>
                </div>

                <!-- 3 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Quand auront lieu les examens de rattrapage
                            ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Les examens de rattrapage sont programmés dans les 15 jours suivant la publication des résultats
                        de la session principale. Le calendrier précis est affiché sur les panneaux d'affichage de votre
                        département et dans l'onglet "Examens" de votre espace étudiant 48 heures après les
                        délibérations. Pensez à vérifier régulièrement les mises à jour.
                    </div>
                </div>

                <!-- 4 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Comment obtenir mon relevé de notes officiel
                            ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Le relevé de notes officiel est disponible sous deux formats : numérique (téléchargeable depuis
                        l'espace "Documents officiels" dès la validation des notes) et papier (à retirer à la scolarité
                        sur demande). Pour les besoins de concours ou d'inscriptions à d'autres établissements,
                        privilégiez la version papier avec cachet humide, disponible sous 3 jours ouvrés après demande.
                    </div>
                </div>

                <!-- 5 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Comment faire une demande de bourse ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        La demande de bourse s'effectue entre juin et septembre via le portail du CROUS. Vous devrez
                        fournir : les revenus fiscaux de votre foyer (N-2), une attestation de scolarité, et votre RIB.
                        Notre service social peut vous aider à compléter votre dossier - prenez rendez-vous via l'onglet
                        "Aide financière". Les notifications d'attribution arrivent généralement fin octobre.
                    </div>
                </div>

                <!-- 6 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Comment récupérer mon diplôme ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Votre diplôme physique est disponible 6 mois après la fin de votre formation, une fois les
                        procédures administratives finalisées. Deux options : retrait en mains propres sur rendez-vous à
                        la scolarité (présentation d'une pièce d'identité obligatoire) ou envoi postal (demande à
                        formuler via le formulaire en ligne avec frais d'envoi de 8€). Une version dématérialisée
                        certifiée est disponible immédiatement dans votre espace diplômé.
                    </div>
                </div>

                <!-- 7 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Comment m'inscrire à un module optionnel
                            ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        L'inscription aux modules optionnels s'effectue durant la période de "Choix pédagogiques"
                        (généralement en septembre et janvier). Connectez-vous à votre ENT, accédez à l'onglet
                        "Inscriptions pédagogiques", puis sélectionnez "Modules optionnels". Vous pouvez classer jusqu'à
                        5 vœux par semestre. Les places sont attribuées par ordre de mérite (moyenne du semestre
                        précédent) en cas de surnombre. La validation définitive intervient 8 jours après la rentrée.
                    </div>
                </div>

                <!-- 8 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Que faire en cas d'oubli de mon mot de
                            passe ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Si vous avez oublié votre mot de passe, cliquez sur "Mot de passe oublié" sur la page de
                        connexion. Vous recevrez un lien de réinitialisation par email (vérifiez vos spams). Pour les
                        problèmes persistants, le service informatique peut vous réinitialiser manuellement votre accès
                        sur présentation d'une pièce d'identité en bureau 204 (ouvert du lundi au vendredi, 9h-12h).
                        Prévoir 2 à 24 heures pour la synchronisation des systèmes après réinitialisation.
                    </div>
                </div>

                <!-- 9 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Puis-je reporter une année universitaire
                            ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Le report d'année (ou "redoublement différé") est possible sous conditions. Vous devez déposer
                        une demande écrite au service scolarité au moins un mois avant la rentrée, accompagnée : d'un
                        certificat médical (pour raison santé), d'une preuve de contrat en alternance, ou d'une lettre
                        de motivation détaillée (autres cas). La commission pédagogique statue sous 15 jours. Attention
                        : ce droit ne peut être utilisé qu'une fois par cycle d'études (Licence, Master, etc.).
                    </div>
                </div>

                <!-- 10 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Comment changer d'orientation ou de filière
                            ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Les changements de filière sont soumis à l'approbation de la commission pédagogique. Procédure :
                        1) Prendre rendez-vous avec le conseiller d'orientation (via l'ENT) 2) Constituer un dossier
                        comprenant bulletins de notes, lettre de motivation et éventuellement recommandation d'un
                        enseignant 3) Déposer la demande avant le 15 mai pour une rentrée septembre. Les réorientations
                        en cours d'année sont exceptionnelles et nécessitent l'accord des deux départements concernés.
                    </div>
                </div>

                <!-- 11 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Comment consulter mon emploi du temps
                            ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Votre emploi du temps personnalisé est accessible 24h/24 via l'application mobile "EDT
                        Université" (disponible sur iOS/Android) ou dans l'onglet "Emploi du temps" de votre ENT. Les
                        modifications en temps réel (annulations de cours, changements de salle) y sont automatiquement
                        reportées. Pour une version imprimable, utilisez la fonction "Export PDF" (inclut les
                        coordonnées des enseignants et plans des bâtiments).
                    </div>
                </div>

                <!-- 12 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Puis-je demander un transfert vers un autre
                            établissement ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Les transferts inter-établissements sont possibles sous réserve d'accord des deux universités.
                        Démarches : 1) Obtenir un certificat de scolarité et relevé de notes 2) Faire une demande
                        d'admission dans l'établissement cible 3) Si accepté, signer une convention de transfert (à
                        retirer au service des relations internationales pour les mobilités à l'étranger). Les
                        équivalences de crédits ECTS sont évaluées cas par cas. Délai moyen : 2 à 3 mois pour un
                        transfert national.
                    </div>
                </div>

                <!-- 13 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Comment obtenir une attestation de réussite
                            ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        L'attestation de réussite est automatiquement générée après validation de votre année par le
                        jury. Version numérique : téléchargeable dans "Mes documents" > "Attestations" dès la
                        publication des résultats. Version papier : demande à effectuer au secrétariat pédagogique
                        (délai de 72h). Pour les besoins urgents (inscription en Master, etc.), un certificat provisoire
                        peut être édité immédiatement par votre responsable de formation.
                    </div>
                </div>

                <!-- 14 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Qui contacter en cas de problème
                            pédagogique ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Pour tout problème pédagogique (contenu de cours, conflit avec un enseignant, etc.) : 1)
                        Contactez d'abord votre responsable de mention par mail (coordonnées dans l'annuaire ENT) 2) Si
                        non résolu, saisissez la médiatrice pédagogique via le formulaire en ligne (rubrique "Aide et
                        support") 3) En cas d'urgence, le bureau des enseignants (bâtiment B, 2ème étage) reçoit sans
                        rendez-vous les lundis et jeudis de 14h à 16h.
                    </div>
                </div>

                <!-- 15 -->
                <div x-data="{ open: false }"
                    class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
                    <button @click="open = !open"
                        class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
                        <span class="text-base font-semibold text-gray-800">Comment faire une réclamation suite à une
                            note ?</span>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
                        Les réclamations sur les notes doivent être formalisées par écrit dans les 5 jours ouvrés
                        suivant leur publication. Procédure : 1) Discutez d'abord avec l'enseignant concerné 2) Si
                        désaccord persiste, complétez le formulaire "Réclamation notes" (disponible à la scolarité) en
                        joignant tout élément justificatif 3) La commission d'harmonisation examine votre demande sous
                        10 jours. Seules les erreurs matérielles (calcul, report de note) peuvent donner lieu à
                        modification a posteriori.
                    </div>
                </div>

                <!-- Fin de la boucle FAQ -->

            </div>
        </div>
    </div>
    <!-- AlpineJS for collapsible behavior -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-home>
