<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;
    public $filename;

    public function __construct($pdfContent, $filename)
    {
        $this->pdfContent = $pdfContent;
        $this->filename = $filename;
    }

    public function build()
    {
        return $this->subject('Bills Report PDF')
            ->html('<p>Please find attached your bills report PDF.</p>')  
            ->attachData($this->pdfContent, $this->filename, [
                'mime' => 'application/pdf',
            ])
            ->withSwiftMessage(function ($message) {
                $message->setContentType('text/html');  
            });
    }
}
