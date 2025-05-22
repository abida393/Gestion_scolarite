
<x-home titre="Détail de l'absence"  page_titre="Détail de l'absence" 
         :nom_complete="Auth::guard('etudiant')->user()->etudiant_nom . ' ' . Auth::guard('etudiant')->user()->etudiant_prenom">
    <div class="max-w-2xl mx-auto p-8 bg-white rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4">Détail de l'absence</h1>
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</p>
        <p><strong>Matière :</strong> {{ $absence->emploiTemps && $absence->emploiTemps->matiere ? $absence->emploiTemps->matiere->nom_matiere : 'Inconnue' }}</p>
        <p><strong>Type :</strong> {{ $absence->type }}</p>
        <p><strong>Statut :</strong> 
            @if($absence->Justifier)
                Justifiée
            @elseif($absence->status === 'pending')
                En attente
            @else
                Non justifiée
            @endif
        </p>
        <p><strong>Justification :</strong> {{ $absence->justification ?? 'Aucune' }}</p>
        @if($absence->justification_file)
            <p>
                <a href="{{ route('etudiant.absences.download', $absence->id) }}" class="text-blue-600 underline">
                    Télécharger le justificatif
                </a>
            </p>
        @endif
    </div>
    <a href="{{ route('etudiant.absence_justif') }}" 
   class="inline-flex items-center px-4 py-2 mb-6 mt-6 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow transition">
    <i class="fas fa-arrow-left mr-2"></i> Retour à l'accueil
</a>
</x-home>