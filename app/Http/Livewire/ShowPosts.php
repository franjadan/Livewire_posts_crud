<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class ShowPosts extends Component
{

    //Agregamos las variables que vamos a pasarle al controlador, de forma que sean accedidas a la vista del controlador
    //public $title;

    /*
    public $titulo;

    //Para unir las variables recibidas por el controlador por las variables públicas del mismo
    public function mount($title){
        $this->titulo = $title;
    }
    */

    /*
    //Los parámetros recibidos en la ruta también se recogen con mount()

    public $name;

    public function mount($name){
        $this->name = $name;
    }
    */

    //Renderiza el contenido de la vista de la carpeta livewire/show-posts
    public function render()
    {
        /*
        return view('livewire.show-posts')
            ->layout('layouts.base'); //Extender de otra plantilla en vez de layouts/app que coge por defecto
        */

        //Enviar datos a la vista igual que con el controlador

        $posts = Post::all();

        return view('livewire.show-posts', compact('posts')); //Extender de otra plantilla en vez de app
    }
}
