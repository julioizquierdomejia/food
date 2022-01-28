@extends('admin.default')

@section('page-header')
    
@stop

@section('content')
    

    <div class="card">
    	<div class="card-body">

    		{{ $item->id }}

    		<form action="" method="POST" enctype="multipart/form-data">
    			@csrf
    			@method('put')

    			<div class="form-group">
    				<label for="name">
    					id
    					<br>
    					<input type="text" name="id">
    				</label>
    				<label for="name">
    					Nombre
    					<br>
    					<input type="text" name="name">
    				</label>
    				<br>
    				<label for="phone">
    					Celular
    					<br>
    					<input type="text" name="phone">
    				</label>
					<br>
    				
    				<div class="card">
    					<div class="card-body">
    						<label for="avatar">
		    					Avatar
		    					<br>
		    					<input type="file" name="avatar">
		    				</label>
		    			</div>
    				</div>
    			</div>

    			<button type="submit" class="btn btn-success">Enviar</button>

    		</form>
    	</div>
    </div>

@stop
