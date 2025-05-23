<x-home titre="Page messagerie" page_titre="Page messagerie" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom" :unread_count="$unreadCount">
    <div class="p-3 ">
        <div class="messaging-container bg-gradient-to-br from-gray-50 to-white rounded-xl shadow-2xl overflow-hidden w-full h-[40rem] flex flex-col">
            <div class="flex flex-1 h-0">
                <!-- Sidebar - Conversation List -->
                <div class="w-1/3 border-r border-gray-200 bg-white/50 backdrop-blur-sm flex flex-col">
                    <!-- Search bar with glass effect -->
                    <div class="p-4 border-b border-gray-200/50 bg-white/30">
                        <div class="relative">
                            <input type="text" id="search-conversation" placeholder="Rechercher..."
                                class="w-full pl-10 pr-4 py-3 rounded-xl bg-white/70 border border-gray-200/50 focus:outline-none focus:ring-2 focus:ring-pink-500/30 focus:border-pink-500/50 text-sm font-medium text-gray-700 placeholder-gray-400/80 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 absolute left-3 top-3.5 text-pink-400/80" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Conversation List -->
                    <div class="flex-1 overflow-y-auto custom-scrollbar" id="conversation-list">
                        @foreach ($responsables as $responsable)
                            <div class="p-3 hover:bg-pink-50/50 cursor-pointer flex items-center conversation-item transition-colors duration-200 ease-in-out border-b border-gray-100/30"
                                data-responsable-id="{{ $responsable->id }}"
                                data-search-name="{{ strtolower("{$responsable->respo_nom} {$responsable->respo_prenom}") }}"
                                data-search-message="{{ $responsable->last_message ? strtolower($responsable->last_message->content) : '' }}"
                                onclick="markAsRead(this, {{ $responsable->id }}, '{{ $responsable->respo_nom }} {{ $responsable->respo_prenom }}')">
                                
                                <!-- Avatar with gradient -->
                                <div class="flex-shrink-0 relative">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center shadow-md">
                                        <span class="text-white font-medium">{{ substr($responsable->respo_nom, 0, 1) }}</span>
                                    </div>
                                    @if ($responsable->unread_count > 0)
                                        <span class="absolute -top-1 -right-1 h-3 w-3 rounded-full bg-pink-500 border-2 border-white"></span>
                                    @endif
                                </div>
                                
                                <div class="ml-3 flex-1 overflow-hidden min-w-0">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-sm font-semibold text-gray-800 truncate">
                                            {{ $responsable->respo_nom }} {{ $responsable->respo_prenom }}
                                        </h3>
                                        <span class="text-xs text-gray-400 whitespace-nowrap ml-2">
                                            @if ($responsable->last_message)
                                                {{ $responsable->last_message->created_at->diffForHumans() }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-500 truncate">
                                            @if ($responsable->last_message)
                                                {{ Str::limit($responsable->last_message->content, 25) }}
                                            @endif
                                        </p>
                                        @if ($responsable->unread_count > 0)
                                            <span class="ml-2 flex-shrink-0 bg-pink-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                                {{ $responsable->unread_count }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Main Chat Area -->
                <div class="w-2/3 flex flex-col bg-gradient-to-b from-white to-gray-50/50">
                    <!-- Chat Header -->
                    <div class="p-4 border-b border-gray-200/50 flex items-center bg-white/70 backdrop-blur-sm" id="chat-header">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center shadow">
                                <span class="text-white font-medium" id="recipient-initial">P</span>
                            </div>
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-gray-800 truncate" id="recipient-name">Sélectionnez une conversation</h3>
                            <p class="text-xs text-gray-400">En ligne</p>
                        </div>
                        <!--  -->
                    </div>

                    <!-- Messages Container -->
                    <div class="flex-1 p-4 overflow-y-auto custom-scrollbar bg-[url('https://transparenttextures.com/patterns/light-paper-fibers.png')] bg-opacity-10" id="messages-container">
                        <div class="flex flex-col justify-center items-center h-full text-gray-400/80">
                            <div class="bg-white/50 p-6 rounded-xl shadow-inner border border-gray-200/30 backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-pink-300/70 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-500 text-center">Sélectionnez une conversation</h3>
                                <p class="text-sm text-gray-400 mt-1 text-center">Commencez à discuter avec vos contacts</p>
                            </div>
                        </div>
                    </div>

                    <!-- Message Input -->
                    <div class="p-4 border-t border-gray-200/50 bg-white/70 backdrop-blur-sm">
                        <form id="message-form" class="space-y-2">
                            @csrf
                            <input type="hidden" id="responsable_id" name="responsable_id" value="">
                            <div class="flex items-center space-x-2">
                                <button type="button" class="p-2 text-gray-400 hover:text-pink-500 rounded-full hover:bg-pink-50 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                </button>
                                <div class="flex-1 relative">
                                    <input type="text" id="message-content" name="content"
                                        class="w-full border border-gray-200/70 rounded-full py-3 px-5 pr-12 bg-white/80 focus:outline-none focus:ring-2 focus:ring-pink-500/30 focus:border-pink-500/50 text-sm font-medium text-gray-700 placeholder-gray-400/80 transition-all duration-300 shadow-sm"
                                        placeholder="Écrivez un message..." disabled>
                                </div>
                                <button type="submit"
                                    class="p-3 rounded-full bg-gradient-to-br from-pink-500 to-purple-500 text-white hover:from-pink-600 hover:to-purple-600 transition-all duration-300 shadow-lg hover:shadow-pink-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Add this search functionality at the beginning of your script
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('search-conversation');
                if (searchInput) {
                    searchInput.addEventListener('input', function(e) {
                        const searchTerm = e.target.value.toLowerCase();
                        const items = document.querySelectorAll('.conversation-item');

                        items.forEach(item => {
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

            // Mark conversation as read when clicked
            function markAsRead(element, responsableId, responsableName) {
                // Remove highlight class from all items
                document.querySelectorAll('.conversation-item').forEach(item => {
                    item.classList.remove('bg-pink-100');
                });
                
                // Add highlight to clicked item
                element.classList.add('bg-pink-100');

                // Remove unread indicator if exists
                const unreadBadge = element.querySelector('.bg-pink-500.text-white');
                if (unreadBadge) {
                    unreadBadge.remove();
                }

                // Now load the conversation
                loadConversation(responsableId, responsableName);

                // Optionally send a request to mark messages as read
                fetch(`/messages/${responsableId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
            }

            let currentResponsableId = null;

            function loadConversation(responsableId, responsableName) {
                currentResponsableId = responsableId;

                // Update UI
                document.getElementById('recipient-name').textContent = responsableName;
                document.getElementById('recipient-initial').textContent = responsableName.charAt(0);
                document.getElementById('responsable_id').value = responsableId;
                document.getElementById('message-content').disabled = false;

                // Fetch messages
                fetch(`/messages/${responsableId}`)
    .then(response => response.json())
    .then(messages => {
        console.log(messages);
        const container = document.getElementById('messages-container');
        container.innerHTML = '';

        const currentUserId = {{ Auth::guard('etudiant')->user()->id }};

        if (!messages || messages.length === 0) {
            container.innerHTML = `
                <div class="flex flex-col justify-center items-center h-full text-gray-400/80">
                    <div class="bg-white/50 p-6 rounded-xl shadow-inner border border-gray-200/30 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-pink-300/70 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-500 text-center">Pas de messages encore</h3>
                        <p class="text-sm text-gray-400 mt-1 text-center">Envoyez le premier message à ${responsableName}</p>
                    </div>
                </div>
            `;
            return;
        }

        messages.forEach(message => {
            const isCurrentUser = (message.sender_type === 'etudiant' && message.sender_id == currentUserId);
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${isCurrentUser ? 'justify-end' : 'justify-start'} mb-4 animate-fade-in`;

            const timeString = new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

            // Utilise innerHTML pour afficher le HTML du message (ex: lien de téléchargement)
            const messageHtml = `
                <div class="flex ${isCurrentUser ? 'flex-row-reverse' : 'flex-row'} items-end space-x-2 max-w-xs lg:max-w-md">
                    ${!isCurrentUser ? `
                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center shadow">
                        <span class="text-white text-xs font-medium">${responsableName.charAt(0)}</span>
                    </div>
                    ` : ''}
                    <div class="${isCurrentUser ? 'bg-gradient-to-br from-pink-500 to-purple-500 text-white' : 'bg-white shadow'} rounded-2xl ${isCurrentUser ? 'rounded-br-none' : 'rounded-bl-none'} py-2 px-4">
                        <p class="text-sm ${isCurrentUser ? 'text-white' : 'text-gray-800'}" style="word-break:break-word;">${message.content}</p>
                        <p class="text-xs ${isCurrentUser ? 'text-pink-100' : 'text-gray-500'} mt-1 text-right">${timeString}</p>
                    </div>
                </div>
            `;
            messageDiv.innerHTML = messageHtml;
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
                const responsableId = document.getElementById('responsable_id').value;

                if (!content.trim() || !responsableId) return;

                fetch('/messages', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        content: content,
                        responsable_id: responsableId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        // Add the new message to the UI (student messages always on right)
                        const container = document.getElementById('messages-container');
                        
                        // Remove empty state if present
                        if (container.querySelector('.flex.flex-col.justify-center.items-center')) {
                            container.innerHTML = '';
                        }
                        
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'flex justify-end mb-4 animate-fade-in';
                        
                        const timeString = new Date(data.message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                        
                        messageDiv.innerHTML = `
                            <div class="flex flex-row-reverse items-end space-x-2 max-w-xs lg:max-w-md">
                                <div class="bg-gradient-to-br from-pink-500 to-purple-500 text-white rounded-2xl rounded-br-none py-2 px-4">
                                    <p class="text-sm text-white">${data.message.content}</p>
                                    <p class="text-xs text-pink-100 mt-1 text-right">${timeString}</p>
                                </div>
                            </div>
                        `;
                        
                        container.appendChild(messageDiv);

                        // Clear input and scroll to bottom
                        document.getElementById('message-content').value = '';
                        container.scrollTop = container.scrollHeight;
                    }
                });
            });

            // Optional: Poll for new messages every few seconds
            setInterval(() => {
                if (currentResponsableId) {
                    loadConversation(currentResponsableId, document.getElementById('recipient-name').textContent);
                }
            }, 10000); // Poll every 10 seconds
        </script>

        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(5px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .animate-fade-in {
                animation: fadeIn 0.3s ease-out forwards;
            }
            
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            
            .custom-scrollbar::-webkit-scrollbar-track {
                background: rgba(241, 241, 241, 0.5);
                border-radius: 10px;
            }
            
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(199, 199, 199, 0.6);
                border-radius: 10px;
            }
            
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: rgba(160, 160, 160, 0.8);
            }
            
            .shadow-pink-200 {
                --tw-shadow-color: rgba(251, 207, 232, 0.5);
                --tw-shadow: var(--tw-shadow-colored);
            }
            
            .bg-pink-100 {
                background-color: rgba(252, 231, 243, 0.7);
            }
        </style>
    </div>
</x-home>