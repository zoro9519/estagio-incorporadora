<?php

namespace App\Mail;

use App\Models\Venda;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendaRealizadaUser extends Mailable
{
    use Queueable, SerializesModels;

    public Venda $venda;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Venda $venda)
    {
        $this->venda = $venda;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('templates.mail.venda.realizada-user')->subject('Venda Realizada');
    }
}
