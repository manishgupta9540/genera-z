<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentDueDate extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $dueDate;
    protected $assignmentTitle;

    public function __construct($dueDate, $assignmentTitle)
    {
         $this->dueDate = $dueDate;
        $this->assignmentTitle = $assignmentTitle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    
    public function toArray($notifiable)
    {
        return [
            'dueDate' => $this->dueDate,
            'assignmentTitle' => $this->assignmentTitle,
            'message' => 'Reminder: Your assignment ' . $this->assignmentTitle . "\n" . 'is due tomorrow ' . $this->dueDate,
        ];
    }
    
}
