@extends('admin.default')

@section('page-header')
    Productos <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">
        <button data-toggle="modal" data-target="#modalAddItems" class="btn btn-info">
            {{ trans('app.add_button') }}
        </button>
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th style="width: 25%">Nombre</th>
                    <th style="width: 40%">Descripción</th>
                    <th style="width: 25%">Precio</th>
                    <th style="width: 10%">Acciones</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
                </tfoot>

                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route(ADMIN . '.items.edit', $item->id) }}"
                                       class="btn btn-primary btn-sm">
                                        <span class="ti-pencil"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class' => 'delete',
                                        'url'  => route(ADMIN . '.items.destroy', $item->id),
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

    @include('admin.items.modal_form_item')

@endsection
