<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corretor extends Model
{
    use HasFactory;

    public function imobiliaria(){
        return $this->belongsTo(Imobiliaria::class);
    }

    public function vendas(){
        return $this->hasMany(Venda::class);
    }

    protected $fillable = [
        'nome', 
        'documento', 
        'phone', 
        'taxa_venda_porcentagem', 
        'taxa_venda_valor', 
        'ativo',
        'imobiliaria_id'
    ];
}
