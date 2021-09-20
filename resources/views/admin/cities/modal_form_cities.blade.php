<div class="modal fade" id="modalAddCities" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Adding City</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open([
                    'route' => [ ADMIN . '.cities.store' ]
                ])
            !!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
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
