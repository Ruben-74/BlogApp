<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public function getRouteKeyName() : string //modifie sur l'url l'id du post par un titre slug localhost:8000/slug
    {
        return 'slug';
    }
    
    // One to Many (sans inverse) lié au post pour recuperer le post concerné par les categories car 
    // dans le model POST il y a une relation Belongs To ..
    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }

}
