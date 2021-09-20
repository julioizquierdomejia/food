@extends('admin.default')

@section('page-header')
    <a href="{{ route('admin.cities.index') }}">Cities</a> <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
    {!! Form::model($item, [
            'route'  => [ ADMIN . '.cities.update', $item->idcity ],
            'method' => 'put'
        ])
    !!}

    @include('admin.cities.form')

    <button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>

    {!! Form::close() !!}

@stop
