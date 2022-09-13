<div>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createModal">Crear nuevo post</button>

    <x-modal>
        <x-slot name="id">createModal</x-slot>
        <x-slot name="title">
            Crear nuevo post
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <div class="mb-3">
                    <label for="title">Título del post</label>
                    <input type="text" class="form-control" id="title" wire:model="title"> <!-- El .defer es par que no renderice la vista por cada letra, solo cuando desencadenemos una acción --> <!-- Quitar .defer para validación en caliente -->

                    @error('title')
                    <p class="text-danger"><small>{{ $message }}</small></p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="content">Contenido del post</label>
                    <textarea wire:model="content" class="form-control" id="content" cols="30" rows="10"></textarea>

                    @error('content')
                        <p class="text-danger"><small>{{ $message }}</small></p>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger" wire:click="save">Crear post</button>
        </x-slot>
    </x-modal>

</div>
