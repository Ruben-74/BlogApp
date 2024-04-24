<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = collect(['Livre', 'Jeux-vidéos', 'Film']); //collect va rendre un tableau une collection
        
        $categories->each(fn($category) => Category::create([ // each fera 3 tour pq il y a 3 valeur dans le tableau
            'name' => $category,
            'slug' => Str::slug($category),
        ]));
    
    }
}
