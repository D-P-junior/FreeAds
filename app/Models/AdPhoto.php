<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdPhoto extends Model
{
    protected $fillable = ['ad_id', 'path'];

    // Une photo appartient à une annonce
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}   