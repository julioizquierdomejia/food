@extends('adminlte::page')

@section('title', 'Crear Sorteo')

@section('content_header')
    <h1>Crear Nuevo Sorteo</h1>
@stop

@section('content')
    <p>Administrador de Sorteos</p>


	<div class="card">
		<div class="card-body">
			<a href="{{ route('admin.raffle.index') }}" class="btn btn-info"><i class="fas fa-list-ul mr-2"></i> Ver listado</a>
		</div>
	</div>
	


		<form action="{{ route('admin.raffle.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			
			<div class="row">
				<div class="col-12 col-md-8">
					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="name">Nombre del Sorteo</label>
									<input type="text" class="form-control" name='name' placeholder="Nombre de la Oferta" value="{{ old('name') }}">
									@error('name')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>

								<div class="form-group col-md-8">
									<label for="image">Imagen del Sorteo</label>
									<div class="input-group mb-3">
										
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="image_sorteo" aria-describedby="inputGroupFileAddon03" name="image">
											<label class="custom-file-label" for="image">Elegir imagen</label>
										</div>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="cost_us">Fecha de inicio</label>
									<textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="start_date">Fecha de inicio</label>
									<div class="input-group date">
										<input id="datepicker1" width="276" name="start_date" />
										@error('start_date')
											<div><small class="text-danger">* {{ $message }}</small></div>
										@enderror
									</div>
								</div>

								<div class="form-group col-md-4">
									<label for="income_limit">Fecha Limite</label>
									<input id="datepicker2" width="276" name="income_limit" />
									<!--input type="number" class="form-control" name='cost_us' placeholder="Costo de la oferta"-->
									@error('income_limit')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>

								<div class="form-group col-md-4">
									<label for="end_date">Fecha de Finalizado</label>
									<input id="datepicker3" width="276" name="end_date" />
									<!--input type="number" class="form-control" name='cant' placeholder="Cantidad de Rifas"-->
									@error('end_date')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>

							</div>
							<button type="submit" class="btn btn-primary">Registrar</button>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="name">Elegir Ofertas</label>

									<input type="text" name="ofertas_array" id="ofertas">

									@foreach($ofertas as $oferta)
										<div class="btn-group-toggle mb-2">
											<label class="btn btn-secondary">
												<input type="checkbox" id="{{ $oferta->id }}" class="checkBox" name="ofertas[]"> {{ $oferta->name }}
												<i class="far fa-check-circle ml-2 d-none"></i> 
											</label>
										</div>

										{{--  
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="{{ $oferta->id }}" id="{{ $oferta->id }}" name="ofertas[]">
											<label class="form-check-label" for="defaultCheck1">
												<span class="badge badge-pill badge-primary">{{ $oferta->name }}</span>
												 - US$. {{ $oferta->cost_us }}
											</label>
										</div>
										--}}
									@endforeach
									
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
<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"-->


    <script>
    	$("#image_sorteo").on('change', function() {
		    var fileName = $(this).val().split("\\").pop();
		    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);        

		})

		$('#sandbox-container .input-group.date').datepicker({
		});

		$('#datepicker1').datepicker({
            uiLibrary: 'bootstrap4'
        });

        $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4'
        });

        $('#datepicker3').datepicker({
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
				$('#ofertas').val(ids_array);


			}else{
				$(this).parent().addClass('bg-secondary');	
				$(this).parent().removeClass('bg-warning');

				ids_array.forEach(function(attr, index, object) {
					if(attr === me.attr('id')){
						ids_array.splice(index, 1);
						$('#ofertas').val(ids_array);
					}
				});
			}
			
		});

		//sistema de seleccionador de attributos
		/*
		$('.btn-checkBox').click(function(){



			me = $(this)

			if($(this).is(':checked')){
				console.log('has chekeado' + $(this).attr('id'))
				ids_array.push($(this).attr('id'))
				$('#ofertas').val(ids_array);
			}else{
				//console.log('has quitado el check' + $(this).attr('id'))
				ids_array.forEach(function(attr, index, object) {
					if(attr === me.attr('id')){
						ids_array.splice(index, 1);
						$('#ofertas').val(ids_array);
					}
				});
			}


			//$('.idAttr').val('hola');
		})
		*/


    </script>
@stop























