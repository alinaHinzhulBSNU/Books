<!--Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">
                    <p>{{ $label }}</p>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body text-left">
                @isset($object->name)
                    Видалити "{{ $object->name }}" ?
                @else
                    Видалити елемент?
                @endisset
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Ні</button>
                <button type="button" class="btn btn-danger" id="{{ $id }}">Видалити</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("{{ "#".$id }}").click(function(){
            var id = {!! $object->id !!};
            $.ajax({
                url: '{{ $route."/" }}' + id,
                type: 'post',
                data: {
                    _method: 'delete',
                    _token: "{!! csrf_token() !!}"
                },
                success:function(msg){
                    location.href="{{ $route }}";
                }
            });
        });
    });
</script>
