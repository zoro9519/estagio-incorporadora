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
}
