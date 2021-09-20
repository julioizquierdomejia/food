@extends('admin.default')

@section('page-header')
    <a href="{{ route('admin.countries.index') }}">Countries </a><small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
    {!! Form::model($item, [
            'route'  => [ ADMIN . '.countries.update', $item->idcountries ],
            'method' => 'put'
        ])
    !!}

    @include('admin.countries.form')

    <button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>

    {!! Form::close() !!}

@stop
