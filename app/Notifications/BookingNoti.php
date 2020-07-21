<?php

namespace App\Notifications;

use App\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingNoti extends Notification
{
    use Queueable;
    public $patient;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Patient $patient)
    {
        return $this->patient = $patient;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'patientName' => $this->patient->name,
            'path' => $this->patient->id
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'patientName' => $this->patient->name,
            'path' => $this->patient->id
        ]);
    }

    public function broadcastOn()
    {
        return [
            new \Illuminate\Broadcasting\Channel('BookingChannel')
        ];
    }
}
