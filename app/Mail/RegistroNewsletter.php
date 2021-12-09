<?php

namespace App\Mail;

use App\Models\Loteamento;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistroNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loteamento;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Loteamento $loteamento, $data)
    {
        $this->user = $user;
        $this->loteamento = $loteamento;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('templates.mail.newsletter');
    }
}
