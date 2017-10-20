<?php

namespace App\Notifications;

use App\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ServiceRequestSubmitted extends Notification
{
    use Queueable;

    public $description;
    public $service_request_id;
    public $submitted_at;

    /**
     * Create a new notification instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->description = $request->description;
        $this->service_request_id = $request->service_request_id;
        $this->submitted_at = $request->created_at;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Uusi palaute saapunut.')
                    ->line($this->description)
                    ->action('Klikkaa suoraan palautteeseen', url('/requests/'.$this->service_request_id))
                    ->line('Tähän viestiin ei kannata vastata.')
                    ->line('Mukavaa päivänjatkoa!');
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
            'description' => $this->description,
            'service_request_id' => $this->service_request_id,
            'submitted_at' => $this->submitted_at,
        ];
    }
}
