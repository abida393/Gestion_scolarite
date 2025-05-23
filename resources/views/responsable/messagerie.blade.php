<x-admin titre="Page messagerie" page_titre="Page messagerie" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom">
    <div class="p-4">
        <div class="messaging-container bg-white rounded-lg shadow-lg overflow-hidden w-full">
            <div class="flex h-[500px]">
                <!-- Sidebar - Conversation List -->
                <div class="w-1/3 border-r border-gray-200 bg-gray-50 overflow-y-auto">
                    <div class="p-3 border-b border-gray-200">
                        <div class="relative">
                            <input type="text" id="search-etudiant" placeholder="Rechercher un étudiant..."
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Conversation List -->
                    <div class="divide-y divide-gray-200" id="conversation-list">
                        @foreach ($etudiants as $etudiant)
                            <div class="p-3 hover:bg-gray-100 cursor-pointer flex items-center conversation-item"
                                data-etudiant-id="{{ $etudiant->id }}"
                                data-search-name="{{ strtolower("{$etudiant->etudiant_nom} {$etudiant->etudiant_prenom}") }}"
                                data-search-message="{{ $etudiant->last_message ? strtolower($etudiant->last_message->content) : '' }}"
                                onclick="loadConversation({{ $etudiant->id }}, '{{ $etudiant->etudiant_nom }} {{ $etudiant->etudiant_prenom }}')">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span
                                            class="text-indigo-600 font-medium">{{ substr($etudiant->etudiant_nom, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1 overflow-hidden">
                                    <div class="flex justify-between items-baseline">
                                        <h3 class="text-sm font-medium text-gray-900 truncate">
                                            {{ $etudiant->etudiant_nom }} {{ $etudiant->etudiant_prenom }}</h3>
                                        <span class="text-xs text-gray-500">
                                            @if ($etudiant->last_message)
                                                {{ $etudiant->last_message->created_at->diffForHumans() }}
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 truncate">
                                        @if ($etudiant->last_message)
                                            {{ Str::limit($etudiant->last_message->content, 30) }}
                                        @endif
                                    </p>
                                </div>
                                @if ($etudiant->unread_count > 0)
                                    <div class="ml-2 flex-shrink-0">
                                        <span
                                            class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-600 text-white unread-badge">
                                            {{ $etudiant->unread_count }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Main Chat Area -->
                <div class="w-2/3 flex flex-col">
                    <!-- Chat Header -->
                    <div class="p-3 border-b border-gray-200 flex items-center" id="chat-header">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-600 font-medium" id="recipient-initial">S</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900" id="recipient-name">Sélectionnez un étudiant
                            </h3>
                            <p class="text-xs text-gray-500" id="recipient-status">
                                <span class="flex items-center">
                                    <span class="h-2 w-2 rounded-full bg-gray-500 mr-1"></span> Hors ligne
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div class="flex-1 p-4 overflow-y-auto bg-gray-50" id="messages-container">
                        <div class="flex items-center justify-center h-full text-gray-500">
                            Sélectionnez un étudiant pour commencer à discuter
                        </div>
                    </div>

                    <!-- Message Input -->
                    <div class="p-3 border-t border-gray-200 bg-white">
                        <form id="message-form">
                            @csrf
                            <input type="hidden" id="etudiant_id" name="etudiant_id" value="">
                            <div class="flex items-center">
                                <button type="button" class="p-2 text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                </button>
                                <input type="text" id="message-content" name="content"
                                    class="flex-1 border border-gray-300 rounded-full py-2 px-4 mx-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="Écrivez un message..." disabled>
                                <button type="submit"
                                    class="p-2 rounded-full bg-indigo-600 text-white hover:bg-indigo-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Add search functionality
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('search-etudiant');
                if (searchInput) {
                    searchInput.addEventListener('input', function(e) {
                        const searchTerm = e.target.value.toLowerCase();
                        const conversationItems = document.querySelectorAll('.conversation-item');

                        conversationItems.forEach(item => {
                            const name = item.getAttribute('data-search-name');
                            const message = item.getAttribute('data-search-message');

                            if (name.includes(searchTerm) || message.includes(searchTerm)) {
                                item.style.display = 'flex';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });
                }
            });

            // Keep all existing JavaScript exactly the same
            let currentEtudiantId = null;

            function loadConversation(etudiantId, etudiantName) {
                currentEtudiantId = etudiantId;

                // Update UI
                document.getElementById('recipient-name').textContent = etudiantName;
                document.getElementById('recipient-initial').textContent = etudiantName.charAt(0);
                document.getElementById('etudiant_id').value = etudiantId;
                document.getElementById('message-content').disabled = false;
                // Marquer comme lu côté backend
                fetch(`/responsable/messages/${etudiantId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                }).then(() => {
                    // Masquer le badge côté front
                    const conversationItem = document.querySelector(
                        `.conversation-item[data-etudiant-id="${etudiantId}"]`);
                    if (conversationItem) {
                        const badge = conversationItem.querySelector('.unread-badge');
                        if (badge) badge.style.display = 'none';
                    }
                });

                // Fetch messages
                fetch(`/responsable/messages/${etudiantId}`)
                    .then(response => response.json())
                    .then(messages => {
                        const container = document.getElementById('messages-container');
                        container.innerHTML = '';

                        messages.forEach(message => {
                            const isSender = message.sender_type === 'responsable';
                            const messageDiv = document.createElement('div');
                            messageDiv.className = `flex ${isSender ? 'justify-end' : 'justify-start'} mb-4`;

                            messageDiv.innerHTML = `
                                <div class="${isSender ? 'bg-indigo-100' : 'bg-white'} rounded-lg py-2 px-4 max-w-xs lg:max-w-md shadow">
                                    <p class="text-sm text-gray-800">${message.content}</p>
                                    <p class="text-right text-xs text-gray-500 mt-1">
                                        ${new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                    </p>
                                </div>
                            `;

                            container.appendChild(messageDiv);
                        });

                        // Scroll to bottom
                        container.scrollTop = container.scrollHeight;
                    });
            }

            // Handle form submission
            document.getElementById('message-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const content = document.getElementById('message-content').value;
                const etudiantId = document.getElementById('etudiant_id').value;

                if (!content.trim() || !etudiantId) {
                    alert('Veuillez sélectionner un étudiant et entrer un message');
                    return;
                }

                fetch('/responsable/messages', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            content: content,
                            etudiant_id: etudiantId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Add the new message to the UI
                        const container = document.getElementById('messages-container');
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'flex justify-end mb-4';
                        messageDiv.innerHTML = `
                        <div class="bg-indigo-100 rounded-lg py-2 px-4 max-w-xs lg:max-w-md shadow">
                            <p class="text-sm text-gray-800">${data.message.content}</p>
                            <p class="text-right text-xs text-gray-500 mt-1">À l'instant</p>
                        </div>
                    `;
                        container.appendChild(messageDiv);

                        // Clear input and scroll to bottom
                        document.getElementById('message-content').value = '';
                        container.scrollTop = container.scrollHeight;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message || 'Échec de l\'envoi du message');
                    });
            });

            // Optional: Poll for new messages
            setInterval(() => {
                if (currentEtudiantId) {
                    loadConversation(currentEtudiantId, document.getElementById('recipient-name').textContent);
                }
            }, 10000);
        </script>

        <style>
            .messaging-container {
                transition: all 0.3s ease;
            }

            #messages-container::-webkit-scrollbar {
                width: 6px;
            }

            #messages-container::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            #messages-container::-webkit-scrollbar-thumb {
                background: #c7c7c7;
                border-radius: 10px;
            }

            #messages-container::-webkit-scrollbar-thumb:hover {
                background: #a0a0a0;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .bg-indigo-100 {
                animation: fadeIn 0.3s ease-out;
            }
        </style>
    </div>
</x-admin>
