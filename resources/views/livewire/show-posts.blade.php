<div wire:init="loadPosts">
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
                    @if($post->image)
                        <div class="mb-3">
                            <img class="img-fluid" src="{{ Storage::url($post->image) }}" alt="">
                        </div>
                    @endif
                @endif

                <div class="mb-3">
                    <label for="title">Título del post</label>
                    <input type="text" class="form-control" id="title" wire:model="post.title">

                    @error('post.title')
                    <p class="text-danger"><small>{{ $message }}</small></p>
                    @enderror
                </div>
                <div class="mb-3">
                    <div wire:ignore>
                        <label for="content">Contenido del post</label>
                        <textarea id="editor"
                            wire:model="post.content"
                            class="form-control"
                            cols="30"
                            rows="10">
                            </textarea>
                    </div>

                    @error('post.content')
                        <p class="text-danger"><small>{{ $message }}</small></p>
                    @enderror
                </div>
                <div class="mb-3">
                    <input id={{ $identificador }} wire:loading.attr="disabled" wire:target="update, image" type="file" wire:model="image">

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
            <div class="col-md-2 d-flex align-items-center">
                <span>Mostrar</span>
                <select class="mx-2 form-control" wire:model="cant">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>Entradas</span>
            </div>
            <div class="col mx-2">
                <input type="text" placeholder="Escriba que quiere buscar" class="form-control" wire:model="search">
            </div>

            <div class="col-md-2 d-flex justify-content-end">
                @livewire('create-post')
            </div>
        </div>

        @if(count($posts))
            <div class="row my-3">
                <div class="mt-2 table-responsive-md">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col-md-1" class="cursor-pointer" wire:click="order('id')">ID
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
                                <td>{!! $item->content !!}</td>
                                <td>
                                    <div class="d-flex">
                                        <button type="button" wire:click="edit({{ $item }})" class="btn btn-primary"><i class="fas fa-edit"></i></button>
                                        <button type="button" wire:click="$emit('deletePost', {{ $item->id }})" class="ms-2 btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Si tiene al menos 2 páginas muestra el div -->
            @if($posts->hasPages())
                <div class="d-flex justify-content-end">
                    {{ $posts->links() }}
                </div>
            @endif
        @else
            <p class="mt-3">No existe ningún registro que coincida con su búsqueda.</p>
        @endif

    </x-card>


    @push('js')
        <script>
            ClassicEditor
                .create( document.querySelector('#editor' ) )
                .then(function(editor){
                    editor.model.document.on('change:data', () => {
                        @this.set('post.content', editor.getData()); //Cada vez que modifiquemos el editor se modifica la propiedad content
                    });

                    Livewire.on('resetCKEditor', () => {
                        editor.setData(@this.get('post.content'));
                    });
                })
                .catch( error => {
                    console.error( error );
                } );

                Livewire.on('deletePost', postId => {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {


                            Livewire.emitTo('show-posts', 'delete', postId);

                            Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                            )
                        }
                    });
                });
        </script>

    @endpush

</div>
