@extends('admin.default')

@section('page-header')
    <a href="{{ route('admin.categories.index') }}">Categories</a> <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
    {!! Form::model($item, [
            'route'  => [ ADMIN . '.categories.update', $item->idcategories ],
            'method' => 'put',
            'files'  => true
        ])
    !!}

    @include('admin.categories.form')

    <button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>

    {!! Form::close() !!}

@stop
