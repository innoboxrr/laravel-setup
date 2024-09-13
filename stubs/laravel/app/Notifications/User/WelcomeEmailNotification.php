<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $appName = config('app.name');

        return (new MailMessage)
                    ->subject(__('🎉 Welcome to :appName! Your Journey Begins Here 🚀', ['appName' => $appName]))
                    ->greeting(__('👋 Hello, :name!', ['name' => $notifiable->name]))
                    ->line(__('We’re beyond excited to have you join us at :appName, the leading platform for technology courses! 🌟', ['appName' => $appName]))
                    ->line(__('Unlock limitless opportunities to learn, grow, and boost your career with us. Your path to success starts now! 💼'))
                    ->action(__('🚀 Get Started Now! 🚀'), url('/'))
                    ->line(__('If you have any questions, feel free to reach out to us anytime at 📧 support@dbcloud.us. We’re here to help!'))
                    ->line(__('Best wishes and happy learning,'))
                    ->line(__('The :appName Team', ['appName' => $appName]))
                    ->salutation(''); // Optional: You can add a custom closing here if needed
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
