@extends('admin.default')

@section('page-header')
    Sales <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Rifa</th>
                    <th>Estado</th>
                    <th>Fecha Sorteo</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Cliente</th>
                    <th>Producto Rifado</th>
                    <th>Estado</th>
                    <th>Fecha Sorteo</th>
                </tr>
                </tfoot>

                <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->user ? $sale->user->name : 'Jhon Doe'}}</td>
                        <td>{{ $sale->ticket->raffle->item->name . ' - ' . $sale->ticket->raffle->item->description }}</td>
                        <td>{{ $sale->raffled ? 'Sorteo Finalizado' : 'Sorteo en Proceso' }}</td>
                        <td>{{ explode(' ', $sale->ticket->raffle->end_date)[0]  }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
