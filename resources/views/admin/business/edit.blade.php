@extends('admin.default')

@section('page-header')
    Business <small>{{ trans('app.update_item') }}</small>
@stop
<!-- EDIT INPUTS FOR BUSINESS -->
@section('content')
    {!! Form::model($item, [
            'route'  => [ ADMIN . '.business.update', $item->idbusiness ],
            'method' => 'put',
            'files'  => true
        ])
    !!}

    @include('admin.business.form')

    <div class="row">
        <button type="submit" class="btn btn-primary mx-auto">{{ trans('app.edit_button') }}</button>
    </div>
@stop
