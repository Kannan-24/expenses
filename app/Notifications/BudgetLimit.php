<?php

namespace App\Notifications;

use App\Models\Budget;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;
use PhpParser\Node\Expr\Cast\Double;

class BudgetLimit extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Budget $budget, public int $percent) {}

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
            title: 'Budget Alert: ' . $this->budget->category->name,
            body: 'You have exceeded ' . $this->percent . '% of your budget for the category: ' . $this->budget->category->name,
            image: asset('images/budget_alert.png'),
        )))->data([
            'action_url' => route('budgets.show', $this->budget->id),
        ]);
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Budget Warning: ' . $this->budget->category->name)
            ->line('You have exceeded 90% of your budget for the category: ' . $this->budget->category->name)
            ->action('View Budget', route('budgets.show', $this->budget->id))
            ->line('Adjust your spending or increase your budget if needed.');
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

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Budget Alert: ' . $this->budget->category->name,
            'message' => 'You have exceeded ' . $this->percent . '% of your budget',
            'action_text' => 'View Budget',
            'action_url' => route('budgets.show', $this->budget->id),
            'type' => 'warning',
        ];
    }
}
