<x-home titre="Page messagerie" page_titre="Page messagerie" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
    <div class="p-4">
        <div class="messaging-container bg-white rounded-lg shadow-lg overflow-hidden w-full">
            <div class="flex h-[500px]">
                <!-- Sidebar - Conversation List -->
                <div class="w-1/3 border-r border-gray-200 bg-gray-50 overflow-y-auto">
                    <div class="p-3 border-b border-gray-200">
                        <div class="relative">
                            <input type="text" placeholder="Rechercher une conversation..."
                                   class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <!-- Static Conversation List -->
                    <div class="divide-y divide-gray-200">
                        <!-- Conversation 1 (Unread) -->
                        @foreach ($responsables as $responsable )
                        <div class="p-3 hover:bg-gray-100 cursor-pointer flex items-center bg-blue-50">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-indigo-600 font-medium">{{substr($responsable->respo_nom, 0, 1)}}</span>
                                </div>
                            </div>
                            <div class="ml-3 flex-1 overflow-hidden">
                                <div class="flex justify-between items-baseline">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">{{ $responsable->respo_nom." ".$responsable->respo_prenom }}</h3>
                                    <span class="text-xs text-gray-500">10 min</span>
                                </div>
                            </div>
                            <div class="ml-2 flex-shrink-0">
                                <span class="h-2 w-2 rounded-full bg-indigo-600 block"></span>
                            </div>
                        </div>
                        @endforeach
                        {{-- <!-- Conversation 2 -->
                        <div class="p-3 hover:bg-gray-100 cursor-pointer flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-green-600 font-medium">A</span>
                                </div>
                            </div>
                            <div class="ml-3 flex-1 overflow-hidden">
                                <div class="flex justify-between items-baseline">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">Admin. Services</h3>
                                    <span class="text-xs text-gray-500">1h</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">Votre demande a été approuvée</p>
                            </div>
                        </div>

                        <!-- Conversation 3 -->
                        <div class="p-3 hover:bg-gray-100 cursor-pointer flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <span class="text-purple-600 font-medium">M</span>
                                </div>
                            </div>
                            <div class="ml-3 flex-1 overflow-hidden">
                                <div class="flex justify-between items-baseline">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">Marie (Étudiante)</h3>
                                    <span class="text-xs text-gray-500">3h</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">Vous: On se voit à la bibliothèque...</p>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <!-- Main Chat Area -->
                <div class="w-2/3 flex flex-col">
                    <!-- Chat Header -->
                    <div class="p-3 border-b border-gray-200 flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-600 font-medium">P</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-900">Prof. Dupont</h3>
                            <p class="text-xs text-gray-500">
                                <span class="flex items-center">
                                    <span class="h-2 w-2 rounded-full bg-green-500 mr-1"></span> En ligne
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Static Messages -->
                    <div class="flex-1 p-4 overflow-y-auto bg-gray-50" id="messages-container">
                        <!-- Received message -->
                        <div class="flex justify-start mb-4">
                            <div class="bg-white rounded-lg py-2 px-4 max-w-xs lg:max-w-md shadow">
                                <p class="text-sm text-gray-800">Bonjour, avez-vous terminé le projet de recherche que je vous ai assigné la semaine dernière ?</p>
                                <p class="text-right text-xs text-gray-500 mt-1">10:32</p>
                            </div>
                        </div>

                        <!-- Sent message -->
                        <div class="flex justify-end mb-4">
                            <div class="bg-indigo-100 rounded-lg py-2 px-4 max-w-xs lg:max-w-md shadow">
                                <p class="text-sm text-gray-800">Bonjour Professeur, oui je l'ai terminé hier soir. Je peux vous l'envoyer par email si vous voulez.</p>
                                <p class="text-right text-xs text-gray-500 mt-1">10:35</p>
                            </div>
                        </div>

                        <!-- Received message -->
                        <div class="flex justify-start mb-4">
                            <div class="bg-white rounded-lg py-2 px-4 max-w-xs lg:max-w-md shadow">
                                <p class="text-sm text-gray-800">Non, déposez-le simplement sur la plateforme comme d'habitude. Avez-vous rencontré des difficultés particulières ?</p>
                                <p class="text-right text-xs text-gray-500 mt-1">10:36</p>
                            </div>
                        </div>

                        <!-- Sent message -->
                        <div class="flex justify-end mb-4">
                            <div class="bg-indigo-100 rounded-lg py-2 px-4 max-w-xs lg:max-w-md shadow">
                                <p class="text-sm text-gray-800">Juste quelques questions sur la méthodologie, mais j'ai consulté les ressources que vous avez partagées et cela m'a bien aidé.</p>
                                <p class="text-right text-xs text-gray-500 mt-1">10:38</p>
                            </div>
                        </div>
                    </div>

                    <!-- Message Input -->
                    <div class="p-3 border-t border-gray-200 bg-white">
                        <div class="flex items-center">
                            <button type="button" class="p-2 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                            </button>
                            <input type="text" class="flex-1 border border-gray-300 rounded-full py-2 px-4 mx-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Écrivez un message...">
                            <button type="button" class="p-2 rounded-full bg-indigo-600 text-white hover:bg-indigo-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .bg-indigo-100 {
                animation: fadeIn 0.3s ease-out;
            }
        </style>
    </div>
</x-home>
