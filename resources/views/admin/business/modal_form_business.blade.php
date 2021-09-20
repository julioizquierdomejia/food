<div class="modal fade" id="modalAddBusiness" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Adding Business</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open([
                    'route' => [ ADMIN . '.business.store' ]
                ])
            !!}
            <div class="modal-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::myInput('text', 'name', 'Name', ['required']) !!}
                            {!! Form::myInput('text', 'address', 'Address', ['required']) !!}
                            {!! Form::myInput('text', 'phone', 'Phone', ['required']) !!}
                            {!! Form::myInput('text', 'email', 'Email', ['required']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::myTextArea('description', 'Description', ['rows' => '1']) !!}
                            {!! Form::myFile('nameimg', 'Banner') !!}
                            <div class="form-group">
                                <label for="idcity">City</label>
                                <select class="form-control" name="idcity" id="idcity">
                                    <option value="">-- seleccionar --</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->idcity }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="idcountries">Country</label>
                                <select class="form-control" name="idcountries" id="idcountries">
                                    <option value="">-- seleccionar --</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->idcountries }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="idcategories">Categories</label>
                                <select class="form-control" name="idcategories" id="idcategories">
                                    <option value="">-- seleccionar --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->idcategories }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>Business Hours</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row container">
                                <p class="col-md-4 mt-1 font-weight-bold">Monday</p>
                                <input type="time" class="input-group-sm form-control col-md-4" name="start_lunes">
                                <input type="time" class="input-group-sm form-control col-md-4" name="end_lunes">
                            </div>
                            <div class="form-group row container">
                                <p class="col-md-4 mt-1 font-weight-bold">Tuesday</p>
                                <input type="time" class="input-group-sm form-control col-md-4" name="start_martes">
                                <input type="time" class="input-group-sm form-control col-md-4" name="end_martes">
                            </div>
                            <div class="form-group row container">
                                <p class="col-md-4 mt-1 font-weight-bold">Wednesday</p>
                                <input type="time" class="input-group-sm form-control col-md-4" name="start_miercoles">
                                <input type="time" class="input-group-sm form-control col-md-4" name="end_miercoles">
                            </div>
                            <div class="form-group row container">
                                <p class="col-md-4 mt-1 font-weight-bold">Thursday</p>
                                <input type="time" class="input-group-sm form-control col-md-4" name="start_jueves">
                                <input type="time" class="input-group-sm form-control col-md-4" name="end_jueves">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row container">
                                <p class="col-md-4 mt-1 font-weight-bold">Friday</p>
                                <input type="time" class="input-group-sm form-control col-md-4" name="start_viernes">
                                <input type="time" class="input-group-sm form-control col-md-4" name="end_viernes">
                            </div>
                            <div class="form-group row container">
                                <p class="col-md-4 mt-1 font-weight-bold">Saturday</p>
                                <input type="time" class="input-group-sm form-control col-md-4" name="start_sabado">
                                <input type="time" class="input-group-sm form-control col-md-4" name="end_sabado">
                            </div>
                            <div class="form-group row container">
                                <p class="col-md-4 mt-1 font-weight-bold">Sunday</p>
                                <input type="time" class="input-group-sm form-control col-md-4" name="start_domingo">
                                <input type="time" class="input-group-sm form-control col-md-4" name="end_domingo">
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
        $('#idcountries').change(function () {
            $('#idcity').val('');
        })
        $('#idcity').change(function () {
            $('#idcountries').val('');
        })
    </script>
@endpush
