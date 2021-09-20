@extends('admin.default')

@section('page-header')
    Countries <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">
        <button data-toggle="modal" data-target="#modalAddCountries" class="btn btn-info">
            {{ trans('app.add_button') }}
        </button>
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </tfoot>

                <tbody>
                @foreach($items as $country)
                    <tr>
                        <td>{{ $country->name }}</td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route(ADMIN . '.countries.edit', $country->idcountries) }}"
                                       title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm">
                                        <span class="ti-pencil"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => route(ADMIN . '.countries.destroy', $country->idcountries),
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

    @include('admin.countries.modal_form_countries')

@endsection
