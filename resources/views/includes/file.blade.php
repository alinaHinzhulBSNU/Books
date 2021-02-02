<div class="row">
    <div class="label col-md-4">
        <label for="{{ $id }}">{{ $label }}</label>
    </div>
    <div class="col-md-8">
        <label for="{{ $id }}" class="custom-file-upload">
            {{ $text }}
            <i class="fas fa-file-upload"></i>
        </label>
        <input id="{{ $id }}" name="{{ $id }}" type="file"/>
        <span class="file-name failed" id="file_name">{{ $file }}</span>
    </div>
</div>

<script>
    document.getElementById('{{ $id }}').onchange = function() {
        if (this.files[0]) //якщо обрали файл
            document.getElementById('file_name').innerHTML = this.files[0].name;
        document.getElementById('file_name').classList.add('success');
    };
</script>
