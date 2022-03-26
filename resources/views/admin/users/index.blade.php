@extends('adminlte::page') <!-- vendor/jeroennoten/laravel-adminlte/resources/views/page.blade.php -->

@section('title', 'User')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <p>Administrador de Usuarios</p>


    <div class="card">
        <div class="card-body">
            <h1>Usuarios</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-users"></i></i> Registrar nuevo usuario</a>
        </div>
    </div>
    <div class="card card-primary">
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-12 px-3 py-4">
                <table id="table_index" class="table table-striped table-bordered display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Perfil</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>DNI</th>
                            <th>Área</th>
                            <th>Cargo</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Perfil</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>DNI</th>
                            <th>Área</th>
                            <th>Cargo</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td class="align-middle" >{{ $usuario->id }}</td>
                                <td class="align-middle" >
                                    @if( $usuario->uri_image == null )
                                        <img src="{{ asset('storage/images/perfil/perfil.png') }}" class="figure-img img-fluid rounded" width="36" alt="">
                                    @else
                                        <img src="{{ $usuario->uri_image }}{{ $usuario->name_image }}" class="rounded-circle" width="36" alt="">
                                    @endif
                                    
                                </td>
                                <td class="align-middle" >{{ $usuario->name }}</td>
                                <td class="align-middle" >{{ $usuario->email }}</td>
                                <td class="align-middle" >{{ $usuario->dni }}</td>
                                <td class="align-middle" >{{ $usuario->area }}</td>
                                <td class="align-middle" >{{ $usuario->cargo }}</td>
                                <td class="align-middle" >
                                    @if($usuario->role == 1)
                                        Administrador
                                    @endif
                                    @if($usuario->role == 2)
                                        Usuario
                                    @endif
                                    @if($usuario->role == 3)
                                        Cocina
                                    @endif
                                </td>
                                <td class="align-middle"> {{-- switch para Outstanding --}}
                                    <form action="" method="POST">
                                        @csrf
                                        <div class="custom-control custom-switch">
                                          <input type="checkbox" class="custom-control-input check" id='{{$usuario->id}}' data-idUser="{{$usuario->id}}" data-nameUser="{{$usuario->name}}" {{ $usuario->status == 1 ? 'checked' : '' }}>
                                          <label class="custom-control-label" for="{{$usuario->id}}"></label>
                                        </div>
                                    </form>
                                </td>
                                <td class="align-middle" >
                                    <a href="{{ route('admin.users.edit', $usuario) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <a href="" class="btn btn-danger btn-sm delete" id="{{$usuario->id}}" data-idUser="{{$usuario->id}}"><i class="fas fa-trash"></i></a>

                                </td>   
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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
                    url: "{{ route('user.updateStatus') }}",
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
                      title: 'El Usuario ' + name + ' ha sido ' + message,
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
                  text: "De eliminar este Usuario",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar!',
                  cancelButtonText: 'Cancelar'
                }).then((result) => {
                  if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/users/"+ id,
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














