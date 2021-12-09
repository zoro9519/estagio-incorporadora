<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    // R - Reservado, L - Livre, V - Vendido, C - Cancelado
    const STATUS_RESERVED = 'R';
    const STATUS_AVAILABLE = 'L';
    const STATUS_SOLD = 'V';
    const STATUS_CANCELED = 'C';

    const colorsAdmin = [
        self::STATUS_RESERVED => '#f39c12',
        self::STATUS_AVAILABLE => "#65b473",
        self::STATUS_SOLD => "#a54242",
        self::STATUS_CANCELED => "#000"
    ];
    const colorsUser = [
        self::STATUS_RESERVED => '#000',
        self::STATUS_AVAILABLE => "#65b473",
        self::STATUS_SOLD => "#000",
        self::STATUS_CANCELED => "#000"
    ];

    // TODO: Criar migration para lote_assets (tabela pivô para gerenciar assets de um lote)
    public function assets()
    {
        return $this->belongsToMany(Asset::class, "lote_assets", "asset_id", "lote_id");
    }

    public function coordenadas()
    {
        return $this->belongsToMany(Coordenada::class, 'lote_coordenadas', 'lote_id', 'coordenada_id');
    }

    public function quadra()
    {
        return $this->belongsTo(Quadra::class);
    }

    public function loteamento()
    {
        return $this->hasOneThrough(Loteamento::class, Quadra::class, "id", "id", "quadra_id", "loteamento_id");
    }

    public function proprietarios()
    {
        return $this->hasMany(Proprietario::class);
    }

    public function atual()
    {
        return $this->hasMany(Proprietario::class)->where("data_fim", null);
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'lote_id');
    }

    public function lastReserva()
    {
        return $this->agendamentos()->where('type', Agendamento::TYPE_RESERVA)->orderBy('data_inicio', 'desc')->orderBy('data_fim', 'desc');
    }

    public function reservas()
    {
        return $this->agendamentos()->where('type', Agendamento::TYPE_RESERVA);
    }

    public function venda()
    {
        return $this->hasOne(Venda::class);
    }

    public function interessados()
    {
        return $this->belongsToMany(User::class, 'newsletter_lote_users', 'lote_id', 'user_id');
    }

    public function disponivelParaUser()
    {
        return !in_array($this->status, [
            self::STATUS_RESERVED,
            self::STATUS_SOLD,
            self::STATUS_CANCELED
        ]);
    }

    protected $fillable = [
        'descricao',
        'area',
        'valor',
        'status',
        'quadra_id'
    ];
}
