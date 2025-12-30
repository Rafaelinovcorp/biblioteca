<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AutorSeeder::class,
            EditoraSeeder::class,
            CategoriaSeeder::class,
            LivroSeeder::class,
            UserSeeder::class,
            
        ]);
    }
}
