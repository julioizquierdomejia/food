<div class="container">
    <div class="row">
        <div class="col-md-12">
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
                                <option value="{{ $city->idcity }}"
                                        @if($item->idcity == $city->idcity) selected @endif>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idcountries">Country</label>
                        <select class="form-control" name="idcountries" id="idcountries">
                            <option value="">-- seleccionar --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->idcountries }}"
                                        @if($item->idcountries == $country->idcountries) selected @endif>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idcategories">Categories</label>
                        <select class="form-control" name="idcategories" id="idcategories">
                            <option value="">-- seleccionar --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->idcategories }}"
                                        @if($item->idcategories == $category->idcategories) selected @endif>
                                    {{ $category->name }}
                                </option>
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
                        <input type="time" class="input-group-sm form-control col-md-4" name="start_lunes"
                               value="{{ explode("-", $item->businesshours->lunes)[0] }}">
                        <input type="time" class="input-group-sm form-control col-md-4" name="end_lunes"
                               value="{{ explode("-", $item->businesshours->lunes)[1] }}">
                    </div>
                    <div class="form-group row container">
                        <p class="col-md-4 mt-1 font-weight-bold">Tuesday</p>
                        <input type="time" class="input-group-sm form-control col-md-4" name="start_martes"
                               value="{{ explode("-", $item->businesshours->martes)[0] }}">
                        <input type="time" class="input-group-sm form-control col-md-4" name="end_martes"
                               value="{{ explode("-", $item->businesshours->martes)[1] }}">
                    </div>
                    <div class="form-group row container">
                        <p class="col-md-4 mt-1 font-weight-bold">Wednesday</p>
                        <input type="time" class="input-group-sm form-control col-md-4" name="start_miercoles"
                               value="{{ explode("-", $item->businesshours->miercoles)[0] }}">
                        <input type="time" class="input-group-sm form-control col-md-4" name="end_miercoles"
                               value="{{ explode("-", $item->businesshours->miercoles)[1] }}">
                    </div>
                    <div class="form-group row container">
                        <p class="col-md-4 mt-1 font-weight-bold">Thursday</p>
                        <input type="time" class="input-group-sm form-control col-md-4" name="start_jueves"
                               value="{{ explode("-", $item->businesshours->jueves)[0] }}">
                        <input type="time" class="input-group-sm form-control col-md-4" name="end_jueves"
                               value="{{ explode("-", $item->businesshours->jueves)[1] }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row container">
                        <p class="col-md-4 mt-1 font-weight-bold">Friday</p>
                        <input type="time" class="input-group-sm form-control col-md-4" name="start_viernes"
                               value="{{ explode("-", $item->businesshours->viernes)[0] }}">
                        <input type="time" class="input-group-sm form-control col-md-4" name="end_viernes"
                               value="{{ explode("-", $item->businesshours->viernes)[1] }}">
                    </div>
                    <div class="form-group row container">
                        <p class="col-md-4 mt-1 font-weight-bold">Saturday</p>
                        <input type="time" class="input-group-sm form-control col-md-4" name="start_sabado"
                               value="{{ explode("-", $item->businesshours->sabado)[0] }}">
                        <input type="time" class="input-group-sm form-control col-md-4" name="end_sabado"
                               value="{{ explode("-", $item->businesshours->sabado)[1] }}">
                    </div>
                    <div class="form-group row container">
                        <p class="col-md-4 mt-1 font-weight-bold">Sunday</p>
                        <input type="time" class="input-group-sm form-control col-md-4" name="start_domingo"
                               value="{{ explode("-", $item->businesshours->domingo)[0] }}">
                        <input type="time" class="input-group-sm form-control col-md-4" name="end_domingo"
                               value="{{ explode("-", $item->businesshours->domingo)[1] }}">
                    </div>
                </div>
            </div>
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
