<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quadra extends Model
{
    use HasFactory;

    public function lotes(){
        return $this->hasMany(Lote::class);
    }

    public function loteamento(){
        return $this->belongsTo(Loteamento::class);
    }

    public function coordenadas()
    {
        return $this->belongsToMany(Coordenada::class, 'quadra_coordenadas', 'quadra_id', 'coordenada_id');
    }

    public function lotesDisponiveis()
    {
        return $this->lotes()->whereNotIn('status', [Lote::STATUS_SOLD, Lote::STATUS_CANCELED]);
    }

    public function disponiveis()
    {
        return (new self)->has('lotesDisponiveis');
    }

    protected $fillable = [
        'descricao'
    ];
}
