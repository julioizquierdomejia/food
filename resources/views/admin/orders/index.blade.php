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
                            <th>Fecha</th>
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
                            <th>Fecha</th>
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
                                <td class="align-middle" >
                                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <a href="" class="btn verDetalle" data-idMenu="{{ $item->menu_id }}">{{ $item->menu }}</a>
                                    </form>
                                </td>
                                <td class="align-middle" >{{ $item->turno }}</td>
                                <td class="align-middle" >{{ $item->horario }}</td>
                                <td class="align-middle" >{{ \Carbon\Carbon::parse($item->fecha)->format('D d-M-Y')}}</td>
                                <td class="align-middle 
                                    @if($item->status == 1)
                                        bg-success
                                    @endif
                                    @if($item->status == 2)
                                        bg-warning
                                    @endif
                                    @if($item->status == 3)
                                        bg-danger
                                    @endif
                                    @if($item->status == 4)
                                        bg-info
                                    @endif
                                ">

                                    @if($item->status == 1)
                                        Reservado
                                    @endif
                                    @if($item->status == 2)
                                        Atendido
                                    @endif
                                    @if($item->status == 3)
                                        Cancelado
                                    @endif
                                    @if($item->status == 4)
                                        No consumido
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@stop

@section('js')

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

    <script type="text/javascript" src=""></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    

    <script> 
        
        $(document).ready(function(){

            // *****************************************
            //
            // PAra el Dataatable
            //
            // *****************************************

            $('#table_index').DataTable({
                responsive: true,

                dom: 'Bfrtip',
                buttons: [
                    //'copy', 'csv', 'excel', 'pdf', 'print'
                    //'excel', 'pdf', 'print'
                    {
                        extend: 'excel',
                        text: 'Exportar a Excel la vista Actual',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Exportar a Excel Todo',
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            }
                        }
                    }
                ],

                language: {
                    "decimal": "",
                    "emptyTable": "No hay informaci??n",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            });



            // *****************************************
            //
            // Ver detalle del Men?? modal
            //
            // *****************************************
            $(".verDetalle").on( 'click', function(e) {

                e.preventDefault();

                menu_id = $(this).attr('data-idMenu');

                $.ajax({
                    url: "{{ route('menu.getMenu') }}",
                    method: 'POST',
                    data:{
                        _token:$('input[name="_token"]').val(),
                        id: menu_id,
                    }
                }).done(function(res){


                    //let datos = JSON.parse(res);

                    Swal.fire({
                      //position: 'bottom-end',
                      position: 'center',
                      //icon: 'success',
                      //html: 'La Orden <b>' + name + '</b> ha sido ' + message,
                      html: res,
                      showConfirmButton: false,
                    })
                })

            })
            
                


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
                      html: 'La Orden <b>' + name + '</b> ha sido ' + message,
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














