<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $medicines;

    public function __construct(array $medicines)
    {
        $this->medicines = $medicines;
    }

    public function build()
    {
        $body = "🚨 Medicine Stock Alert 🚨\n\n";

        foreach ($this->medicines as $medicine) {
            $body .= "Name: {$medicine->name}\n";
            $body .= "Quantity: {$medicine->quantity}\n";
            $body .= "Expiry: " . ($medicine->expiryDate ?? 'N/A') . "\n";
            $body .= "--------------------------\n";
        }

        return $this
            ->subject('🚨 Low Stock/Expiring Medicine Alert')
            ->html(nl2br(e($body))); 
    }
}
