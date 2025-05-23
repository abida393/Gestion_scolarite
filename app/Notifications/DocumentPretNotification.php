<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentPretNotification extends Notification
{
    use Queueable;
public $demande;
    public $fichierUrl;
    /**
     * Create a new notification instance.
     */
    public function __construct($demande, $fichierUrl = null)
    {
        $this->demande = $demande;
        $this->fichierUrl = $fichierUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
{
    return (new MailMessage)
        ->markdown('emails.document_pret', [
            'demande' => $this->demande,
            'fichierUrl' => $this->fichierUrl,
            'notifiable' => $notifiable
        ]);
}


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
