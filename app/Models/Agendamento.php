<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    const STATUS_AGENDADO = 'A';
    const STATUS_CANCELADO = 'C';
    const STATUS_EMESPERA = 'E';
    const STATUS_NEGADO = 'N';
    const STATUS_REALIZADO = 'R';

    const TYPE_VISITA = 'V';
    const TYPE_RESERVA = 'R';

    const colorsAdmin = [
        self::STATUS_AGENDADO => '#1C86EE',
        self::STATUS_CANCELADO => "#a54242",
        self::STATUS_EMESPERA => "#f39c12",
        self::STATUS_NEGADO => "#a54242",
        self::STATUS_REALIZADO => "#65b473"
    ];
    const colorsUser = [
        self::STATUS_AGENDADO => '#1C86EE',
        self::STATUS_CANCELADO => "#a54242",
        self::STATUS_EMESPERA => "#f39c12",
        self::STATUS_NEGADO => "#a54242",
        self::STATUS_REALIZADO => "#65b473",
        '_' => "#000",
    ];

    const labels = [
        self::STATUS_AGENDADO => '',
        self::STATUS_CANCELADO => '',
        self::STATUS_EMESPERA => '',
        self::STATUS_NEGADO => '',
        self::STATUS_REALIZADO => ''
    ];

    public function lote(){
        return $this->belongsTo(Lote::class);
    }

    public function loteamento(){
        return $this->belongsTo(Loteamento::class);
    }

    public function corretor(){
        return $this->belongsTo(Corretor::class);
    }

    public function cliente(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
