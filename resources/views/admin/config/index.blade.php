@extends('adminlte::page')

@section('title', 'Configuración')

@section('content_header')
    <h1>Configuraciones</h1>
@stop

@section('content')
    <p>Configurar datos para la gestion de los platos</p>

    <div class="card">
        <div class="card-body">
            <h1>Parametros</h1>
            <form action="{{ route('admin.config.update', $datos->id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')

				<div class="row">
					<div class="col-12 col-md-8">
						<div class="card card-primary">
							<div class="card-body">
								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="name">Tiempo de cancelación - en minutos</label>
										<input type="text" class="form-control" name='cancelTime' placeholder="Nombre de la Oferta" value="{{ old('cancelTime', $datos->cancelTime) }}">
										@error('name')
											<div><small class="text-danger">* {{ $message }}</small></div>
										@enderror
									</div>
								</div>

								<div class="form-row">
									<div class="form-group col-md-6">
										<label for="name">Cantidad de Menus Gratis</label>
										<input type="text" class="form-control" name='freeCant' placeholder="Nombre de la Oferta" value="{{ old('freeCant', $datos->freeCant) }}">
										@error('name')
											<div><small class="text-danger">* {{ $message }}</small></div>
										@enderror
									</div>
								</div>

								{{-- 
								<button type="submit" class="btn btn-primary" data-idUser="{{$datos->id}}" >Guardar</button>
								--}}
								<a href="" class="actualizar btn btn-primary">Actualizar</a>
							</div>

						</div>
					</div>
				</div>
			</form>

        </div>
    </div>

    <div class="card">
		<div class="card-body">
			
    	</div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        
        $(document).ready(function(){

            // *****************************************
            //
            // modificar el Status del elemento
            //
            // *****************************************
            $(".actualizar").on( 'click', function(e) {

            	e.preventDefault();
                
            	parent = $(this).parent();

                id = $(this).attr('data-idUser');
                //name = $(this).attr('data-nameUser');

                $.ajax({
                    url: "{{ route('admin.config.store') }}",
                    method: 'POST',
                    data:{
                        _token:$('input[name="_token"]').val(),
                        cancelacion:$('input[name="cancelTime"]').val(),
                        cantidad:$('input[name="freeCant"]').val(),
                    }
                }).done(function(res){

                    Swal.fire({
                      //position: 'bottom-end',
                      position: 'center',
                      icon: 'success',
                      html: res,
                      showConfirmButton: false,
                      //timer: 1500,
                    })
                })

            });

        })

    </script>

@stop