<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Cette ligne est cruciale
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';
     // Relation avec les demandes de documents
     public function demandes()
     {
         return $this->hasMany(DemandesDocuments::class, 'id_document');
     }
}
