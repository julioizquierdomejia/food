@extends('adminlte::page')

@section('title', 'Slider')

@section('content_header')
    <h1>Slider</h1>
@stop

@section('content')
    <p>Administrador de Slider de publicidad App mobile</p>


	<div class="card">
		<div class="card-body">
			<a href="{{ route('admin.slider.create') }}" class="btn btn-primary"><i class="far fa-money-bill-alt mr-2"></i> Crear Nuevo Slider</a>
		</div>
	</div>
	<div class="card card-primary">
		<div class="card-body">
			<div class="row row-cols-1 row-cols-md-4">
				
				

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














