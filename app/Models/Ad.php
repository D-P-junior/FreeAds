<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'user_id',
        'category_id', 
        'title',
        'description',
        'price',
        'localisation',
        'condition'
    ];

    // Une annonce appartient à un user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une annonce appartient à une catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
        
    }

    // Une annonce peut avoir plusieurs photos
    public function photos()
    {
        return $this->hasMany(AdPhoto::class);
    }
}