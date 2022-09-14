<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;

class CreatePost extends Component
{

    use WithFileUploads; //para subir imágenes con livewire

    //$identificador -> identificador aleatorio para input file
    public $title, $content, $image, $identificador;

    //Reglas de validación
    protected $rules = [
        'title' => ['required', 'max:10'],
        'content' => ['required', 'min:10'],
        'image' => ['required', 'image', 'max:2048']
    ];

    protected $validationAttributes = [
        'title' => 'Título',
        'content' => 'Contenido',
        'image' => 'Imagen'
    ];

    //Este método se activa cuando se modifique cada propiedad (validación en caliente)
    public function updated($propertyName){
        //Solo valida la propiedad que se está editando
        $this->validateOnly($propertyName);
    }

    public function mount(){
        //Identificador aleatorio
        $this->identificador = rand();
    }

    public function render()
    {
        return view('livewire.create-post');
    }

    public function save(){

        //Verifica las reglas de validacion
        $this->validate();

        //Almacenar imagen en la carpeta donde las vamos a almacenar
        $image = $this->image->store('posts');

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $image
        ]);

        //Resetear el componente
        $this->reset();

        //Regenera el input con otro id para no guardar la información al resetear
        $this->identificador = rand();

        //Cierro el modal
        $this->dispatchBrowserEvent('closeModal');

        //Emitir un evento (renderizar la vista)
        //$this->emit('render');
        //Una vez emitido tiene que escucharlo alguien
        $this->emitTo('show-posts', 'render'); //Sin el To lo emite a todos los componentes

        $this->emit('alert', 'El post se creó correctamente');
    }
}
