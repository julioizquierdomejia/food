@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <p>Administrador de Usuarios</p>


    <div class="card">
        <div class="card-body">
            <h1>Usuarios</h1>
            {{-- 
            <a href="{{ route('admin.slider.create') }}" class="btn btn-primary"><i class="far fa-money-bill-alt mr-2"></i> Crear Nuevo Slider</a>
            }
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
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>DNI</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>DNI</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->dni }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $usuario) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>

                                    <form method="POST" action="{{ route('admin.users.destroy', $usuario) }}" style="float: right;">
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














