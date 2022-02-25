@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Reportes del Aplicativo</p>

    <div class="row">
        <div class="col-12 col-md-3">
            <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $sorteos->count() }}</h3>
                <p>Sorteos Activos</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('admin.raffle.index') }}" class="small-box-footer">
                Mas información <i class="fas fa-arrow-circle-right"></i>
            </a>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $usuarios->count() }}</h3>
                    <p>Usuarios Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="{{ route('admin.raffle.index') }}" class="small-box-footer">
                    Mas información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>        

        </div>
    </div>
        
        
    


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    
@stop