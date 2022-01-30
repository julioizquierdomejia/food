<div class="modal fade" id="modalAddRaffles" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Agregando Rifa</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open([
                    'route' => [ ADMIN . '.raffles.store' ],
                ])
            !!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="item_id">Producto</label>
                                <select class="form-control" name="item_id" id="item_id" required>
                                    <option value="">-- seleccionar --</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}" price="{{ $item->price }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {!! Form::myInput('number', 'raffle_goal_amount', 'Cantidad de Rifas:', ['required']) !!}
                            <div class="form-group">
                                <label for="start_date">Fecha Inicio</label>
                                <input type="date" name="start_date" id="start_date"
                                       class="form-control" value="{{ getFecha('Y-m-d') }}">
                            </div>
                            <div class="form-group">
                                <label for="end_date">Fecha Fin</label>
                                <input type="date" name="end_date" id="end_date"
                                       class="form-control" value="{{ getFecha('Y-m-d') }}">
                            </div>
                        </div>
                        {{-- <div class="col-md-6 repeater">
                            <p class="font-weight-bold">TICKETS |
                                <a href="#" data-repeater-create>agregar<i class="ti-plus"></i></a>
                            </p>
                            <div data-repeater-list="tickets">
                                <div class="row" data-repeater-item>
                                    <div class="form-group col-md-5">
                                        <label for="quantity">Cantidad</label>
                                        <input type="number" name="quantity" id="quantity"
                                               required class="form-control">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="price">Precio</label>
                                        <input type="number" name="price" id="price" step="0.01"
                                               required class="form-control">
                                    </div>
                                    <div class="form-group col-md-2" style="padding-top: 2rem!important">
                                        <button type="button" data-repeater-delete
                                                class="btn btn-sm text-danger" id="btn-add">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
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
        $('#item_id').change(function () {
            const price = $('option:selected', this).attr('price');
            $('#raffle_goal_amount').val(price);
        });

        $(document).ready(function () {

            $('.repeater').repeater({
                hide: function (deleteElement) {
                    if (confirm('¿Eliminar Elemento?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                isFirstItemUndeletable: true
            })

        });
    </script>
@endpush
