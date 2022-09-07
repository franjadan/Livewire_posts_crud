<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class ShowPosts extends Component
{

    public $search;
    public $sort = 'id';
    public $direction = 'desc';

    public function render()
    {

        $posts = Post::where('title', 'like', '%' . $this->search . '%')
        ->orWhere('content', 'like', '%' . $this->search . '%')
        ->orderBy($this->sort, $this->direction)
        ->get();

        return view('livewire.show-posts', compact('posts'))->extends('layouts.app')->section('content'); //Tengo que poner la seccion donde va a ir el contenido ya que si lo pongo directamente en la plantilla del componente no funciona la reactividad
    }

    //Para realizar una ordenación de la tabla
    public function order($sort){
        if($this->sort == $sort){
            if($this->direction == 'desc'){
                $this->direction = 'asc';
            }else{
                $this->direction = 'desc';
            }
        }else{
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }
}
