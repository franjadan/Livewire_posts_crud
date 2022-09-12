<div>
    <div wire:ignore.self class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{$id}}Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="{{$id}}Label" class="modal-title">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></button>
                </div>
                <div class="modal-body">
                    {{ $content }}
                </div>
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('closeModal', event=> {
            $("#{{$id}}").modal('hide');
        });
    </script>
</div>
