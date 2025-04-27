<x-home titre="Page news" page_titre="Page news" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">


</x-home>
