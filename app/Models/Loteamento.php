<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Builder;

/**
 * Loteamento
 * @param $nome
 * @param $descricao
 * @param $link
 * @param $area
 * @param $coordenada_id
 */
class Loteamento extends Model
{
    use HasFactory;

    public function lotes(){
        return $this->HasManyThrough(Lote::class, Quadra::class);
    }
    
    public function quadras(){
        return $this->HasMany(Quadra::class);
    }

    public function coordenada(){
        return $this->belongsTo(Coordenada::class);
    }

    public function landingPage(){
        return $this->hasOne(LandingPage::class, 'loteamento_id');
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class, "loteamento_assets", "asset_id", "loteamento_id");
    }

    public function interessados()
    {
        return $this->belongsToMany(User::class, 'newsletter_loteamento_users', 'loteamento_id', 'user_id');
    }

    public function quadrasDisponiveis()
    {
        return $this->quadras()->whereHas('lotes', function (Builder $query) {
            return $query->whereNotIn('status', [Lote::STATUS_SOLD, Lote::STATUS_CANCELED]);
        
        });
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'loteamento_id');
    }

    public static function disponiveis()
    {
        return (new self)->has('quadrasDisponiveis');
    }

    protected $fillable = [
        'nome',
        'descricao',
        'link',
        'area',
        'coordenada_id'
    ];
}
