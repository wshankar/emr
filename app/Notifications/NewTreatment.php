<?php

namespace App\Notifications;

use App\Treatment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTreatment extends Notification
{
    use Queueable;
    public $treatment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Treatment $treatment)
    {
        return $this->treatment = $treatment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
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
            'patientName' => $this->treatment->patient->name,
            'path' => $this->treatment->patient->id
        ];
    }

        /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'patientName' => $this->treatment->patient->name,
            'path' => $this->treatment->patient->id
        ]);
    }
}
