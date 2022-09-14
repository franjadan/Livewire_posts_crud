<div>
    <h1>Posts</h1>

    <!-- modal editar -->

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
                    <input id={{ $identificador }} wire:loading.attr="disabled" wire:target="edit, image" type="file" wire:model="image">

                    @error('image')
                        <p class="text-danger"><small>{{ $message }}</small></p>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger" wire:click="update" wire:loading.attr="disabled">Actualizar</button>
        </x-slot>
    </x-modal>
    <!-- Fin modal editar -->

    <x-card>

        <div class="d-flex justify-content-between">
            <div class="form-group col-md-6">
                <input type="text" placeholder="Escriba que quiere buscar" class="form-control" wire:model="search">
            </div>

            <div>
                @livewire('create-post')
            </div>
        </div>

        @if($posts->count())
            <div class="row my-3">
                <div class="mt-2 table-responsive-md">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col" class="cursor-pointer text-nowrap" wire:click="order('id')">ID
                                <!--Sort-->
                                @if($sort == 'id')
                                    @if($direction == 'asc')
                                        <i class="fas fa-sort-up mt-1" style="float: right"></i>
                                    @else
                                        <i class="fas fa-sort-down mt-1" style="float: right"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort mt-1" style="float: right"></i>
                                @endif
                            </th>
                            <th scope="col">Image</th>
                            <th scope="col" class="cursor-pointer" wire:click="order('title')">Title
                                <!--Sort-->
                                @if($sort == 'title')
                                    @if($direction == 'asc')
                                        <i class="fas fa-sort-up mt-1" style="float: right"></i>
                                    @else
                                        <i class="fas fa-sort-down mt-1" style="float: right"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort mt-1" style="float: right"></i>
                                @endif
                            </th>
                            <th scope="col" class="cursor-pointer" wire:click="order('content')">Content
                                <!--Sort-->
                                @if($sort == 'content')
                                    @if($direction == 'asc')
                                        <i class="fas fa-sort-up mt-1" style="float: right"></i>
                                    @else
                                        <i class="fas fa-sort-down mt-1" style="float: right"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort mt-1" style="float: right"></i>
                                @endif
                            </th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($posts as $item)
                            <tr class="align-middle">
                                <td>{{ $item->id}}</td>
                                <td><img class="img-fluid" src="{{ Storage::url($item->image) }}" alt="" title="" /></td>
                                <td>{{ $item->title}}</td>
                                <td>{{ $item->content}}</td>
                                <td><button type="button" wire:click="edit({{ $item }})" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fas fa-edit"></i></button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No existe ningún registro que coincida con su búsqueda.</p>
            @endif
        </div>
    </x-card>
</div>
