@component('mail::message')
# Votre document est prêt !

Bonjour {{ $notifiable->etudiant_prenom }},

Votre demande de document a été traitée avec succès.

**Détails :**  
- Document : {{ $demande->document->nom_document }}  
- Année : {{ $demande->annee_academique }}  
- Date : {{ now()->format('d/m/Y H:i') }}

@if($fichierUrl)
[➡ Télécharger le document]({{ $fichierUrl }})
@else
Veuillez venir le récupérer au secrétariat.
@endif

Merci,  
{{ config('app.name') }}
@endcomponent