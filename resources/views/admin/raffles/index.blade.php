@extends('admin.default')

@section('page-header')
    Rifas <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">
        <button data-toggle="modal" data-target="#modalAddRaffles" class="btn btn-info">
            {{ trans('app.add_button') }}
        </button>
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th >Producto</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    {{-- <th >Cantidad Tickets</th> --}}
                    <th>Progreso</th>
                    <th style="width: 150px">Acciones</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Producto</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    {{-- <th>Cantidad Tickets</th> --}}
                    <th>Progreso</th>
                    <th style="width: 150px">Acciones</th>
                </tr>
                </tfoot>

                <tbody>
                @foreach($raffles as $raffle)
                    <tr>
                        <td>{{ $raffle->item->name }}</td>
                        <td>{{ explode(' ', $raffle->start_date)[0] }}</td>
                        <td>{{ explode(' ', $raffle->end_date)[0] }}</td>
                        {{-- <td>{{ $raffle->tickets_number }}</td> --}}
                        <td>{{ ($raffle->accumulate/$raffle->item->price)*100 }} %</td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    {!! Form::open([

                                        'url'  => route(ADMIN . '.getwinner', [$raffle->id]),
                                        'method' => 'GET',
                                        ])
                                    !!}
                                    <button class="btn btn-success btn-sm" title="Rifar">
                                        <i class="ti-control-play"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{ route(ADMIN . '.raffles.edit', $raffle->id) }}"
                                       class="btn btn-primary btn-sm">
                                        <span class="ti-pencil"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class' => 'delete',
                                        'url'  => route(ADMIN . '.raffles.destroy', $raffle->id),
                                        'method' => 'DELETE',
                                        ])
                                    !!}
                                    <button class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}">
                                        <i class="ti-trash"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </li>

                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>

    @include('admin.raffles.modal_form_raffle')

@endsection
