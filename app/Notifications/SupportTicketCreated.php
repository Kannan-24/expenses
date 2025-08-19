<?php

namespace App\Notifications;

use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class SupportTicketCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public SupportTicket $ticket) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', FcmChannel::class];
    }

    /**
     * Get the FCM representation of the notification.
     */
    public function toFcm(object $notifiable): FcmMessage
    {
        return (new FcmMessage(notification: new FcmNotification(
            title: 'New Support Ticket Created',
            body: 'A new support ticket has been created: ' . $this->ticket->subject,
        )))->setData([
            'action_url' => route('support_tickets.show', $this->ticket->id),
        ]);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Support Ticket: #' . $this->ticket->id)
            ->line('A new support ticket has been submitted by ' . $this->ticket->user->name)
            ->line('Subject: ' . $this->ticket->subject)
            ->action('View Ticket', route('support_tickets.show', $this->ticket->id));
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

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Support Ticket',
            'message' => $this->ticket->user->name . ' created a support ticket: "' . $this->ticket->subject . '"',
            'action_text' => 'View Ticket',
            'action_url' => route('support_tickets.show', $this->ticket->id),
            'type' => 'warning',
        ];
    }
}
