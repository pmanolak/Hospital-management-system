<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\DTO\CreateMedicineAlertDTO;

class MedicineAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected CreateMedicineAlertDTO $dto;

    public function __construct(CreateMedicineAlertDTO $dto)
    {
        $this->dto = $dto;
    }

    public function via($notifiable)
    {
        return ['mail']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Medicine Stock Alert: ' . $this->dto->name)
            ->line("Medicine: {$this->dto->name}")
            ->line("Quantity Left: {$this->dto->quantity}")
            ->when($this->dto->expiryDate, function ($message) {
                $message->line("Expiry Date: {$this->dto->expiryDate}");
            })
            ->line('Please restock or remove expired medicines promptly.');
    }
}
