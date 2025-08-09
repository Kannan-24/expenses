<?php

namespace App\Notifications;

use App\Models\EmiSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class EmiDueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $schedule;

    /**
     * Create a new notification instance.
     */
    public function __construct(EmiSchedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $daysUntilDue = (int) Carbon::now()->diffInDays($this->schedule->due_date, false);

        
        if ($daysUntilDue > 0) {
            $subject = "EMI Payment Due in {$daysUntilDue} day(s) - {$this->schedule->emiLoan->name}";
        } elseif ($daysUntilDue == 0) {
            $subject = "EMI Payment Due Today - {$this->schedule->emiLoan->name}";
        } else {
            $subject = "EMI Payment Overdue - {$this->schedule->emiLoan->name}";
        }

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.emi-due-notification', [
                'user' => $notifiable,
                'schedule' => $this->schedule,
                'daysUntilDue' => $daysUntilDue
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $daysUntilDue = (int) Carbon::now()->diffInDays($this->schedule->due_date, false);
        
        if ($daysUntilDue > 0) {
            $title = "EMI Due in {$daysUntilDue} day(s)";
            $message = "Your EMI payment for {$this->schedule->emiLoan->name} is due in {$daysUntilDue} day(s).";
        } elseif ($daysUntilDue == 0) {
            $title = "EMI Due Today";
            $message = "Your EMI payment for {$this->schedule->emiLoan->name} is due today.";
        } else {
            $title = "EMI Overdue";
            $message = "Your EMI payment for {$this->schedule->emiLoan->name} is overdue by " . abs($daysUntilDue) . " day(s).";
        }

        return [
            'schedule_id' => $this->schedule->id,
            'emi_loan_id' => $this->schedule->emi_loan_id,
            'loan_name' => $this->schedule->emiLoan->name,
            'emi_amount' => $this->schedule->total_amount,
            'due_date' => $this->schedule->due_date->format('Y-m-d'),
            'days_until_due' => $daysUntilDue,
            'title' => $title,
            'message' => $message,
            'action_url' => url('/emi-loans/' . $this->schedule->emi_loan_id),
            'action_text' => 'View Details'
        ];
    }
}
