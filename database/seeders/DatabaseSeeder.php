<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //En el caso de existir la carpeta de imágenes la elimino
        Storage::deleteDirectory('posts');
        //Crear carpeta para guardar imágenes
        Storage::makeDirectory('posts');

         \App\Models\Post::factory(100)->create();
    }
}
