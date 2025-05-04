<x-home titre="Page news" page_titre="Page news" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ', ' . Auth::guard('etudiant')->user()->etudiant_prenom">
<style>
    /* Scrollbar fine et discrète */
::-webkit-scrollbar {
  width: 4px;
}
::-webkit-scrollbar-thumb {
  background-color: #a0aec0; /* gris doux */
  border-radius: 20px;
}

/* Style du badge "News" avec une couleur et un écart des marges */
.news-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    position: absolute;
    top: 10px;  /* un peu plus loin du haut */
    right: 10px; /* un peu plus loin de la droite */
    background-color: #3498db; /* bleu doux */
    color: white;
    border-radius: 12px;
}
</style>

<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-gray-900 text-center mb-14">🗞️ Actualités récentes</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($news as $item)
        <div class="relative bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-transform transform hover:-translate-y-1 overflow-hidden">
            {{-- Badge "News" seulement pour les actualités récentes --}}
            @if(\Carbon\Carbon::parse($item->date_news)->diffInDays(now()) <= 7)
                <span class="news-badge">News</span>
            @endif

            {{-- Image --}}
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" alt="Image News" class="w-full h-48 object-cover rounded-lg mb-4">
            @endif

            <div class="space-y-4">
                {{-- Titre --}}
                <h2 class="text-xl font-bold text-blue-600 mb-4 border-b border-gray-200 pb-2">{{ $item->title }}</h2>

                {{-- Contenu avec scroll vertical si nécessaire --}}
                <div class="text-sm text-gray-700 leading-relaxed overflow-y-auto max-h-40 pr-2 overflow-x-hidden">
                    {{ $item->content }}
                </div>
            </div>

            {{-- Bas de la carte sans la date --}}
            <div class="mt-6 flex items-center justify-between text-xs text-gray-500">
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                        <i class="far fa-clock text-blue-400"></i>
                    </div>
                    <span>Posté {{ \Carbon\Carbon::parse($item->date_news)->diffForHumans() }}</span>
                </div>
            </div>
        </div>
        @empty
            <p class="text-center text-gray-500 col-span-full">Aucune actualité disponible pour le moment.</p>
        @endforelse
    </div>
</div>

</body>
</html>
<x-chat-button></x-chat-button>
</x-home>
