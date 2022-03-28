<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\Dish;
use App\Models\Order;


class DashboardController extends Controller
{
    public function index()
    {   

        $usuarios = User::all();
        $menus = Menu::all();
        $platos = dish::all();
        $ordenes = Order::all();
        $ordenes_reservadas = Order::where('status', 1);
        $ordenes_atendidas = Order::where('status', 2);
        $ordenes_canceladas = Order::where('status', 3);
        $ordenes_no_consumido = Order::where('status', 4);

        return view('admin.dashboard.index', compact('usuarios', 'menus', 'platos', 'ordenes', 'ordenes_reservadas', 'ordenes_atendidas', 'ordenes_canceladas', 'ordenes_no_consumido'));
    }
}
