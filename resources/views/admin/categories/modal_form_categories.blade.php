@push('css')
    <style>
        input[type="checkbox"].ios8-switch {
            position: absolute;
            margin: 8px 0 0 16px;
        }

        input[type="checkbox"].ios8-switch + label {
            position: relative;
            padding: 5px 0 0 50px;
            line-height: 2.0em;
        }

        input[type="checkbox"].ios8-switch + label:before {
            content: "";
            position: absolute;
            display: block;
            left: 0;
            top: 0;
            width: 40px; /* x*5 */
            height: 24px; /* x*3 */
            border-radius: 16px; /* x*2 */
            background: #fff;
            border: 1px solid #d9d9d9;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
        }

        input[type="checkbox"].ios8-switch + label:after {
            content: "";
            position: absolute;
            display: block;
            left: 0px;
            top: 0px;
            width: 24px; /* x*3 */
            height: 24px; /* x*3 */
            border-radius: 16px; /* x*2 */
            background: #fff;
            border: 1px solid #d9d9d9;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
        }

        input[type="checkbox"].ios8-switch + label:hover:after {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        input[type="checkbox"].ios8-switch:checked + label:after {
            margin-left: 16px;
        }

        input[type="checkbox"].ios8-switch:checked + label:before {
            background: #2196f3;
        }
    </style>
@endpush
<div class="modal fade" id="modalAddCategories" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Adding Category</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open([
                    'route' => [ ADMIN . '.categories.store' ],
                    'files' => true,
                    'id' => 'categories_form'
                ])
            !!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" class="ios8-switch"
                               id="status" name="status" checked>
                        <label for="status">Active</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cerrar
                </button>
                <button type="submit" class="btn btn-primary" id="btn_guardar">
                    Confirmar
                    <span data-toggle="tooltip" class="badge bg-navy"></span>
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
