@extends('adminlte::page')

@section('title', 'Crear Ofertas')

@section('content_header')
    <h1>Crear nuevas Ofertas</h1>
@stop

@section('content')
    <p>Administrador de Ofertas para las rifas</p>


	<div class="card">
		<div class="card-body">
			<a href="{{ route('admin.offer.index') }}" class="btn btn-info"><i class="fas fa-list-ul mr-2"></i> Ver listado</a>
		</div>
	</div>
	<div class="card card-primary">
		<div class="card-body">
			
			<form action="{{ route('admin.offer.update', $oferta) }}" method="POST" enctype="multipart/form-data">
    			@method('PUT')
				@csrf
				<div class="form-row">
					<div class="form-group col-md-4">
						<label for="name">Nombre de la Oferta</label>
						<input type="text" class="form-control" name='name' value="{{ old('name', $oferta->name) }}">
						@error('name')
							<div><small class="text-danger">* {{ $message }}</small></div>
						@enderror
					</div>
					<div class="form-group col-md-4">
						<label for="cost_us">Costo</label>
						<input type="number" class="form-control" name='cost_us' value="{{ old('cost_us', $oferta->cost_us) }}">
						@error('cost_us')
							<div><small class="text-danger">* {{ $message }}</small></div>
						@enderror
					</div>
					<div class="form-group col-md-4">
						<label for="cant">Cantidad de Rifas</label>
						<input type="number" class="form-control" name='cant' value="{{ old('cant', $oferta->cant) }}">
						@error('cant')
							<div><small class="text-danger">* {{ $message }}</small></div>
						@enderror
					</div>

				</div>
				<button type="submit" class="btn btn-primary">Actualizar</button>
			</form>


		</div>
	</div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop