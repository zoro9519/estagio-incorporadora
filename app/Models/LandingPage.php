<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;

    protected $table = 'landing_pages';

    protected $fillable = [
        'descricao',
        'endereco_completo',
        'percentual_acompanhe_a_obra',
        'texto_acompanhe_a_obra',
        'cor_fundo',
        'cor_texto'
    ];
}
