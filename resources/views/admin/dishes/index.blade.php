@extends('adminlte::page')

@section('title', 'Platos')

@section('content_header')
    <h1>Platos</h1>
@stop

@section('content')
    <p>Listado de Platos</p>

    <div class="card">
        <div class="card-body">
            <h1>Platos</h1>
            <a href="{{ route('admin.dishes.create') }}" class="btn btn-primary"><i class="far fa-money-bill-alt mr-2"></i> Crear Nuevo Plato</a>
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
                    @foreach($dishes as $dish)
                        <tr>
                            <td>{{ $dish->id }}</td>
                            <td>{{ $dish->name }}</td>
                            <td>
                                @if($dish->type ==0)
                                    Entrada
                                @else
                                    @if($dish->type ==1)
                                        Plato de fondo
                                    @else
                                        @if($dish->type == 2)
                                            Postre
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($dish->status == 1)
                                    Activo
                                @else
                                    Inactivo
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.dishes.edit', $dish) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>

                                <form method="POST" action="{{ route('admin.dishes.destroy', $dish) }}" style="float: right;">
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