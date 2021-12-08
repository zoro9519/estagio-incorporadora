<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Asset
 * @param $type
 * @param $filepath
 */
class Asset extends Model
{
    use HasFactory;

    const IMAGE = 'I';
    const VIDEO = 'V';

    protected $fillable = [
        'filepath',
        'type'
    ];

    public function scopeImages()
    {
        return $this->where("type", self::IMAGE);
    }
    public function scopeVideos()
    {
        return $this->where("type", self::VIDEO);
    }
}
