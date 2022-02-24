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
		                <th>Premio</th>
		                <th>Meta</th>
		                <th>Fecha Inicio</th>
		                <th>Fecha Limite</th>
		                <th>Fecha Fin</th>
		                <th>Progreso</th>
		                <th>Imagen</th>
		                <th>Acciones</th>
		            </tr>
		        </thead>
		        <tfoot>
		            <tr>
		                <th>Sorteo</th>
		                <th>Premio</th>
		                <th>Meta</th>
		                <th>Fecha Inicio</th>
		                <th>Fecha Limite</th>
		                <th>Fecha Fin</th>
		                <th>Progreso</th>
		                <th>Imagen</th>
		                <th>Acciones</th>
		            </tr>
		        </tfoot>
		        <tbody>
		        	@foreach($sorteos as $sorteo)
		        		<tr>
			                <td>{{ $sorteo->name }}</td>
			                <td>US$ {{ $sorteo->prize }}</td>
			                <td>US$ {{ $sorteo->goal }}</td>
			                <td>{{ $sorteo->start_date }}</td>
			                <td>{{ $sorteo->income_limit }}</td>
			                <td>{{ $sorteo->end_date }}</td>
			                <td>
								<div class="progress">
									<div class="progress-bar progress-bar-striped" role="progressbar" style="width: 90%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
			                </td>
			                <td><img src="{{ $sorteo->uri_image }}{{ $sorteo->name_image }}" alt="" width="60"></td>
			                <td>
			                	<a href="{{ route('admin.raffle.edit', $sorteo) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>

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














