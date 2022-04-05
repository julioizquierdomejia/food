@extends('adminlte::page')

@section('title', 'Cargos')

@section('content_header')
    <h1>Cargos</h1>
@stop

@section('content')
    <p>Listado de Cargos</p>

    <div class="card">
        <div class="card-body">
            <h1>Cargos</h1>
            <a href="{{ route('admin.stalls.create') }}" class="btn btn-primary"><i class="far fa-money-bill-alt mr-2"></i> Crear Nuevo cargo</a>
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
                    @foreach($cargos as $item)
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
                                <a href="{{ route('admin.stalls.edit', $item) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
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
                    url: "{{ route('cargo.updateStatus') }}",
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
                      html: 'El Cargo <b>' + name + '</b> ha sido ' + message,
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
                    $.ajax({
                        url: "/admin/stalls/"+ id,
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