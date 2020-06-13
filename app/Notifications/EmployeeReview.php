<?php

namespace App\Notifications;

use App\Interview;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmployeeReview extends Notification implements ShouldQueue
{
    use Queueable;
    protected $interview;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Interview $interview)
    {
        $this->interview = $interview;
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

    
    public function toDatabase($notifiable)
    {
        return [
            'interview_id' => $this->interview->id,
            'seeker_review' => $this->interview->seeker_review,
            'employee_name' => $this->interview->employee->name,
        ];
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
            'interview_id' => $this->interview->id,
            'seeker_review' => $this->interview->seeker_review,
            'employee_name' => $this->interview->employee->name,
        ];
    }
}
