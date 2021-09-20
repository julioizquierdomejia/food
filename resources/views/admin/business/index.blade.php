@extends('admin.default')

@section('page-header')
    Business <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">
        <button data-toggle="modal" data-target="#modalAddBusiness" class="btn btn-info">
            {{ trans('app.add_button') }}
        </button>
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
                </tfoot>

                <tbody>
                @foreach($items as $business)
                    <tr>
                        <td>{{ $business->name }}</td>
                        <td>{{ $business->description }}</td>
                        <td>{{ $business->address }}</td>
                        <td>{{ $business->email }}</td>
                        <td>{{ $business->phone }}</td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route(ADMIN . '.business_gallery.detail', $business->idbusiness) }}"
                                       class="btn btn-warning btn-sm">
                                        <span class="ti-gallery"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{ route(ADMIN . '.business.edit', $business->idbusiness) }}"
                                       class="btn btn-primary btn-sm">
                                        <span class="ti-pencil"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => route(ADMIN . '.business.destroy', $business->idbusiness),
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

    @include('admin.business.modal_form_business')

@endsection
