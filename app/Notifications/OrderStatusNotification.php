<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    use Queueable;

    public $order;
    public $status;

    public function __construct(Order $order, $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $status = strtolower($this->status);

        $subject = match ($status) {
            'completed' => 'Your MarketLink Order is Completed',
            'rejected' => 'Your MarketLink Order was Rejected',
            'cancelled' => 'Your MarketLink Order was Cancelled',
            'ready' => 'Your MarketLink Order is Ready',
            default => 'Your MarketLink Order Status Updated',
        };

        $message = match ($status) {
            'completed' =>
                'Good news! Your order has been completed successfully.',

            'rejected' =>
                'Unfortunately, your order has been rejected.',

            'cancelled' =>
                'Your order has been cancelled.',

            'ready' =>
                'Your order is ready for pickup.',

            default =>
                'Your order status has been updated.',
        };

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . ($notifiable->name ?? 'Customer') . '!')
            ->line($message)
            ->line('Order ID: #' . $this->order->id)
            ->line('Current Status: ' . ucfirst($this->status))
            ->line('Thank you for using MarketLink.')
            ->salutation('Regards, MarketLink Team');
    }
}