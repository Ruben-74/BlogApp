<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory(20)->create();
        
        $this->call([
            CategorySeeder::class, // placer avant le PostSeeder pour eviter une erreur car postseeder aura besoin d'un id deja existant
            TagSeeder::class, // pareil les tags avant les posts pour alimenter les post au niveau des clés étrangeres
            PostSeeder::class,
        ]);
    }
}
