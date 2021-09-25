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
                                <option value="{{ $item->id }}"
                                        @if($item->id == $raffle->item_id) selected @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="max_tickets_number">Maximo de Tickets (opcional)</label>
                        <input type="number" name="max_tickets_number" id="max_tickets_number"
                               class="form-control" value="{{ $raffle->max_tickets_number }}">
                    </div>
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
            </div>
        </div>
    </div>
</div>
