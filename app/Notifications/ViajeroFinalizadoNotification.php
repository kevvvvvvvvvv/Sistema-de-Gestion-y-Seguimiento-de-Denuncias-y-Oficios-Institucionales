<?php

namespace App\Notifications;

use App\Models\Viajero;
use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ViajeroFinalizadoNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public Viajero $viajero;
    public User $creator;


    /**
     * Create a new notification instance.
     */
    public function __construct(Viajero $viajero, User $creator)
    {
        $this->viajero = $viajero;
        $this->creator = $creator;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'viajero_folio' => $this->viajero->folio,
            'message' => "Se agregó el resultado: \"{$this->viajero->resultado}\", con número de oficio: \"{$this->viajero->numOficio}\"",
            'creator_name' => $this->creator->nombre . ' ' . $this->creator->apPaterno,
            'timestamp' => now()->format('d/m/Y h:i A'), 
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => "Se agregó el resultado: \"{$this->viajero->resultado}\", con número de oficio: \"{$this->viajero->numOficio}\"",
            'creator_name' => $this->creator->nombre . ' ' . $this->creator->apPaterno,
            'timestamp' => now()->format('d/m/Y h:i A'),
        ]);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
