<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="item_id">Producto</label>
                        <select class="form-control" name="item_id" id="item_id" required>
                            <option value="">-- seleccionar --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" price="{{ $item->price }}"
                                        @if($item->id == $raffle->item_id) selected @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {!! Form::myInput('number', 'raffle_goal_amount', 'Precio de Rifa:', ['required']) !!}
                    <div class="form-group">
                        <label for="start_date">Fecha Inicio</label>
                        <input type="date" name="start_date" id="start_date"
                               class="form-control" value="{{ $raffle->start_date->format('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="end_date">Fecha Fin</label>
                        <input type="date" name="end_date" id="end_date"
                               class="form-control" value="{{ $raffle->end_date->format('Y-m-d') }}">
                    </div>
                </div>
                {{-- <div class="col-md-6 repeater">
                    <p class="font-weight-bold">TICKETS |
                        <a href="#" data-repeater-create>agregar<i class="ti-plus"></i></a>
                    </p>
                    <div data-repeater-list="tickets">
                        @foreach($tickets as $ticket)
                            <div class="row" data-repeater-item>
                                <div class="form-group col-md-5">
                                    <label for="quantity">Cantidad</label>
                                    <input type="number" name="quantity" id="quantity"
                                           required class="form-control" value="{{ $ticket->quantity }}">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="price">Precio</label>
                                    <input type="number" name="price" id="price" step="0.01"
                                           required class="form-control" value="{{ $ticket->price }}">
                                </div>
                                <div class="form-group col-md-2" style="padding-top: 2rem!important">
                                    <button type="button" data-repeater-delete
                                            class="btn btn-sm text-danger" id="btn-add">
                                        <i class="ti-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> --}}
            </div>
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
