<x-home titre="events-page" page_titre="events-page"> 
    <div id="events-page" class="container py-4">
        <h2 class="mb-4">Liste des Événements</h2>

        @foreach($evenements as $evenement)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $evenement->titre }}</h5>
                    <p class="card-text">
                        Date : {{ $evenement->date }}<br>
                        Heure début : {{ $evenement->heure_debut }}<br>
                        Heure fin : {{ $evenement->heure_fin }}
                    </p>
                    <span class="badge" style="background-color: {{ $evenement->color }}">{{ $evenement->color }}</span>
                </div>
            </div>
        @endforeach

        @if($evenements->isEmpty())
            <p>Aucun événement trouvé.</p>
        @endif
    </div>
</x-home>
