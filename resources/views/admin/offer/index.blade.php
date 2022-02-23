@extends('adminlte::page')

@section('title', 'Ofertas')

@section('content_header')
    <h1>Ofertas de Boletos</h1>
@stop

@section('content')
    <p>Administrador de Ofertas para las rifas</p>


	<div class="card">
		<div class="card-body">
			<a href="{{ route('admin.offer.create') }}" class="btn btn-primary"><i class="far fa-money-bill-alt mr-2"></i> Crear Nueva oferta</a>
		</div>
	</div>
	<div class="card card-primary">
		<div class="card-body">
			<div class="row row-cols-1 row-cols-md-4">
				@foreach($ofertas as $oferta)
					<div class="col mb-4">
						<div class="card">
							<div class="card-header bg-success">
								<h3 class="card-title font-weight-bold">{{ $oferta->name }}</h3>
							</div>
							<div class="card-body">
								<p class="card-text font-weight-bold h5">
									US$ {{ $oferta->cost_us }}
								</p>
							</div>
							<div class="card-footer text-right">
								<a href="{{ route('admin.offer.edit', $oferta) }}" class="btn btn-sm btn-warning mr-2"><i class="fas fa-edit"></i></a>

								<form method="POST" action="{{ route('admin.offer.destroy', $oferta) }}" style="float: right;">
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














