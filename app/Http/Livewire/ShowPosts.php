<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class ShowPosts extends Component
{

    public $search;

    public function render()
    {

        $posts = Post::where('title', 'like', '%' . $this->search . '%')
        ->orWhere('content', 'like', '%' . $this->search . '%')
        ->get();

        return view('livewire.show-posts', compact('posts'))->extends('layouts.app')->section('content'); //Tengo que poner la seccion donde va a ir el contenido ya que si lo pongo directamente en la plantilla del componente no funciona la reactividad
    }
}
