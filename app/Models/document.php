<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Cette ligne est cruciale
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';
protected $fillable = [
    'nom_document',
    'type',
    'template_path',
    'generable',
];
    
     // Relation avec les demandes de documents
     public function demandes()
     {
         return $this->hasMany(DemandesDocuments::class, 'id_document');
     }
}
