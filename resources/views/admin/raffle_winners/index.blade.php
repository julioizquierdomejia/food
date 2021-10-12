@extends('admin.default')

@section('page-header')
    Winners <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Ganador</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                    <th style="width: 50px">Acciones</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
                </tfoot>

                <tbody>
                @foreach($winners as $winner)
                    <tr>
                        <td>{{ $winner->user ? $winner->user->name : 'Jhon Doe' }}</td>
                        <td>{{ $winner->raffle->item->name . ' - ' . $winner->raffle->item->description }}</td>
                        <td>{{ $winner->raffle->item->price }}</td>
                        <td>{{ explode(' ', $winner->win_date)[0] }}</td>
                        <td><button onclick="Chargeid({{$winner->id}})" data-toggle="modal" data-target="#modalAddWinner" class="btn btn-warning" >
                            <span class="ti-gallery"></span>
                        </button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('admin.raffle_winners.modal_form_winner')
    <script>
        function Chargeid(id)
        {
            $('#id').val(id);
        }
    </script>
@endsection
