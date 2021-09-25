<div class="modal fade" id="modalAddRaffles" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_id">Producto</label>
                                <select class="form-control" name="item_id" id="item_id" required>
                                    <option value="">-- seleccionar --</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="max_tickets_number">Maximo de Tickets (opcional)</label>
                                <input type="number" name="max_tickets_number" id="max_tickets_number"
                                       class="form-control">
                            </div>
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
