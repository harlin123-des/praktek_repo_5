<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $pdfContent;

    public function __construct($invoice, $pdfContent)
    {
        $this->invoice = $invoice;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Invoice: ' . $this->invoice['no_faktur'])
                    ->view('emails.invoice')
                    ->attachData($this->pdfContent, 'invoice-' . $this->invoice['no_faktur'] . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
