<div class="modal fade" id="modalAddWinner" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Añadir imagen de ganador</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open([
                'route' => [ ADMIN . '.photowinner'],
                'files' => true,
                'method' => 'POST',
            ])
        !!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">

                            <input type="hidden" id="id" name="id" value="">
                            {!! Form::myFile('photo', 'Banner',['required','accept="image/png, image/gif, image/jpeg"']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cerrar
                </button>
                <button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
