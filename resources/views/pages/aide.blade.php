<x-home titre="Page d'aide" page_titre="Page d'aide">
  <div class="max-w-4xl mx-auto px-4 py-10">
    <!-- Intro -->
    <div class="text-center mb-12">
    <h1 class="text-4xl sm:text-5xl font-extrabold text-indigo-700">
      🎓 Centre d’Aide Universitaire
    </h1>
    <p class="mt-6 text-xl text-gray-700 font-medium leading-relaxed">
      Le service scolarité vous guide à chaque étape de vos démarches administratives et académiques. Nous sommes là pour vous aider !
    </p>
  </div>

  <!-- FAQ Section -->
  <div class="space-y-8">
    <h2 class="text-3xl font-semibold text-gray-900 mb-8 text-center animate__animated animate__fadeIn">
       Questions fréquentes ❓
    </h2>
      <div class="space-y-4">

        <!-- FAQ Item Template -->
        <!-- Début de la boucle FAQ -->

        <!-- 1 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Comment modifier mes informations personnelles ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Vous pouvez modifier vos informations depuis l’onglet « Mon profil » dans votre espace étudiant.
          </div>
        </div>

        <!-- 2 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Comment obtenir mon certificat de scolarité ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300" 
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Faites la demande via la rubrique « Demandes de documents » dans votre espace personnel.
          </div>
        </div>

        <!-- 3 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Quand auront lieu les examens de rattrapage ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Les dates de rattrapage sont communiquées par la scolarité à la fin de chaque session d'examens.
          </div>
        </div>

        <!-- 4 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Comment obtenir mon relevé de notes officiel ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Vous pouvez demander votre relevé via l’espace « Documents officiels ».
          </div>
        </div>

        <!-- 5 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Comment faire une demande de bourse ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            La demande de bourse se fait chaque année via le portail gouvernemental ou via la scolarité.
          </div>
        </div>

        <!-- 6 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Comment récupérer mon diplôme ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Les diplômes sont disponibles à la scolarité sur rendez-vous après la cérémonie de remise.
          </div>
        </div>


        <!-- 7 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Comment m'inscrire à un module optionnel ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Vous pouvez choisir vos modules optionnels via l’interface « Choix pédagogiques » avant la date limite d’inscription.
          </div>
        </div>

        <!-- 8 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Que faire en cas d'oubli de mon mot de passe ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Utilisez le lien « Mot de passe oublié ? » sur la page de connexion pour le réinitialiser.
          </div>
        </div>

        <!-- 9 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Puis-je reporter une année universitaire ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Oui, sur demande écrite avec justificatif à déposer à la scolarité avant la rentrée.
          </div>
        </div>

        <!-- 10 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Comment changer d’orientation ou de filière ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Prenez rendez-vous avec le service d’orientation pour étudier la faisabilité de votre changement.
          </div>
        </div>

        <!-- 11 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Comment consulter mon emploi du temps ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Il est disponible en ligne dans l’espace étudiant sous la rubrique « Emploi du temps ».
          </div>
        </div>

        <!-- 12 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Puis-je demander un transfert vers un autre établissement ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Oui, sous conditions. Une demande écrite accompagnée des pièces justificatives est requise.
          </div>
        </div>

        <!-- 13 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Comment obtenir une attestation de réussite ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Elle est disponible après délibération finale, via l’espace « Documents officiels ».
          </div>
        </div>

        <!-- 14 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Qui contacter en cas de problème pédagogique ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Votre responsable pédagogique est votre premier interlocuteur pour ce type de problème.
          </div>
        </div>

        <!-- 15 -->
        <div x-data="{ open: false }" class="border border-gray-200 rounded-2xl shadow-md overflow-hidden transition-all hover:shadow-lg hover:border-blue-300">
          <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-white hover:bg-gray-100 transition duration-300">
            <span class="text-base font-semibold text-gray-800">Comment faire une réclamation suite à une note ?</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform duration-300"
              fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 text-sm">
            Les réclamations doivent être adressées par écrit au service pédagogique dans les 5 jours suivant la publication des notes.
          </div>
        </div>

        <!-- Fin de la boucle FAQ -->

      </div>
    </div>
  </div>

  <!-- AlpineJS for collapsible behavior -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-home>
