<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Raffle;


class DashboardController extends Controller
{
    public function index()
    {   

        $usuarios = User::all();
        $sorteos = Raffle::where('status', 1)->get();

        return view('admin.dashboard.index', compact('usuarios', 'sorteos'));
    }
}
