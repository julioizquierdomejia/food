@extends('adminlte::page')

@section('title', 'Áreas')

@section('content_header')
    <h1>Áreas</h1>
@stop

@section('content')
    <p>Listado de Áreas</p>

    <div class="card">
        <div class="card-body">
            <h1>Áreas</h1>
            <a href="{{ route('admin.areas.create') }}" class="btn btn-primary"><i class="far fa-money-bill-alt mr-2"></i> Crear Nueva Área</a>
        </div>
    </div>

    <div class="card">
		<div class="card-body">
			<table id="table_index" class="table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($areas as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="align-middle"> {{-- switch para Outstanding --}}
                                <form action="" method="POST">
                                    @csrf
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input check" id='{{$item->id}}' data-idUser="{{$item->id}}" data-nameUser="{{$item->name}}" {{ $item->status == 1 ? 'checked' : '' }}>
                                      <label class="custom-control-label" for="{{$item->id}}"></label>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('admin.areas.edit', $item) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="" class="btn btn-danger btn-sm delete" id="{{$item->id}}" data-idUser="{{$item->id}}"><i class="fas fa-trash"></i></a>
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
        
        $(document).ready(function(){

            // *****************************************
            //
            // modificar el Status del elemento
            //
            // *****************************************
            $(".custom-switch .check").on( 'change', function() {
                
                parent = $(this).parent();

                id = $(this).attr('data-idUser');
                name = $(this).attr('data-nameUser');

                if( $(this).is(':checked') ) {
                    valorCheck = 1;
                } else {
                    // Hacer algo si el checkbox ha sido deseleccionado
                    valorCheck = 0;
                }

                $.ajax({
                    url: "{{ route('area.updateStatus') }}",
                    method: 'POST',
                    data:{
                        _token:$('input[name="_token"]').val(),
                        status: valorCheck,
                        id: id,
                    }
                }).done(function(res){

                    if(valorCheck == 1){
                        message = 'Activado';
                    }else{
                        message = 'Desactivado';
                    }
                    Swal.fire({
                      position: 'bottom-end',
                      icon: 'success',
                      //title: 'El Menu ' + name + ' ha sido ' + message,
                      html: 'El Menu <b>' + name + '</b> ha sido ' + message,
                      showConfirmButton: false,
                      timer: 1500,
                    })
                })

            });

            // *****************************************
            //
            // eliminar Menu
            //
            // *****************************************

            $('.delete').click(function(e){

                e.preventDefault();

                id = $(this).attr('data-idUser');

                Swal.fire({
                  title: 'Estas seguro?',
                  text: "De eliminar esta área",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar!',
                  cancelButtonText: 'Cancelar'
                }).then((result) => {
                  if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/areas/"+ id,
                        method: 'DELETE',
                        data:{
                            _token:$('input[name="_token"]').val(),
                            id: id,
                        }
                    }).done(function(res){ 

                        Swal.fire(
                          'Eliminado!',
                          res,
                          'success'
                        )
                    })
                    
                  }
                })
            })

        })

    </script>


@stop