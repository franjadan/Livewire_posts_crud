<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class CreatePost extends Component
{
    public $title, $content;

    public function render()
    {
        return view('livewire.create-post');
    }

    public function save(){
        Post::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        //Resetear el componente
        $this->reset();

        //Cierro el modal
        $this->dispatchBrowserEvent('closeModal');

        //Emitir un evento (renderizar la vista)
        //$this->emit('render');
        //Una vez emitido tiene que escucharlo alguien
        $this->emitTo('show-posts', 'render'); //Sin el To lo emite a todos los componentes

        $this->emitTo('alert', 'El post se creó correctamente');
    }
}
