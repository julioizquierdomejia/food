@extends('adminlte::page')

@section('title', 'Menu')

@section('content_header')
    <h1>Menus</h1>
@stop

@section('content')
    <p>Listado de Menu</p>

    <div class="card">
        <div class="card-body">
            <h1>Menu</h1>
            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary"><i class="far fa-money-bill-alt mr-2"></i> Crear Nuevo Menu</a>
        </div>
    </div>

    <div class="card">
		<div class="card-body">
			<table id="table_index" class="table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($menus as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                
                            </td>
                            <td>
                            </td>
                            <td>
                                <a href="{{ route('admin.menus.edit', $dish) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>

                                <form method="POST" action="{{ route('admin.menus.destroy', $item) }}" style="float: right;">
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
    
@stop