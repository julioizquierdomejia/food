@extends('admin.default')

@section('page-header')
    {{ $business->name }} <small>Business Gallery</small>
@endsection

@section('content')

    <div class="mB-20">
        <button data-toggle="modal" data-target="#modalAddGallery" class="btn btn-info">
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
                @foreach($itemGalery as $image)
                    <tr>
                        <td>{{ $image->nameimg }}</td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => route(ADMIN . '.business_gallery.delete', $image->idgaleryb),
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

    @include('admin.business.modal_form_gallery')

@endsection
