<div>
    <h1>Posts</h1>
    <x-card>
        <div class="form-group row">
            <input type="text" placeholder="Escriba que quiere buscar" class="form-control" wire:model="search">
        </div>

        @if($posts->count())
            <div class="row my-3">
                <div class="mt-2 table-responsive-md">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ $post->id}}</td>
                                <td>{{ $post->title}}</td>
                                <td>{{ $post->content}}</td>
                                <td>Edit</td>
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
