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
                    <th style="width: 25%">Ganador</th>
                    <th style="width: 25%">Producto</th>
                    <th style="width: 25%">Precio</th>
                    <th style="width: 25%">Fecha</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                </tr>
                </tfoot>

                <tbody>
                @foreach($winners as $winner)
                    <tr>
                        <td>{{ $winner->user ? $winner->user->name : 'Jhon Doe' }}</td>
                        <td>{{ $winner->raffle->item->name . ' - ' . $winner->raffle->item->description }}</td>
                        <td>{{ $winner->raffle->item->price }}</td>
                        <td>{{ explode(' ', $winner->win_date)[0] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
