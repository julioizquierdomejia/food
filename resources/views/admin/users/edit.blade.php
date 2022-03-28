@extends('adminlte::page')

@section('title', 'Registrar Usuario')

@section('content_header')
    <h1>Registrar usuario</h1>
@stop

@section('content')
    <p>Administrador usuarios</p>


    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.users.index') }}" class="btn btn-info"><i class="fas fa-users"></i> Ver listado de Uuarios registrados </a>
        </div>
    </div>

        <form action="{{ route('admin.users.update', $item) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nombre del colaborador</label>
                                    <input type="text" class="form-control" name='name' placeholder="Nombre del colaborador" value="{{ old('name', $item->name) }}">
                                    @error('name')
                                        <div><small class="text-danger">* {{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name">Correo electrónico</label>
                                    <input type="mail" class="form-control" name='email' placeholder="Correo electronico" value="{{ old('email', $item->email) }}">
                                    @error('email')
                                        <div><small class="text-danger">* {{ $message }}</small></div>
                                    @enderror
                                </div>


                            </div>

                            <div class="form-row">
                                
                                <div class="form-group col-md-4">
                                    <label for="dni">Documento de Identidad</label>
                                    <input type="text" class="form-control" name='dni' placeholder="Documento de Identidad" value="{{ old('dni', $item->dni) }}">
                                    @error('dni')
                                        <div><small class="text-danger">* {{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="phone">Telfono</label>
                                    <input type="text" class="form-control" name='phone' placeholder="Telefono" value="{{ old('phone', $item->phone) }}">
                                    @error('phone')
                                        <div><small class="text-danger">* {{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="cost">Perfil</label>
                                    
                                    <select class="js-example-basic-single" name="role" style="width: 100%;">
                                        <option value="2" {{ 2 === $item->role ? "selected" : "" }} >Usuario - Trabajador</option>
                                        <option value="3" {{ 3 === $item->role ? "selected" : "" }}>Cocina</option>
                                        <option value="1" {{ 1 === $item->role ? "selected" : "" }}>Administrador</option>
                                    </select>

                                    @error('role')
                                        <div><small class="text-danger">* {{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="cost">Área</label>
                                    
                                    <select class="js-example-basic-single" name="area_id" style="width: 100%;">
                                        @foreach($areas as $key)
                                            <option value="{{ $key->id }}"
                                                @if($key->id == $item->area_id)
                                                    selected
                                                @endif
                                                >{{ $key->name }}</option>
                                        @endforeach
                                        
                                    </select>

                                    @error('area_id')
                                        <div><small class="text-danger">* {{ $message }}</small></div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="cost">Cargo</label>
                                    
                                    <select class="js-example-basic-single" name="stall_id" style="width: 100%;">
                                        @foreach($cargos as $cargo)
                                            <option value="{{ $cargo->id }}" 
                                                @if($cargo->id == $item->stall_id)
                                                    selected
                                                @endif
                                                >{{ $cargo->name }}</option>
                                        @endforeach
                                        
                                    </select>

                                    @error('stall_id')
                                        <div><small class="text-danger">* {{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Subi una foto de perfil</label>

                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="image"></label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="upLoadImage" aria-describedby="inputGroupFileAddon03" name="image">
                                                        <label class="custom-file-label" for="image">{{ old('image', 'Elegir Imagen') }}</label>
                                                    </div>
                                                </div>
                                                @error('image')
                                                    <div><small class="text-danger">* {{ $message }}</small></div>
                                                @enderror
                                            </div>
                                        </div>

                                            @if($item->uri_image == null)
                                                <figure class="figure d-flex justify-content-center">
                                                    <img src="{{ asset('storage/images/perfil/perfil.png') }}" class="figure d-flex figure-img img-fluid rounded-circle justify-content-center">
                                                </figure>
                                            @else
                                                <figure class="figure d-flex justify-content-center">
                                                    <img src="{{ $item->uri_image }}{{ $item->name_image }}" class="figure d-flex figure-img img-fluid rounded-circle justify-content-center">
                                                </figure>
                                            @endif
                                        
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    

                </div>
            </div>

        </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>

        $(document).ready(function() {
            //$('.js-example-basic-single').select2();
            $('select').select2({
                theme: 'bootstrap4',
            });
        });

        $("#upLoadImage").on('change', function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);        

        })

        $('#datepicker1').datepicker({
            uiLibrary: 'bootstrap4'
        });


        //revisar el ezstado de mi CheckBox
        ids_array = []
        $(".checkBox").change(function() {

            me = $(this);

            if ($(this).is(':checked')) {
                $(this).parent().addClass('bg-warning');    
                $(this).parent().removeClass('bg-secondary');

                ids_array.push($(this).attr('id'))
                $('#tipo').val(ids_array);


            }else{
                $(this).parent().addClass('bg-secondary');  
                $(this).parent().removeClass('bg-warning');

                ids_array.forEach(function(attr, index, object) {
                    if(attr === me.attr('id')){
                        ids_array.splice(index, 1);
                        $('#tipo').val(ids_array);
                    }
                });
            }
            
        });

    </script>
@stop





















