@extends('admin.default')

@section('page-header')
    Rifa <small>{{ trans('app.update_item') }}</small>
@stop
<!-- EDIT INPUTS FOR BUSINESS -->
@section('content')
    {!! Form::model($raffle, [
            'route'  => [ ADMIN . '.raffles.update', $raffle->id ],
            'method' => 'put',
            'files'  => true
        ])
    !!}

    @include('admin.raffles.form')

    <div class="row">
        <div class="mx-auto">
            <button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
            <a href="{{ route('admin.raffles.index') }}" class="ml-3">{{ trans('app.cancel_button') }}</a>
        </div>
    </div>
@stop
