<div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fas fa-edit"></i></button>
    <x-modal>
        <x-slot name="id">editModal</x-slot>
        <x-slot name="title">
            Editar el post
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">

                <div wire:loading wire:target="image" class="mb-3">
                    <div class="alert alert-warning" role="alert">
                        <strong>¡Imagen Cargando!</strong>
                        Espere hasta que la imagen se haya procesado.
                    </div>
                </div>

                @if($image)
                    <div class="mb-3">
                        <img class="img-fluid" src="{{ $image->temporaryUrl() }}" alt="">
                    </div>
                @else
                    <div class="mb-3">
                        <img class="img-fluid" src="{{ Storage::url($post->image) }}" alt="">
                    </div>
                @endif

                <div class="mb-3">
                    <label for="title">Título del post</label>
                    <input type="text" class="form-control" id="title" wire:model="post.title">

                    @error('post.title')
                    <p class="text-danger"><small>{{ $message }}</small></p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="content">Contenido del post</label>
                    <textarea wire:model="post.content" class="form-control" id="content" cols="30" rows="10"></textarea>

                    @error('post.content')
                        <p class="text-danger"><small>{{ $message }}</small></p>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id={{ $identificador }} wire:loading.attr="disabled" wire:target="save, image" type="file" wire:model="image">

                    @error('image')
                        <p class="text-danger"><small>{{ $message }}</small></p>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger" wire:click="save" wire:loading.attr="disabled">Actualizar</button>
        </x-slot>
    </x-modal>

</div>
