<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithFileUploads;
    use WithPagination; //Para paginar de forma dinámica

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $post;
    public $image, $identificador;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = '10';
    public $readyToLoad = false;

    //Estas propiedad se pasan por la url
    //Excepciones para que no aparezcan en la url si no cambia el valor por defecto
    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => '']
    ];

    protected $rules = [
        'post.title' => ['required', 'max:10'],
        'post.content' => ['required', 'min:10'],
        'image' => ['nullable', 'sometimes', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
    ];

    protected $validationAttributes = [
        'post.title' => 'Título',
        'post.content' => 'Contenido',
        'image' => 'Imagen'
    ];

    //Eventos que está escuchando
    protected $listeners = [
        //'render' => 'render' //Cuando escuche el evento render ejecuta la función render
        'render', //Si el evento y el método tiene el mismo nombre se puede poner solo una vez
        'delete',
        'resetModal'
    ];

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    //Se ejecuta únicamente cuando cambiemos el valor de la propiedad search
    public function updatingSearch(){
        //Resetea la paginación para que no de problemas al buscar con paginación
        //Se elimina la información de la página
        $this->resetPage();
    }

    public function mount(){
        $this->identificador = rand();
        $this->post = new Post();
    }

    public function render()
    {

        /*
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('content', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);
        */

        if($this->readyToLoad){
            $posts = Post::where('title', 'like', '%' . $this->search . '%')
                ->orWhere('content', 'like', '%' . $this->search . '%')
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        }else{
            $posts = [];
        }

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

    public function edit(Post $post){
        $this->post = $post;
        //Abro el modal una vez cargado el post
        $this->emit('openModal', 'editModal');

    }

    public function update(){
        $this->validate();

        //Si se ha añadido una imagen
        if($this->image){
            //Elimino la imagen anterior
            Storage::delete($this->post->image);
            $this->post->image = $this->image->store('posts'); //Actualizo la propiedad del post con la nueva imagen
        }

        //Actualizo el post
        $this->post->save();

        $this->reset(['image', 'identificador']);

        $this->identificador = rand();

        $this->emit('closeModal', 'editModal');

        $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El post se actualizó correctamente');
    }

    public function loadPosts(){
        $this->readyToLoad = true;
    }

    public function delete(Post $post){
        $post->delete();
    }

    public function resetModal(){
        $this->emit('resetCKEditor');
        $this->reset(['image', 'identificador']);
        $this->identificador = rand();
    }
}
