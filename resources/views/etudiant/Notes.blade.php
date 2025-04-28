<x-home titre="Page notes" page_titre="Page notes" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">
        
</x-home>
