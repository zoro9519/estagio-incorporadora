<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
        return $this->hasOne(LandingPage::class);
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class, "loteamento_assets", "asset_id", "loteamento_id");
    }

    public function interessados()
    {
        return $this->belongsToMany(User::class, 'newsletter_loteamento_users', 'loteamento_id', 'user_id');
    }

    protected $fillable = [
        'nome',
        'descricao',
        'link',
        'area',
        'coordenada_id'
    ];
}
