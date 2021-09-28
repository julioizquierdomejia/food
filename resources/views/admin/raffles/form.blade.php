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
                    {!! Form::myInput('number', 'raffle_goal_amount', 'Monto Objetivo:', ['required']) !!}
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
                <div class="col-md-6">
                </div>
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
