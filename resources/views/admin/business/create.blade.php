@extends('admin.default')

@section('page-header')
    Business <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
    {!! Form::open([
            'route' => [ ADMIN . '.business.store' ],
            'files' => true
        ])
    !!}

    @include('admin.business.form')

    <button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>

    {!! Form::close() !!}

@stop
