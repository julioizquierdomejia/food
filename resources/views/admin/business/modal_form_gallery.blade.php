<div class="modal fade" id="modalAddGallery" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Adding Image to Gallery Business</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open([
                'route' => [ ADMIN . '.business_gallery.save' ],
                'files' => true
                ])
            !!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <input type="hidden" name="idbusiness" value="{{ $business->idbusiness }}">
                        <div class="col-md-12">
                            {!! Form::myFile('nameimg', 'Image Gallery',['required']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
