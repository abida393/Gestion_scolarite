<x-home titre="Page emploi" page_titre="Page emploi" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">


</x-home>
