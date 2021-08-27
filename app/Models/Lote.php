<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    public function quadra(){
        return $this->belongsTo(Quadra::class);
    }

    public function proprietarios(){
        return $this->hasMany(Proprietario::class);
    }

    public function atual(){
        return $this->hasMany(Proprietario::class)->get()->where("data_fim", null);
        // ->or("data_fim", ">=", Carbon::now());
    }

    protected $fillable = [
        'descricao',
        'area',
        'valor',
        'status',
        'quadra_id'
    ];
}
