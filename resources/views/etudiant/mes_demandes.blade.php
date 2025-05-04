<x-home titre="Mes demandes" page_titre="Mes demandes" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ' ' . Auth::guard('etudiant')->user()->etudiant_prenom">
    <h2>Liste de mes demandes de documents</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Type de document</th>
                <th>Année académique</th>
                <th>État</th>
                <th>Date de demande</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($demandes as $demande)
                <tr>
                    <td>{{ $demande->document->nom_document ?? 'Inconnu' }}</td>
                    <td>{{ $demande->annee_academique }}</td>
                    <td>{{ $demande->etat_demande }}</td>
                    <td>{{ $demande->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Aucune demande trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-home>
