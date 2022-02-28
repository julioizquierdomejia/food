<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\Dish;


class DashboardController extends Controller
{
    public function index()
    {   

        $usuarios = User::all();
        $menus = Menu::all();
        $platos = dish::all();

        return view('admin.dashboard.index', compact('usuarios', 'menus', 'platos'));
    }
}
