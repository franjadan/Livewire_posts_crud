<div>
    <button type="button" class="btn btn-danger" wire:click="$emit('openModal', 'createModal')">Crear nuevo post</button>

    <x-modal>
        <x-slot name="id">createModal</x-slot>
        <x-slot name="title">
            Crear nuevo post
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">

                <!-- Mientras está subiendo la imagen muestro alerta -->
                <div wire:loading wire:target="image" class="mb-3">
                    <div class="alert alert-warning" role="alert">
                        <strong>¡Imagen Cargando!</strong>
                        Espere hasta que la imagen se haya procesado.
                    </div>
                </div>

                @if($image)
                    <div class="mb-3">
                        <!-- Obtener imagen temporal subida -->
                        <img class="img-fluid" src="{{ $image->temporaryUrl() }}" alt="">
                    </div>
                @endif

                <div class="mb-3">
                    <label for="title">Título del post</label>
                    <input type="text" class="form-control" id="title" wire:model="title"> <!-- El .defer es par que no renderice la vista por cada letra, solo cuando desencadenemos una acción --> <!-- Quitar .defer para validación en caliente -->

                    @error('title')
                    <p class="text-danger"><small>{{ $message }}</small></p>
                    @enderror
                </div>
                <div class="mb-3">
                    <div wire:ignore>
                        <label for="content">Contenido del post</label>
                        <textarea wire:model="content" class="form-control" id="editor2" cols="30" rows="10"></textarea>
                    </div>

                    @error('content')
                        <p class="text-danger"><small>{{ $message }}</small></p>
                    @enderror
                </div>
                <div class="mb-3">
                    <!-- Mientras está subiendo la imagen deshabilito el botón, al igual que cuando se está guardando el post -->
                    <!-- Añado un identificador que cambiará una vez se renderice el modelo, así no se mantendrá la información guardada -->
                    <input id={{ $identificador }} wire:loading.attr="disabled" wire:target="save, image" type="file" wire:model="image">

                    @error('image')
                        <p class="text-danger"><small>{{ $message }}</small></p>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <!--<button type="submit" class="btn btn-danger" wire:click="save" wire:loading.remove>Crear post</button>-->
            <!-- Mientras está ejecutando el método save desaparece el botón -->

            <!-- Este mensaje se mostrará cuando esté cargando un proceso -->
            <!-- El target es para que solo se muestre cuando se esté ejecutando save -->
            <!-- wire:loading.flex para mostrarlo don display flex (también con grid, table, etc) -->
            <!--<span wire:loading wire:target="save">Cargando...</span>-->

            <!-- Cambia la clase mientras está cargando -->
            <!--<button type="submit" class="btn btn-danger" wire:click="save" wire:loading.class="bg-primary">Crear post</button>-->

            <!-- Mientras esté cargando de deshabilita el botón -->
            <button type="submit" class="btn btn-danger" wire:click="save" wire:loading.attr="disabled">Crear post</button>
        </x-slot>
    </x-modal>

    @push('js')
        <script>
            ClassicEditor
                .create( document.querySelector( '#editor2' ) )
                .then(function(editor){
                    editor.model.document.on('change:data', () => {
                        @this.set('content', editor.getData()); //Cada vez que modifiquemos el editor se modifica la propiedad content
                    });

                    Livewire.on('resetCKEditor', () => {
                        editor.setData('');
                    });
                })
                .catch( error => {
                    console.error( error );
                } );
        </script>
    @endpush

</div>
