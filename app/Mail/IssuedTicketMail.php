<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IssuedTicketMail extends Mailable
{
    use SerializesModels;

    public $member;
    public $ticket;
    public $images;

    public function __construct($member, $ticket, $images)
    {
        $this->member = $member;
        $this->ticket = $ticket;
        $this->images = $images;
    }

    public function build()
    {
        return $this->subject('Your Ticket Has Been Issued')
                    ->view('emails.issued_ticket')
                    ->with([
                        'memberName' => $this->member->name,
                        'ticketId' => $this->ticket->id,
                        'images' => $this->images,
                    ]);
    }
}
