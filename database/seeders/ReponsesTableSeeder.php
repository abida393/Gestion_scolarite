<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReponsesTableSeeder extends Seeder
{
    public function run()
    {
        
        DB::table('reponses')->insert([
            [
                'mot_cle' => 'notes',
                'reponse' => 'Vous pouvez consulter vos notes sur le portail étudiant.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'mot_cle' => 'horaires',
                'reponse' => 'Pour consulter vos horaires, allez dans la section "Emploi du temps" de votre espace étudiant.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'mot_cle' => 'mot de passe',
                'reponse' => 'Si vous avez oublié votre mot de passe, rendez-vous sur la page de connexion et cliquez sur "Mot de passe oublié". Un lien de réinitialisation vous sera envoyé par e-mail. Cliquez sur ce lien pour créer un nouveau mot de passe.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'mot_cle' => 'changer le mot de passe',
                'reponse' => 'Pour changer votre mot de passe, allez dans les paramètres de votre compte. Cliquez sur "Modifier le mot de passe". Entrez votre mot de passe actuel, puis le nouveau mot de passe. Cliquez sur "Enregistrer" pour valider les modifications.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'mot_cle' => 'emploi du temps',
                'reponse' => 'Pour consulter votre emploi du temps, cliquez sur "Emploi du temps" dans la barre latérale. Vous pourrez y voir votre emploi du temps ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mot_cle' => 'calendrier',
                'reponse' => 'Pour consulter le calendrier académique, cliquez sur "Calendrier" dans la barre latérale. Vous y trouverez toutes les dates importantes de l’année scolaire.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mot_cle' => 'demande de documents',
                'reponse' => 'Pour faire une demande de documents, cliquez sur "Demande de documents" dans la barre latérale. Remplissez le formulaire et soumettez-le. Vous serez informé lorsque votre demande sera traitée.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
            [
                'mot_cle' => 'messagerie',
                'reponse' => 'Pour accéder à la messagerie, cliquez sur "Messagerie" dans la barre latérale. Vous pourrez y envoyer et recevoir des messages.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mot_cle' => 'evenement',
                'reponse' => 'Pour consulter les événements à venir, cliquez sur "Événements" dans la barre latérale. Vous y trouverez une liste des événements prévus.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mot_cle' => 'news',
                'reponse' => 'Pour consulter les dernières nouvelles, cliquez sur "Nouvelles" dans la barre latérale. Vous y trouverez toutes les annonces récentes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mot_cle' => 'justifier',
                'reponse' => 'Pour justifier une absence, cliquez sur "Absence" dans la barre latérale. Remplissez le formulaire de justification et soumettez-le.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
         
            [
                'mot_cle' => 'absence',
                'reponse' => 'Pour justifier une absence, cliquez sur "Absence" dans la barre latérale, puis sur "Justifier une absence". Remplissez le formulaire et téléchargez votre justificatif.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                    'mot_cle' => 'paiement',
                    'reponse' => 'Pour consulter l’historique de paiement, cliquez sur "Paiement" dans la barre latérale. Vous retrouverez l’historique complet à cet endroit.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'mot_cle' => 'stage',
                    'reponse' => 'Pour postuler à un stage, cliquez sur "Stage" dans la barre latérale. Vous y trouverez toutes les offres. Si une offre vous intéresse, cliquez sur le bouton "Postuler", qui ouvrira votre boîte mail pour envoyer votre CV.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
            
        
    }
}
