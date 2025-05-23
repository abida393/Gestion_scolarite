<x-admin titre="calendrier-etudiant" page_titre="calendrier-etudiant" :nom_complete="Auth::guard('responsable')->user()->respo_nom . ',' . Auth::guard('responsable')->user()->respo_prenom">
</x-admin>
