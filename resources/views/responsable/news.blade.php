<x-admin titre="Gestion des News" page_titre="Liste des News" :nom_complete="Auth::guard('responsable')->user()?->respo_nom . ' ' . Auth::guard('responsable')->user()?->respo_prenom">
    <div>
    <!-- Delete Confirmation Modal -->
        <div id="delete-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-md">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-rose-100 rounded-full mb-4">
                        <i class="fas fa-exclamation-triangle text-rose-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 text-center mb-2">Confirmer la suppression</h3>
                    <p class="text-gray-600 text-center mb-6">Êtes-vous sûr de vouloir supprimer cette actualité ? Cette action est irréversible.</p>
                    <div class="flex justify-center space-x-4">
                        <button id="cancel-delete" class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors">
                            Annuler
                        </button>
                        <form id="delete-form" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-2 rounded-lg bg-rose-500 text-white hover:bg-rose-600 transition-colors">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content container -->
        <div class="relative max-w-6xl mx-auto z-10">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 mb-6 rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 shadow-lg">
                    <i class="fas fa-newspaper text-3xl text-white"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    Gestion des <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Actualités</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Publiez et gérez les actualités de votre établissement</p>
            </div>

            <!-- Flash messages -->
            <div class="max-w-5xl mx-auto mb-10 space-y-4">
                @if(session('success'))
                <div class="p-4 rounded-xl bg-white shadow-md border-l-4 border-emerald-500 flex items-start animate-fade-in">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                            <i class="fas fa-check text-emerald-500"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-800">{{ session('success') }}</h3>
                    </div>
                </div>
                @endif
            </div>

            <!-- Add news form (hidden by default) -->
            <div id="news-form-container" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-10 transition-all duration-300 hover:shadow-md">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                            <i class="fas fa-plus text-blue-500 text-sm"></i>
                        </span>
                        Ajouter une nouvelle actualité
                    </h2>
                    <button onclick="toggleNewsForm()" 
                            class="text-sm font-medium px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all flex items-center">
                        <i class="fas fa-arrow-left mr-2 text-blue-500"></i> Retour aux actualités
                    </button>
                </div>
                <div class="p-6">
                    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Titre <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-heading text-gray-400"></i>
                                </div>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200"
                                       placeholder="Titre de l'actualité">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contenu <span class="text-rose-500">*</span></label>
                            <textarea name="content" id="content" required rows="5"
                                      class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200"
                                      placeholder="Contenu de l'actualité">{{ old('content') }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="far fa-calendar text-gray-400"></i>
                                    </div>
                                    <input type="date" name="date_news" id="date_news" value="{{ old('date_news') }}" required
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Image (optionnelle)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                    <input type="file" name="image" id="image"
                                           class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-200 file:border-0 file:bg-transparent file:text-sm file:font-medium focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-plus-circle mr-3"></i>
                                Publier l'actualité
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- News list -->
            <div id="news-list-container">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                        <div class="flex items-center">
                            <span class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                <i class="fas fa-list-ul text-indigo-500 text-sm"></i>
                            </span>
                            <h2 class="text-xl font-semibold text-gray-800">Liste des actualités</h2>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Search bar -->
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" id="news-search" placeholder="Rechercher une actualité..."
                                       class="pl-10 w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                            </div>
                            <button onclick="toggleNewsForm()" 
                                    class="text-sm font-medium px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white transition-all flex items-center">
                                <i class="fas fa-plus mr-2"></i> Ajouter
                            </button>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-100" id="news-list">
                        @forelse($news as $new)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-200 group news-item" data-title="{{ strtolower($new->title) }}">
                            <div class="flex flex-col md:flex-row md:items-start gap-6">
                                @if($new->image)
                                <div class="flex-shrink-0 w-full md:w-48">
                                    <img src="{{ asset('storage/' . $new->image) }}" alt="{{ $new->title }}" class="w-full h-auto rounded-lg object-cover shadow-sm">
                                </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $new->title }}</h3>
                                    <p class="mt-2 text-gray-600">{{ $new->content }}</p>
                                    
                                    <div class="mt-4 flex items-center gap-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                            <i class="far fa-calendar mr-2"></i>
                                            {{ \Carbon\Carbon::parse($new->date_news)->isoFormat('LL') }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2 mt-4 md:mt-0">
                                    <button onclick="toggleEditForm('edit-form-{{ $new->id }}', 'news-{{ $new->id }}')"
                                       class="text-sm font-medium px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all flex items-center">
                                        <i class="fas fa-pencil-alt mr-2 text-blue-500"></i> Modifier
                                    </button>
                                    
                                    <button onclick="showDeleteModal('{{ route('news.destroy', $new->id) }}')"
                                            class="text-sm font-medium px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all flex items-center">
                                        <i class="fas fa-trash-alt mr-2 text-rose-500"></i> Supprimer
                                    </button>
                                </div>
                            </div>

                            <!-- Edit form (hidden by default) -->
                            <div id="edit-form-{{ $new->id }}" class="hidden mt-6 pt-6 border-t border-gray-100">
                                <form action="{{ route('news.update', $new->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre <span class="text-rose-500">*</span></label>
                                        <input type="text" name="title" value="{{ old('title', $new->title) }}" required
                                               class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Contenu <span class="text-rose-500">*</span></label>
                                        <textarea name="content" required rows="5"
                                                  class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">{{ old('content', $new->content) }}</textarea>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Date <span class="text-rose-500">*</span></label>
                                            <input type="date" name="date_news" value="{{ old('date_news', $new->date_news) }}" required
                                                   class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Image (optionnelle)</label>
                                            <input type="file" name="image"
                                                   class="w-full px-4 py-3 rounded-lg border border-gray-200 file:border-0 file:bg-transparent file:text-sm file:font-medium focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200">
                                        </div>
                                    </div>
                                    
                                    @if($new->image)
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset('storage/' . $new->image) }}" alt="{{ $new->title }}" class="w-24 h-24 rounded-lg object-cover">
                                        <div class="text-sm text-gray-500">
                                            <p>Image actuelle</p>
                                            <p class="font-medium">{{ $new->image }}</p>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <div class="pt-4 flex gap-3">
                                        <button type="submit" 
                                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center">
                                            <i class="fas fa-save mr-3"></i> Enregistrer
                                        </button>
                                        <button type="button" onclick="toggleEditForm('edit-form-{{ $new->id }}', 'news-{{ $new->id }}')" 
                                                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center">
                                            <i class="fas fa-times mr-3"></i> Annuler
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="p-10 text-center">
                            <div class="mx-auto w-20 h-20 bg-blue-50 rounded-xl flex items-center justify-center text-blue-400 mb-5">
                                <i class="fas fa-newspaper text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Aucune actualité publiée</h3>
                            <p class="text-gray-500 text-sm">Commencez par ajouter votre première actualité</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Smooth transitions for interactive elements */
        button, input, textarea, a, .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        /* Modal animation */
        #delete-modal {
            animation: fadeInModal 0.2s ease-out forwards;
        }
        @keyframes fadeInModal {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>

    <script>
        function toggleEditForm(formId, newsId) {
            const form = document.getElementById(formId);
            form.classList.toggle('hidden');
            
            // Scroll to the form if it's being shown
            if (!form.classList.contains('hidden')) {
                setTimeout(() => {
                    const newsElement = document.getElementById(newsId);
                    newsElement.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center'
                    });
                }, 50);
            }
        }

        function toggleNewsForm() {
            const formContainer = document.getElementById('news-form-container');
            const listContainer = document.getElementById('news-list-container');
            
            formContainer.classList.toggle('hidden');
            listContainer.classList.toggle('hidden');
            
            if (!formContainer.classList.contains('hidden')) {
                setTimeout(() => {
                    formContainer.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'nearest'
                    });
                }, 50);
            }
        }

        function showDeleteModal(formAction) {
            const modal = document.getElementById('delete-modal');
            const form = document.getElementById('delete-form');
            
            form.action = formAction;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideDeleteModal() {
            const modal = document.getElementById('delete-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Search functionality
        document.getElementById('news-search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const newsItems = document.querySelectorAll('.news-item');
            
            newsItems.forEach(item => {
                const title = item.getAttribute('data-title');
                if (title.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Event listeners for modal
        document.getElementById('cancel-delete').addEventListener('click', hideDeleteModal);
        
        // Close modal when clicking outside
        document.getElementById('delete-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideDeleteModal();
            }
        });
    </script>
</x-admin>