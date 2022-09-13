<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class CreatePost extends Component
{
    public $title, $content;

    //Reglas de validación
    protected $rules = [
        'title' => ['required', 'max:10'],
        'content' => ['required', 'min:100'],
    ];

    protected $validationAttributes = [
        'title' => 'Título',
        'content' => 'Contenido'
    ];

    //Este método se activa cuando se modifique cada propiedad (validación en caliente)
    public function updated($propertyName){
        //Solo valida la propiedad que se está editando
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.create-post');
    }

    public function save(){

        //Verifica las reglas de validacion
        $this->validate();

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
