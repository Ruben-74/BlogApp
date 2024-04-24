<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //collect va rendre un tableau une collection
        $tags = collect(['Fantastique', 'Fantaisie', 'Policier', 'Horreur', 'Epouvante', 'Action', 'Romance']); 
       
        $tags->each(fn($tag) => Tag::create([ // each fera 3 tour pq il y a 3 valeur dans le tableau
            'name' => $tag,
            'slug' => Str::slug($tag),
        ]));
    
    }   
}
