<div class="modal fade" id="modalAddItems" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Agregando Producto</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open([
                    'route' => [ ADMIN . '.items.store' ],
                    'files' => true
                ])
            !!}
            <div class="modal-body">
                <div class="box-body">
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
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {!! Form::myFile('image', 'Imagen', ['required'] ) !!}
                            <div class="form-group">
                                <img id="image_loaded" src="#" alt="image" style="height: 220px"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cerrar
                </button>
                <button type="submit" class="btn btn-primary">
                    Confirmar
                    <span data-toggle="tooltip" class="badge bg-navy"></span>
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {
            readURL('', '/images/items/item_default.jpg')
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
