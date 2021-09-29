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
                    <th>Cant. Tickets Comprados</th>
                    <th>Precio</th>
{{--                    <th></th>--}}
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Cliente</th>
                    <th>Producto Rifado</th>
                    <th>Estado</th>
                    <th>Fecha Sorteo</th>
                    <th>Cant. Tickets Comprados</th>
                    <th>Precio</th>
{{--                    <th></th>--}}
                </tr>
                </tfoot>

                <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->client }}</td>
                        <td>{{ $sale->product }}</td>
                        <td>{{ $sale->raffled ? 'Sorteo Finalizado' : 'Sorteo en Proceso' }}</td>
                        <td>{{ explode(' ', $sale->end_date)[0]  }}</td>
                        <td>{{ $sale->precio  }}</td>
                        <td>{{ $sale->quantity  }}</td>
{{--                        <td>--}}
{{--                            <button class="btn btn-info btn-sm" title="Detalles"><i class="ti-list"></i></button>--}}
{{--                        </td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
