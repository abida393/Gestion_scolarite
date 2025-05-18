<?php

namespace App\Exports;

use App\Models\etudiant_absence;
use App\Models\EtudiantAbsence;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AbsencesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return etudiant_absence::with(['etudiant', 'matiere', 'classe'])
            ->orderBy('date_absence', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Étudiant',
            'Classe',
            'Matière',
            'Date absence',
            'Type',
            'Durée (min)',
            'Statut',
            'Justification',
            'Date justification'
        ];
    }

    public function map($absence): array
    {
        return [
            $absence->id,
            $absence->etudiant->etudiant_nom . ' ' . $absence->etudiant->etudiant_prenom,
            $absence->classe->nom ?? 'Inconnue',
            $absence->matiere->nom ?? 'Inconnue',
            $absence->date_absence->format('d/m/Y H:i'),
            $absence->type,
            $absence->duree_minutes ?? 'N/A',
            $absence->Justifier ? 'Justifiée' : 'Non justifiée',
            $absence->justification ?? 'Aucune',
            $absence->date_justif ? $absence->date_justif->format('d/m/Y H:i') : 'N/A'
        ];
    }
    public function registerEvents(): array
{
    return [
        AfterSheet::class => function(AfterSheet $event) {
            $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(20);
            $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
            // etc.
        },
    ];
}
}