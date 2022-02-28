@extends('adminlte::page')

@section('title', 'Crear Menu')

@section('content_header')
    <h1>Edita Menu - {{ $menu->name }}</h1>
@stop

@section('content')
    <p>Administrador de Menu</p>

	<div class="card">
		<div class="card-body">
			<a href="{{ route('admin.menus.index') }}" class="btn btn-info"><i class="fas fa-list-ul mr-2"></i> Ver listado de Menu</a>
		</div>
	</div>

		<form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			<div class="row">
				<div class="col-12 col-md-8">
					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-8">
									<label for="name">Nombre del Menu</label>
									<input type="text" class="form-control" name='name' placeholder="Nombre de la Oferta"
										value="{{ $menu->name }}">
									@error('name')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-8">
									<label for="image">Imagen del Menu</label>
									<div class="input-group mb-3">
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="upLoadImage" aria-describedby="inputGroupFileAddon03" name="image" value="{{ $menu->name_image }}">
											<label class="custom-file-label" for="image">{{ $menu->name_image }}</label>
										</div>
									</div>
									@error('image')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-3">
									<label for="date">Fecha del Menu</label>
									<div class="input-group date">
										<input id="datepicker1" width="276" name="date"
											value="{{ \Carbon\Carbon::parse($menu->date)->format('m/d/Y')}}" />
										@error('date')
											<div><small class="text-danger">* {{ $message }}</small></div>
										@enderror
									</div>
								</div>

								<div class="form-group col-md-3">
									<label for="cant">Cantidad</label>
									<input type="text" class="form-control" name='cant' placeholder="Cantidad" value="{{ $menu->cant }}">
									@error('cant')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>

								<div class="form-group col-md-3">
									<label for="price">Precio</label>
									<input type="text" class="form-control" name='price' placeholder="Precio" value="{{ $menu->price }}">
									@error('price')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>

								<div class="form-group col-md-3">
									<label for="cost">Costo</label>
									<input type="text" class="form-control" name='cost' placeholder="Cantidad" value="{{ $menu->cost }}">
									@error('cost')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="description">Descripción - (Opción)</label>
									<textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="description">{{ $menu->description }}</textarea>
								</div>
								@error('description')
									<div><small class="text-danger">* {{ $message }}</small></div>
								@enderror
							</div>

							<button type="submit" class="btn btn-primary">Editar Menu</button>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-12">

									<label for="name">ENTRDAS</label>

									<input type="hidden" name="type" id="tipo" value="">
									
									@error('type')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror

									@foreach($platos as $plato)
										@if($plato->type == 0)

											<div class="btn-group-toggle mb-2">

												<label class="btn bg-secondary
														@foreach($ids_array as $val)
															@if($val == $plato->id)
																bg-warning 
															@endif
														@endforeach">
													<input 
														type="checkbox"
														id="{{ $plato->id }}"
														class="checkBox" name="tipo[]"
														{{-- Revisamos los atributos que tiene el producto para meterle Check--}}
														@foreach($ids_array as $val)
															@if($val == $plato->id)
																checked 
															@endif
														@endforeach
														> {{ $plato->name }}
												</label>
												
											</div>
											
										@endif
										
									@endforeach
									
								</div>
							</div>
						</div>
					</div>

					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="name">PLATO DE FONDO</label>
									
									@error('tipo')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror

									@foreach($platos as $plato)
										@if($plato->type == 1)
											<div class="btn-group-toggle mb-2">
												<label class="btn btn-secondary 
														@foreach($ids_array as $val)
															@if($val == $plato->id)
																bg-warning 
															@endif
														@endforeach
														">
													<input type="checkbox" id="{{ $plato->id }}" class="checkBox" name="tipo[]"
														@foreach($ids_array as $val)
															@if($val == $plato->id)
																checked 
															@endif
														@endforeach
													> {{ $plato->name }}
												</label>
											</div>
										@endif
										
									@endforeach
									
								</div>
							</div>
						</div>
					</div>

					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="name">POSTRES</label>

									@error('tipo')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror

									@foreach($platos as $plato)
										@if($plato->type == 2)
											<div class="btn-group-toggle mb-2">
												<label class="btn btn-secondary
														@foreach($ids_array as $val)
															@if($val == $plato->id)
																bg-warning 
															@endif
														@endforeach">
													<input type="checkbox" id="{{ $plato->id }}" class="checkBox" name="tipo[]"
														@foreach($ids_array as $val)
															@if($val == $plato->id)
																checked 
															@endif
														@endforeach
													> {{ $plato->name }}
												</label>
											</div>
										@endif
										
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


    <script>

    	$("#upLoadImage").on('change', function() {
		    var fileName = $(this).val().split("\\").pop();
		    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);        

		})

		$('#datepicker1').datepicker({
            uiLibrary: 'bootstrap4',
        });

		const ids = {!! json_encode($ids_array) !!};

        //revisar el ezstado de mi CheckBox
        //ids_array = ids;
        ids_array = [];
        ids_array = ids;
        $('#tipo').val(ids_array);
        
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

					console.log(attr);
					console.log(me.attr('id'));

					meAttr = parseInt(me.attr('id'));//tuve que convertirlo en INT el valor era String
					//if(attr === me.attr('id')){
					if(attr === meAttr){
						console.log('coincide')
						ids_array.splice(index, 1);
						$('#tipo').val(ids_array);
					}
				});
			}
			
		});

    </script>
@stop





















