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
                    <th>Codigo</th>
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
                    <th>Codigo</th>
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
                    @if($sale->status == 'Success')
                        <tr>
                            <td>{{ $sale->oreder_id }}</td>
                            <td>{{ $sale->client }}</td>
                            <td>{{ $sale->product }}</td>
                            <td>{{ $sale->raffled ? 'Sorteo Finalizado' : 'Sorteo en Proceso' }}</td>
                            <td>{{ $sale->created_at }}</td>
                            <td>{{ $sale->quantity  }}</td>
                            <!--td>{{ $sale->quantity * $sale->raffle_goal_amount }}</td-->
                            <td>S/. {{ $sale->quantity * $sale->price }}</td>
    {{--                        <td>--}}
    {{--                            <button class="btn btn-info btn-sm" title="Detalles"><i class="ti-list"></i></button>--}}
    {{--                        </td>--}}
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
