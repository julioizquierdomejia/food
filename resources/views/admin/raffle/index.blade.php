@extends('adminlte::page')

@section('title', 'Sorteos')

@section('content_header')
    <h1>Listado de Sorteos</h1>
@stop

@section('content')
    <p>Administrador de Sorteos</p>


	<div class="card">
		<div class="card-body">
			<a href="{{ route('admin.raffle.create') }}" class="btn btn-primary"><i class="far fa-money-bill-alt mr-2"></i> Crear Nuevo Sorteo</a>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<table id="example" class="table table-striped table-bordered" style="width:100%">
		        <thead>
		            <tr>
		                <th>Sorteo</th>
		                <th>Fecha Inicio</th>
		                <th>Fecha Limite</th>
		                <th>Fecha Fin</th>
		                <th>Progreso</th>
		                <th>Acciones</th>
		            </tr>
		        </thead>
		        <tfoot>
		            <tr>
		                <th>Sorteo</th>
		                <th>Fecha Inicio</th>
		                <th>Fecha Limite</th>
		                <th>Fecha Fin</th>
		                <th>Progreso</th>
		                <th>Acciones</th>
		            </tr>
		        </tfoot>
		        <tbody>
		        	@foreach($sorteos as $sorteo)
		        		<tr>
			                <td>{{ $sorteo->name }}</td>
			                <td>{{ $sorteo->start_date }}</td>
			                <td>{{ $sorteo->income_limit }}</td>
			                <td>{{ $sorteo->end_date }}</td>
			                <td>
								<div class="progress">
									<div class="progress-bar progress-bar-striped" role="progressbar" style="width: 90%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
			                </td>
			                <td>
			                	<a href="{{ route('admin.raffle.edit', $sorteo) }}" class="btn btn-sm btn-warning mr-2"><i class="fas fa-edit"></i></a>

								<form method="POST" action="{{ route('admin.raffle.destroy', $sorteo) }}" style="float: right;">
									@csrf
			  						@method('DELETE')
									<button type="submit" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>
								</form>
			                </td>	
			            </tr>
		        	@endforeach
		        </tbody>
    		</table>
		</div>
	</div>

	<div class="card card-primary">
		<div class="card-body">
			<div class="row row-cols-1 row-cols-md-4">
				@foreach($sorteos as $sorteo)
					<div class="col mb-4">
						<div class="card">
							<div class="card-header bg-success">
								<h3 class="card-title font-weight-bold">{{ $sorteo->name }}</h3>
							</div>
							<div class="card-body">
								<p class="card-text font-weight-bold h5">
									US$ {{ $sorteo->cost_us }}
								</p>
							</div>
							<div class="card-footer text-right">
								<a href="{{ route('admin.offer.edit', $sorteo) }}" class="btn btn-sm btn-warning mr-2"><i class="fas fa-edit"></i></a>

								<form method="POST" action="{{ route('admin.offer.destroy', $sorteo) }}" style="float: right;">
									@csrf
			  						@method('DELETE')
									<button type="submit" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>
								</form>

							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script> 

    	/*
    	Swal.fire({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		  if (result.isConfirmed) {
		    Swal.fire(
		      'Deleted!',
		      'Your file has been deleted.',
		      'success'
		    )
		  }
		})
		*/
    </script>













@stop














