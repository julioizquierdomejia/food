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
            <span class="badge rounded-pill bg-warning p-2">Tiempo de cancelacion del Menu {{ $datos->cancelTime }} minutos</span>
        </div>
    </div>

    <div class="card">
		<div class="card-body">
			<table id="table_index" class="table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Costo</th>
                        <th>Cantidad</th>
                        <th>Consumidos</th>
                        <th>Imagen</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Fecha</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Costo</th>
                        <th>Cantidad</th>
                        <th>Consumidos</th>
                        <th>Imagen</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($menus as $item)
                        <tr>
                            <td class="align-middle" >{{ $item->id }}</td>
                            <td class="align-middle" >{{ \Carbon\Carbon::parse($item->date)->format('D d-M-Y')}}</td>
                            <td class="align-middle" >
                                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <a href="" class="btn verDetalle" data-idMenu="{{ $item->id }}">{{ $item->name }}</a>
                                </form>
                            </td>
                            <td class="align-middle" >{{ $item->price }}</td>
                            <td class="align-middle" >{{ $item->cost }}</td>
                            <td class="align-middle" >{{ $item->cant }}</td>
                            <td class="align-middle" >{{ $item->pedidos->count() }}</td>
                            <td class="align-middle" >
                                <img src="{{ $item->uri_image }}{{ $item->name_image }}" alt="" class="img-thumbnail rounded-circle" width="40">
                            </td>
                            <td class="align-middle"> {{-- switch para Outstanding --}}
                                <form action="" method="POST">
                                    @csrf
                                    <div class="custom-control custom-switch">
                                      <input type="checkbox" class="custom-control-input check" id='{{$item->id}}' data-idUser="{{$item->id}}" data-nameUser="{{$item->name}}" {{ $item->status == 1 ? 'checked' : '' }}>
                                      <label class="custom-control-label" for="{{$item->id}}"></label>
                                    </div>
                                </form>
                            </td>
                            
                            <td class="align-middle">
                                <a href="{{ route('admin.menus.edit', $item) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
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
                    "emptyTable": "No hay información",
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
            // Ver detalle del Menú modal para el detalle de menus
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
                    url: "{{ route('menu.updateStatus') }}",
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
                  text: "De eliminar este Menu",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar!',
                  cancelButtonText: 'Cancelar'
                }).then((result) => {
                  if (result.isConfirmed) {
                    console.log('entro al Ajax');
                    $.ajax({
                        url: "/admin/menus/"+ id,
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