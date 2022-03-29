@extends('adminlte::page')

@section('title', 'Crear Menu')

@section('content_header')
    <h1>Crear Nuevo Menu</h1>
@stop

@section('content')
    <p>Administrador de Menu</p>


	<div class="card">
		<div class="card-body">
			<a href="{{ route('admin.menus.index') }}" class="btn btn-info"><i class="fas fa-list-ul mr-2"></i> Ver listado de Menu</a>
		</div>
	</div>

		<form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			
			<div class="row">
				<div class="col-12 col-md-8">
					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-8">
									<label for="name">Nombre del Menu</label>
									<input type="text" class="form-control" name='name' placeholder="Nombre del menu" value="{{ old('name') }}">
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
								<div class="form-group col-md-3">
									<label for="date">Fecha del Menu</label>
									<div class="input-group date">
										<input id="datepicker1" width="276" name="date" value="{{ old('date') }}" />
										@error('date')
											<div><small class="text-danger">* {{ $message }}</small></div>
										@enderror
									</div>
								</div>

								<div class="form-group col-md-3">
									<label for="cant">Cantidad</label>
									<input type="text" class="form-control" name='cant' placeholder="Cantidad" value="{{ old('name') }}">
									@error('cant')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>

								<div class="form-group col-md-3">
									<label for="price">Precio S/.</label>
									<input type="text" class="form-control" name='price' placeholder="Precio" value="{{ old('price') }}">
									@error('price')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>

								<div class="form-group col-md-3">
									<label for="cost">Costo S/.</label>
									<input type="text" class="form-control" name='cost' placeholder="Cantidad" value="{{ old('cost') }}">
									@error('cost')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="description">Descripción - (Opción)</label>
									<textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="description">{{ old('description') }}</textarea>
								</div>
								@error('description')
									<div><small class="text-danger">* {{ $message }}</small></div>
								@enderror
							</div>

							<button type="submit" class="btn btn-primary">Registrar Menu</button>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-4">


					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="name" data-toggle="collapse" href="#collapse_entradas" role="button" aria-expanded="false" aria-controls="collapse_entradas">ENTRDAS <i class="fas fa-angle-double-down ml-2 text-info"></i></label>

									<div class="collapse" id="collapse_entradas">
									  <input type="text" name="type" id="tipo">
									
										@error('type')
											<div><small class="text-danger">* {{ $message }}</small></div>
										@enderror

										@foreach($platos as $plato)
											@if($plato->type == 0)
												<div class="btn-group-toggle mb-2">
													<label class="btn btn-secondary">
														<input type="checkbox" id="{{ $plato->id }}" class="checkBox" name="tipo[]"> {{ $plato->name }}
													</label>
												</div>
											@endif
											
										@endforeach
									</div>									
								</div>
							</div>
						</div>
					</div>

					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="name" data-toggle="collapse" href="#collapse_segundos" role="button" aria-expanded="false" aria-controls="collapse_segundos">PLATO DE FONDO <i class="fas fa-angle-double-down ml-2 text-info"></i></label>

									<div class="collapse" id="collapse_segundos">
									  {{-- <input type="hidden" name="type" id="tipo"> --}}
									
										@error('tipo')
											<div><small class="text-danger">* {{ $message }}</small></div>
										@enderror

										@foreach($platos as $plato)
											@if($plato->type == 1)
												<div class="btn-group-toggle mb-2">
													<label class="btn btn-secondary">
														<input type="checkbox" id="{{ $plato->id }}" class="checkBox" name="tipo[]"> {{ $plato->name }}
													</label>
												</div>
											@endif
										@endforeach
									</div>									
								</div>
							</div>
						</div>
					</div>


					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="name" data-toggle="collapse" href="#collapse_postres" role="button" aria-expanded="false" aria-controls="collapse_postres">POSTRES <i class="fas fa-angle-double-down ml-2 text-info"></i></label>

									<div class="collapse" id="collapse_postres">
									  {{-- <input type="hidden" name="type" id="tipo"> --}}
									
										@error('tipo')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror

									@foreach($platos as $plato)
										@if($plato->type == 2)
											<div class="btn-group-toggle mb-2">
												<label class="btn btn-secondary">
													<input type="checkbox" id="{{ $plato->id }}" class="checkBox" name="tipo[]"> {{ $plato->name }}
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

			console.log(ids_array);
			
		});

    </script>
@stop





















