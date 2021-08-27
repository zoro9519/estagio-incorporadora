<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imobiliaria extends Model
{
    use HasFactory;

    public function corretores(){
        return $this->hasMany(Corretor::class);
    }

    protected $fillable = [

    ];
}
