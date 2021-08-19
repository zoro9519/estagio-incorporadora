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

    protected $fillable = [
        'descricao'
    ];
}
