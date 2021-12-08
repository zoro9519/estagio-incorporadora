<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const STATUS_EMESPERA = 'A';
    const STATUS_APROVADO = 'V';
    const STATUS_RECUSADO = 'E';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function lotesDeInteresse(){
        return $this->belongsToMany(Lote::class, "newsletter_lote_users", "user_id", "lote_id");
    }

    public function loteamentosDeInteresse(){
        return $this->belongsToMany(Loteamento::class, "newsletter_loteamento_users", "user_id", "loteamento_id");
    }

    public function agendamentos(){
        return $this->hasMany(Agendamento::class);
    }

    public function compras() {
        return $this->hasMany(Venda::class, 'user_id');
    }
}
