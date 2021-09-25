@extends('admin.default')

@section('page-header')
    Producto <small>{{ trans('app.update_item') }}</small>
@stop
<!-- EDIT INPUTS FOR BUSINESS -->
@section('content')
    {!! Form::model($item, [
            'route'  => [ ADMIN . '.items.update', $item->id ],
            'method' => 'put',
            'files'  => true
        ])
    !!}

    @include('admin.items.form')

    <div class="row">
        <div class="mx-auto">
            <button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
            <a href="{{ route('admin.items.index') }}" class="ml-3">{{ trans('app.cancel_button') }}</a>
        </div>
    </div>
@stop
