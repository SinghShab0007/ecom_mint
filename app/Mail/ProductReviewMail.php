<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $options;

    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New review')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->view('frontend.mail.product-review')
            ->with([
                'options' => $this->options
            ]);
    }
}
