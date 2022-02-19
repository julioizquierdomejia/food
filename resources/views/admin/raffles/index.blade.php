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
                    <th>ID</th>
                    <th>Producto</th>
                    <th >Tickets vendidos</th>
                    <th >Total Tickets</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Progreso</th>
                    <th style="width: 150px">Acciones</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th >Tickets vendidos</th>
                    <th >Total Tickets</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Progreso</th>
                    <th style="width: 150px">Acciones</th>
                </tr>
                </tfoot>

                <tbody id="lista">
                    {{-- Items here --}}
                        @foreach($raffles as $raffle)
                                <tr style="cursor:move ;" data-id='{{ $raffle->id }}'>
                                    <td>{{ $raffle->item->id }}</td>
                                    <td>{{ $raffle->item->name }}</td>

                                    <td>{{ ($raffle->accumulate) }}</td>
                                    <td>{{ ($raffle->raffle_goal_amount ) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($raffle->start_date)->format('d-m-Y')}}</td>
                                    <td>{{ \Carbon\Carbon::parse($raffle->end_date)->format('d-m-Y')}}</td>
                                    {{-- <td>{{ $raffle->tickets_number }}</td> --}}
                                    <td class="text-right">
                                        {{ $raffle->porcentaje }} %
                                    </td>
                                    {{--  <td>{{ ($raffle->accumulate/$raffle->item->price)*.01 }} %</td> --}}
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
    <form action="reorder_raffles" method="POST" id="form_order">
        @csrf
    </form>


    @include('admin.raffles.modal_form_raffle')

    @push('js')
        <script>
            const lista = document.getElementById('lista');
            Sortable.create(lista, {
                animation : 350,

                onEnd: () => {
                    console.log('Se isnrtto un nuevo elemento');
                },

                store: {
                    set: (sortable) => {
                        const order = sortable.toArray();

                        //Lanzamos el ajax para guardar el re order
                        $.ajax({
                            url: 'reorder_raffles',
                            method : 'POST',
                            data: //$('#form_order').serialize(),
                            {
                                _token:$('input[name="_token"]').val(),
                                order: order,
                            }
                        }).done(function(res){
                            //alert(res);
                            Swal.fire({
                              position: 'top-end',
                                icon: 'success',
                                title: 'Rifas Re Ordenadas',
                                showConfirmButton: false,
                                timer: 2500
                            })
                        })

                    }
                }

            });
        </script>
    @endpush


@endsection
