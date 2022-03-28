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
                <h3>{{ $usuarios->count() }}</h3>
                <p>Usuarios Registrados</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                Mas información <i class="fas fa-arrow-circle-right"></i>
            </a>
            </div>
        </div>
        
        <div class="col-12 col-md-3">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $menus->count() }}</h3>
                    <p>Menus Creados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-drumstick-bite"></i>
                </div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                    Mas información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>        

        </div>

        <div class="col-12 col-md-3">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>{{ $platos->count() }}</h3>
                    <p>Platos Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <a href="{{ route('admin.dishes.index') }}" class="small-box-footer">
                    Mas información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div> 
        </div>

        <div class="col-12 col-md-3">
            <div class="small-box bg-gradient-danger">
                <div class="inner">
                    <h3>{{ $ordenes->count() }}</h3>
                    <p>Pedidos realizados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <a href="{{ route('admin.dishes.index') }}" class="small-box-footer">
                    Mas información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div> 
        </div>


        <div class="col-12 col-md-3">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $ordenes_atendidas->count() }}</h3>
                    <p>Pedidos Atendidas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <a href="{{ route('admin.dishes.index') }}" class="small-box-footer">
                    Mas información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div> 
        </div>

        <div class="col-12 col-md-3">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>{{ $ordenes_canceladas->count() }}</h3>
                    <p>Pedidos Canceladas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <a href="{{ route('admin.dishes.index') }}" class="small-box-footer">
                    Mas información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div> 
        </div>


        <div class="col-12 col-md-3">
            <div class="small-box bg-gradient-info">
                <div class="inner">
                    <h3>{{ $ordenes_no_consumido->count() }}</h3>
                    <p>Pedidos No Consumidos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <a href="{{ route('admin.dishes.index') }}" class="small-box-footer">
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