<div class="form-group">
    <div class="row">
        <select id="{{ $id  }}" name="{{ $id }}" class="form-control {{ $errors->has($id) ? 'invalid':'' }}">
            <option selected disabled value="0">{{ $placeholder }}</option>
            @foreach($collection as $item)
                <option @isset($object) @if($object->$id == $item->id) selected @endif @endisset
                value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <script>
        document.getElementById('{{ $id }}').onchange = function() {
            var id = document.getElementById('{{ $id }}').value;
            var url = "{{ $route }}/" + id + "/books";
            location.href = url;
        };
    </script>
</div>
