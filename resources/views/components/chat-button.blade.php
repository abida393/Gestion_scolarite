<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Assistant Étudiant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out forwards;
        }
        .animate-fade-out-down {
            animation: fadeOutDown 0.3s ease-in forwards;
        }
        .animate-fade-in {
            animation: fadeIn 0.2s ease-out forwards;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOutDown {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(20px); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        #chatbox::-webkit-scrollbar {
            width: 6px;
        }
        #chatbox::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
        }
        #chatbox::-webkit-scrollbar-thumb {
            background-color: rgba(79, 70, 229, 0.3);
            border-radius: 3px;
        }
    </style>
</head>
<body>

<div class="fixed bottom-4 right-4 z-50">
    <!-- Bouton d'ouverture -->
    <button id="toggleChat" class="bg-indigo-600 text-white p-4 rounded-full shadow-xl hover:bg-indigo-700 transition-all transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-indigo-300/50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
    </button>

    <!-- Fenêtre du chat -->
    <div id="chatWindow"
        class="hidden fixed bottom-20 right-4 sm:right-8 w-[90vw] sm:w-96 h-[70vh] bg-white border-0 rounded-xl shadow-2xl flex flex-col z-50 overflow-hidden backdrop-blur-sm bg-white/90">

        <!-- En-tête -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 px-6 flex justify-between items-center rounded-t-xl shadow-sm">
            <div class="flex items-center space-x-3">
                <div class="h-8 w-8 rounded-full bg-white/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="font-bold text-lg">Assistant Étudiant</span>
            </div>
            <button id="closeChat" class="text-white/80 hover:text-white text-2xl font-light transition-all hover:rotate-90 focus:outline-none">×</button>
        </div>

        <!-- Zone messages -->
        <div id="chatbox" class="flex-1 overflow-y-auto p-4 bg-gradient-to-b from-white to-gray-50/50 space-y-4"></div>

        <!-- Formulaire -->
        <form id="chatForm" class="p-4 border-t border-gray-200/50 bg-white/80 backdrop-blur-sm">
            <div class="flex items-center gap-3">
                <input type="text" id="userInput" name="question"
                    class="flex-1 border border-gray-300/50 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-300/50 focus:border-transparent shadow-sm text-gray-700 placeholder-gray-400"
                    placeholder="Écrivez votre message..." required>
                <button type="submit"
                    class="bg-indigo-600 text-white p-3 rounded-xl hover:bg-indigo-700 transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-300/50 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const chatBtn = document.getElementById('toggleChat');
    const chatWindow = document.getElementById('chatWindow');
    const chatForm = document.getElementById('chatForm');
    const chatbox = document.getElementById('chatbox');
    const input = document.getElementById('userInput');
    const closeChatBtn = document.getElementById('closeChat');

    // Ajouter un message de bienvenue
    function addWelcomeMessage() {
        const welcomeMessage = document.querySelector('#chatbox .welcome-message');
        if (!welcomeMessage) {
addMessage(
  'Assistant',
  'Bonjour <?= Auth::guard("etudiant")->user()->etudiant_prenom ?> <?= Auth::guard("etudiant")->user()->etudiant_nom ?> ! Comment puis-je vous aider aujourd\'hui ?',
  'left',
  true
);}
    }

    // Ajouter un message
    function addMessage(sender, message, side, isWelcome = false) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `flex ${side === 'right' ? 'justify-end' : 'justify-start'} animate-fade-in ${isWelcome ? 'welcome-message' : ''}`;
        const bubbleClass = side === 'right'
            ? 'bg-indigo-600 text-white rounded-tr-none'
            : 'bg-gray-100 text-gray-800 rounded-tl-none border border-gray-200/50';
        msgDiv.innerHTML = `
            <div class="max-w-[80%] px-4 py-3 rounded-xl ${bubbleClass} shadow-sm">
                ${side === 'left' ? `<span class="text-xs font-semibold text-indigo-600">${sender}</span><br>` : ''}
                <div class="text-sm">${message}</div>
            </div>
        `;
        chatbox.appendChild(msgDiv);
        chatbox.scrollTop = chatbox.scrollHeight;
    }

    // Ouvrir le chat
    chatBtn.addEventListener('click', () => {
        chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
            addWelcomeMessage();
        }
    });

    // Fermer le chat
    closeChatBtn.addEventListener('click', () => {
        chatWindow.classList.add('hidden');
    });

    // Envoi du message
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;
        addMessage('Vous', message, 'right');
        input.value = '';

        try {
            const res = await fetch("{{ route('chatbot.repondre') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ question: message })
            });

            const data = await res.json();
            const reponse = data.reponse ?? "Désolé, je n'ai pas compris.";
            addMessage('Assistant', reponse, 'left');
        } catch (error) {
            console.error("Erreur lors de l'envoi :", error);
            addMessage('Assistant', "Une erreur est survenue. Veuillez réessayer plus tard.", 'left');
        }
    });
</script>

</body>
</html>
