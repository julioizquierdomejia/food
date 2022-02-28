@extends('adminlte::page')

@section('title', 'Ordenes')

@section('content_header')
    <h1>Ordenes</h1>
@stop

@section('content')
    <p>Visualizador de Ordenes</p>


    <div class="card">
        <div class="card-body">
            <h1>Registro de Ordenes</h1>
            {{-- 
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-users"></i></i> Registrar nuevo usuario</a>
             --}}
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
                            <th>Menu</th>
                            <th>Turno</th>
                            <th>Horario</th>
                            <th>Status</th>
                            <th>QR</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Perfil</th>
                            <th>Nombre</th>
                            <th>Menu</th>
                            <th>Turno</th>
                            <th>Horario</th>
                            <th>Status</th>
                            <th>QR</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($ordenes as $item)
                            <tr>
                                <td class="align-middle" >{{ $item->id }}</td>
                                <td class="align-middle" >
                                    @if( $item->uri_image == null )
                                        <img src="{{ asset('storage/images/perfil/perfil.png') }}" class="figure-img img-fluid rounded" width="36" alt="">
                                    @else
                                        <img src="{{ $item->uri_image }}{{ $item->name_image }}" class="rounded-circle" width="36" alt="">
                                    @endif
                                </td>
                                <td class="align-middle" >{{ $item->nombre }}</td>
                                <td class="align-middle" >{{ $item->menu }}</td>
                                <td class="align-middle" >{{ $item->turno }}</td>
                                <td class="align-middle" >{{ $item->horario }}</td>
                                <td class="align-middle 
                                    @if($item->status == 1)
                                        bg-success
                                    @endif
                                    @if($item->status == 2)
                                        bg-warning
                                    @endif
                                    @if($item->status == 2)
                                        bg-danger
                                    @endif
                                ">

                                    @if($item->status == 1)
                                        Solicitado
                                    @endif
                                    @if($item->status == 2)
                                        Pendiente
                                    @endif
                                    @if($item->status == 3)
                                        Entregado
                                    @endif

                                </td>
                                <td class="align-middle" >
                                    <img src="{{ $item->uri }}{{ $item->image }}" alt="" width="50">
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

    <!-- Styles para Data Tabale repsonsive con Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

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
                      title: 'El Menu ' + name + ' ha sido ' + message,
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














