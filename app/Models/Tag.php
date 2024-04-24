<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    public function getRouteKeyName() : string //modifie sur l'url l'id du post par un titre slug localhost:8000/slug
    {
        return 'slug';
    }
    
    // Posts au pluriel car on peut recuperer une infinité de posts lié a ce tag
    // Belong To Many pour une relation Many To Many (inverse) (pour recuperer les posts pour un tag)
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
