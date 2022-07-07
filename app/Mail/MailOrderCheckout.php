<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailOrderCheckout extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Data for email
     *
     * @var [type]
     */
    public $dataEmail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $dataEmail)
    {
        $this->dataEmail=$dataEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.checkout');
    }
}
