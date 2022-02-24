@extends('adminlte::page')

@section('title', 'Slider')

@section('content_header')
    <h1>Crear Slider</h1>
@stop

@section('content')
    <p>Administrador de Slider de publicidad App mobile</p>

	<div class="card card-primary">
		<div class="card-body">

				<form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="name">Nombre de la Oferta</label>
							<input type="text" class="form-control" name='name' placeholder="Nombre de la Oferta" value="{{ old('name') }}">
							@error('name')
								<div><small class="text-danger">* {{ $message }}</small></div>
							@enderror
						</div>
						
						<div class="form-group col-md-8">
							<label for="image">Imagen del Sorteo</label>
							<div class="input-group mb-3">
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="image_slider" aria-describedby="inputGroupFileAddon03" name="image">
									<label class="custom-file-label" for="image">{{ old('image', 'Elegir Imagen') }}</label>
								</div>
							</div>
							@error('image')
								<div><small class="text-danger">* {{ $message }}</small></div>
							@enderror
						</div>

					</div>
					<button type="submit" class="btn btn-primary">Registrar</button>
				</form>

		</div>
	</div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script> 

    	$("#image_slider").on('change', function() {
		    var fileName = $(this).val().split("\\").pop();
		    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		})

    </script>













@stop














