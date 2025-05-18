<x-admin titre="Saisie absence" page_titre="Saisie absence" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ' ' . Auth::guard('responsable')->user()->respo_prenom">

    <form method="POST" action="{{ route('responsable.absences.create') }}">
    @csrf

    <!-- Sélection de la classe -->
    <div>
        <label for="classe">Choisir une classe</label>
        <select name="classe_id" id="classe">
            @foreach ($classes as $classe)
                <option value="{{ $classe->id }}">{{ $classe->nom_classe }}</option>
            @endforeach
        </select>
    </div>

    <!-- Sélection de la séance -->
    <div>
        <label for="seance">Choisir une séance</label>
        <select name="seance_id" id="seance">
            @foreach ($seances as $seance)
                <option value="{{ $seance->id }}">{{ $seance->nom_seance }}</option>
            @endforeach
        </select>
    </div>

    <!-- Le reste du formulaire d'ajout d'absence -->
    <button type="submit">Ajouter Absence</button>
</form>

    <!-- Liste des absences avec leur état -->
    <h2 class="mt-5">Liste des Absences</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Étudiant</th>
                <th>Séance</th>
                <th>Date d'absence</th>
                <th>État</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absences as $absence)
                <tr>
                    <td>{{ $absence->etudiant->nom }} {{ $absence->etudiant->prenom }}</td>
                    <td>{{ $absence->seance->nom_matiere }}</td>
                    <td>{{ $absence->date_absence }}</td>
                    <td>
                        @if($absence->justifier)
                            Justifiée
                        @else
                            Non Justifiée
                        @endif
                    </td>
                    <td>
                        @if(!$absence->justifier)
                            <form action="{{ route('responsable.absences.updateEtat', $absence->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Justifier</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-admin>