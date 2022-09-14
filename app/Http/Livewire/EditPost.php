<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditPost extends Component
{
    use WithFileUploads;

    public $post;
    public $image, $identificador;

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

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function mount(Post $post){
        $this->post = $post;
        $this->identificador = rand();
    }

    public function render()
    {
        return view('livewire.edit-post');
    }

    public function save(){

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

        $this->dispatchBrowserEvent('closeModal');

        $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El post se actualizó correctamente');
    }
}
