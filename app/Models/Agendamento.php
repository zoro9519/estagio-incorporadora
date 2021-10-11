<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    public function lote(){
        return $this->belongsTo(Lote::class);
    }

    public function loteamento(){
        return $this->belongsTo(Loteamento::class);
    }

    public function corretor(){
        return $this->belongsTo(Corretor::class);
    }

    public function cliente(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
