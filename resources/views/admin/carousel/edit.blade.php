@extends('admin.default')

@section('page-header')
    Carousel <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
    {!! Form::model($item, [
            'route'  => [ ADMIN . '.carousel.update', $item->id ],
            'method' => 'put',
            'files'  => true
        ])
    !!}

    @include('admin.carousel.form')

    <button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>

    {!! Form::close() !!}

@stop
