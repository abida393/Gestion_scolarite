<x-home titre="Page messagerie" page_titre="Page messagerie" :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ',' . Auth::guard('etudiant')->user()->etudiant_prenom">


</x-home>
