<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail Étudiant - Consultation des Notes</title>
    <link rel="stylesheet" href="{{ asset('css/note.css') }}">
</head>
<body>
    <div class="container">
        <h1>Portail Étudiant - Consultation des Notes</h1>

        <div class="student-info">
            <div><strong>Nom:</strong> {{ $etudiant->nom }}</div>
            <div><strong>Prénom:</strong> {{ $etudiant->prenom }}</div>
            <div><strong>N° Étudiant:</strong> {{ $etudiant->id }}</div>
            <div><strong>Filière:</strong> {{ $etudiant->filiere }}</div>
            <div><strong>Année:</strong> {{ $etudiant->annee }}</div>
        </div>

        <div style="overflow-x: auto;">
            <table class="notes-table">
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Matière</th>
                        <th>Coeff</th>
                        <th>Examen 1</th>
                        <th>Examen 2</th>
                        <th>Rattrapage</th>
                        <th>Note Finale</th>
                        <th>Décision</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($etudiant->notes->groupBy('matiere.module.id') as $moduleId => $notesModule)
                        @php
                            $module = $notesModule->first()->matiere->module;
                            $totalCoefficient = 0;
                            $sommeNotes = 0;
                        @endphp

                        @foreach ($notesModule as $index => $note)
                            <tr class="{{ $index == 0 ? 'module-header' : '' }}">
                                @if ($index == 0)
                                    <td rowspan="{{ count($notesModule) }}">{{ $module->nom_module }}</td>
                                @endif
                                <td>{{ $note->matiere->nom_matiere }}</td>
                                <td>{{ $note->matiere->coefficient }}</td>
                                <td>{{ $note->note_exam1 ?? '-' }}</td>
                                <td>{{ $note->note_exam2 ?? '-' }}</td>
                                <td>{{ $note->note_rattrapage ?? '-' }}</td>
                                <td>{{ $note->note_finale }}</td>
                                <td class="{{ $note->note_finale >= 10 ? 'valid' : 'invalid' }}">
                                    {{ $note->note_finale >= 10 ? 'Validé' : 'Non Validé' }}
                                </td>
                            </tr>

                            @php
                                $totalCoefficient += $note->matiere->coefficient;
                                $sommeNotes += $note->note_finale * $note->matiere->coefficient;
                            @endphp
                        @endforeach

                        @php
                            $moyenneModule = $totalCoefficient > 0 ? $sommeNotes / $totalCoefficient : 0;
                        @endphp
                        <tr class="module-summary">
                            <td colspan="2"><strong>Moyenne Module</strong></td>
                            <td>{{ $totalCoefficient }}</td>
                            <td colspan="2"></td>
                            <td>-</td>
                            <td>{{ number_format($moyenneModule, 2) }}</td>
                            <td class="{{ $moyenneModule >= 10 ? 'valid' : 'invalid' }}">
                                {{ $moyenneModule >= 10 ? 'Validé' : 'Non Validé' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @php
                        $totalGeneralCoeff = $etudiant->notes->sum(fn($n) => $n->matiere->coefficient);
                        $totalGeneralNote = $etudiant->notes->sum(fn($n) => $n->note_finale * $n->matiere->coefficient);
                        $moyenneGenerale = $totalGeneralCoeff > 0 ? $totalGeneralNote / $totalGeneralCoeff : 0;
                    @endphp
                    <tr style="background-color: #e6f7ff; font-weight: bold;">
                        <td colspan="2"><strong>MOYENNE GÉNÉRALE</strong></td>
                        <td>{{ $totalGeneralCoeff }}</td>
                        <td colspan="2"></td>
                        <td>-</td>
                        <td>{{ number_format($moyenneGenerale, 2) }}</td>
                        <td class="{{ $moyenneGenerale >= 10 ? 'valid' : 'invalid' }}">
                            {{ $moyenneGenerale >= 10 ? 'Validé' : 'Non Validé' }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
