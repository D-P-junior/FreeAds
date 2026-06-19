<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id'];

    // Une catégorie peut avoir plusieurs annonces
    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    // Une catégorie peut avoir des sous-catégories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Une catégorie peut avoir une catégorie parente
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}