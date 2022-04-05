@extends('adminlte::page')

@section('title', 'Crear Área')

@section('content_header')
    <h1>Editar el cargo</h1>
@stop

@section('content')
    <p>Administrador de Cargos</p>


	<div class="card">
		<div class="card-body">
			<a href="{{ route('admin.stalls.index') }}" class="btn btn-info"><i class="fas fa-list-ul mr-2"></i> Ver listado de Cargos</a>
		</div>
	</div>
	
		<form action="{{ route('admin.stalls.update', $stall) }}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			<div class="row">
				<div class="col-12 col-md-8">
					<div class="card card-primary">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-8">
									<label for="name">Nombre del Área</label>
									<input type="text" class="form-control" name='name' placeholder="Área, (Administración, Contabilidad, etc)" value="{{ old('name', $stall->name) }}">
									@error('name')
										<div><small class="text-danger">* {{ $message }}</small></div>
									@enderror
								</div>

							</div>

							<button type="submit" class="btn btn-primary">Registrar Cargos</button>
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





















