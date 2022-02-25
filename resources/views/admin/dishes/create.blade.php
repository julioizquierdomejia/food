@extends('adminlte::page')

@section('title', 'Crear Plato')

@section('content_header')
    <h1>Crear Nuevo Sorteo</h1>
@stop

@section('content')
    <p>Administrador de Platos</p>


	<div class="card">
		<div class="card-body">
			<a href="{{ route('admin.dishes.index') }}" class="btn btn-info"><i class="fas fa-list-ul mr-2"></i> Ver listado de platos</a>
		</div>
	</div>
	


		<form action="{{ route('admin.dishes.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			
			<div class="row">
				<div class="col-12 col-md-8">
					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-8">
									<label for="name">Nombre del Plato</label>
									<input type="text" class="form-control" name='name' placeholder="Nombre de la Oferta" value="{{ old('name') }}">
									@error('name')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>

							</div>

							<div class="form-row">
								<div class="form-group col-md-8">
									<label for="image">Imagen del Sorteo</label>
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

							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="cost_us">Descripción - (Opción)</label>
									<textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="description">{{ old('description') }}</textarea>
								</div>
								@error('description')
									<div><small class="text-danger">* {{ $message }}</small></div>
								@enderror
							</div>

							<button type="submit" class="btn btn-primary">Registrar Platos</button>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="name">Elegir Tipo de Comida</label>

									<input type="text" name="type" id="tipo">
									
									@error('tipo')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror

									<div class="btn-group-toggle mb-2">
										<label class="btn btn-secondary">
											<input type="checkbox" id="0" class="checkBox" name="tipo[]"> Entrada
										</label>
									</div>
									<div class="btn-group-toggle mb-2">
										<label class="btn btn-secondary">
											<input type="checkbox" id="1" class="checkBox" name="tipo[]"> Plato de fondo
										</label>
									</div>
									<div class="btn-group-toggle mb-2">
										<label class="btn btn-secondary">
											<input type="checkbox" id="2" class="checkBox" name="tipo[]"> Postre
										</label>
									</div>
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
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>


    <script>
    	$("#upLoadImage").on('change', function() {
		    var fileName = $(this).val().split("\\").pop();
		    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);        

		})

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





















