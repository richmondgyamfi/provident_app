<?php

namespace App\Mail;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoanApplicationSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Loan Application Submitted - Ref: '.$this->loan->application_ref,
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.loan-application-submitted',
            with: [
                'loan' => $this->loan,
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
