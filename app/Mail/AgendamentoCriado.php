<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Agendamento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AgendamentoCriado extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Agendamento $agendamento;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Agendamento $agendamento)
    {
        $this->user = $user;
        $this->agendamento = $agendamento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('template.mail.agendamento-criado');
    }
}
