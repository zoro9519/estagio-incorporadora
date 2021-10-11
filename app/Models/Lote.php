<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    public function quadra(){
        return $this->belongsTo(Quadra::class);
    }

    public function proprietarios(){
        return $this->hasMany(Proprietario::class);
    }

    public function atual(){
        return $this->hasMany(Proprietario::class)->where("data_fim", null)->get();
        // ->or("data_fim", ">=", Carbon::now());
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    public function venda()
    {
        return $this->hasOne(Venda::class);
    }

    public function interessados()
    {
        return $this->belongsToMany(User::class, 'newsletter_lote_users', 'lote_id', 'user_id');
    }

    protected $fillable = [
        'descricao',
        'area',
        'valor',
        'status',
        'quadra_id'
    ];
}
