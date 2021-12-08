<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    public function lote() {
        return $this->belongsTo(Lote::class, 'lote_id');
    }

    public function comprador()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function corretor()
    {
        return $this->belongsTo(Corretor::class);
    }
}
