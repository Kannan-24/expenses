<?php

namespace App\Notifications;

use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupportTicketReplied extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public SupportTicket $ticket,
        public SupportMessage $message,
        public bool  $isAdmin = false
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage)
            ->subject('Support Reply: #' . $this->ticket->id)
            ->line('A new reply has been added to your support ticket.')
            ->line('Ticket Subject: ' . $this->ticket->subject)
            ->line('Reply: ' . $this->message->message)
            ->line('Replied by: ' . ($this->isAdmin ? 'Admin' : $this->ticket->user->name))
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
            'title' => 'Support Reply for Ticket #' . $this->ticket->id,
            'message' => 'A new reply has been added to' . ($this->isAdmin ? ('the ticket #' . $this->ticket->id) : 'your ticket') . ':"' . $this->ticket->subject . '"',
            'action_text' => 'View Ticket',
            'action_url' => route('support_tickets.show', $this->ticket->id),
            'type' => 'info',
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
            'title' => 'Support Reply for Ticket #' . $this->ticket->id,
            'message' =>  'A new reply has been added to' . ($this->isAdmin ? ('the ticket #' . $this->ticket->id) : 'your ticket') . ':"' . $this->ticket->subject . '"',
            'action_text' => 'View Ticket',
            'action_url' => route('support_tickets.show', $this->ticket->id),
            'type' => 'info',
        ];
    }
}
