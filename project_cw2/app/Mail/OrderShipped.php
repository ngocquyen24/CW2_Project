<?php

namespace App\Mail;

use App\Mail\OrderShipped;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function build()
    {
        return $this->view('email.success')
                    ->with(['cart' => $this->cart]);
    }
}

