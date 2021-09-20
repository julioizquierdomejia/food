@extends('admin.default')

@section('page-header')
    Carousel <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
    {!! Form::open([
            'route' => [ ADMIN . '.carousel.store' ],
            'files' => true
        ])
    !!}

    @include('admin.carousel.form')

    <button type="submit" class="btn btn-primary">{{ trans('app.add_button') }}</button>

    {!! Form::close() !!}

@stop
