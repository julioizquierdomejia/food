<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    {!! Form::myInput('text', 'name', 'Nombre', ['required']) !!}
                    {!! Form::myInput('number', 'price', 'Precio', ['required', 'step' => '0.01']) !!}
                    {!! Form::myTextArea('description', 'Descripción', ['required', 'rows' => '3']) !!}
                    <div class="form-group">
                        <label for="category_id">Categorias</label>
                        <select class="form-control" name="category_id" id="category_id" required>
                            <option value="">-- seleccionar --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        @if($category->id == $item->category_id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    {!! Form::myFile('image', 'Imagen') !!}
                    <div class="form-group">
                        <img id="image_loaded" src="#" alt="image" style="height: 220px"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {
            readURL('', '/images/items/{{ $item->image }}')
        })

        $("#image").change(function () {
            readURL(this);
        });

        function readURL(input, src) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#image_loaded').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                $('#image_loaded').attr('src', src);
            }
        }
    </script>
@endpush
