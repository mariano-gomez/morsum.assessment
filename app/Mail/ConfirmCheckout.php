<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ConfirmCheckout extends Mailable
{
    use Queueable, SerializesModels;

    public Collection $cartProducts;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $cartProducts)
    {
        $this->cartProducts = $cartProducts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('dispatches@somebusiness.com', 'Checkout confirmation Email')
            ->view('mailing.confirmCheckout');
    }
}
